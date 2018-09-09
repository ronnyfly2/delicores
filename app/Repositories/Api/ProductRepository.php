<?php

namespace App\Repositories\Api;

use App\Product;

use App\Repositories\RepositoryBase;
use App\ProductCategory;

class ProductRepository extends RepositoryBase
{

    // Constructor to bind model to repo
    public function __construct()
    {
    }

    // Get all instances of model
    public function index()
    {

        $order = request('sort_by');
        $category_id = request('category_id');
        $subcategory_id = request('subcategory_id');
        $brand_id = request('brand_id');
        $outstanding = request('outstanding');
        $search = request('search');

        $products = Product::active();

        if($order) {
            if($order == 'desc')
                $products = $products->orderBy('name', 'DESC');
            else if($order == 'asc')
                $products = $products->orderBy('name', 'ASC');
            else if($order == 'price_desc')
                $products = $products->orderBy('price1', 'DESC');
            else if($order == 'price_asc')
                $products = $products->orderBy('price1', 'ASC');
        }

        if($category_id) {
            $category_id_explode = explode(',', $category_id);
            $category_id_arr = [];
            foreach ($category_id_explode as $category) {
                $category_id_arr[] = $this->hashids_decode($category);
            }

            $products->whereHas('product_categories', function($q) use ($category_id_arr) {
                $q->whereIn('product_categories.category_id', $category_id_arr);
            });
        }

        if($subcategory_id) {
            $subcategory_id_explode = explode(',', $subcategory_id);
            $subcategory_id_arr = [];
            foreach ($subcategory_id_explode as $subcategory) {
                $subcategory_id_arr[] = $this->hashids_decode($subcategory);
            }

            $products->whereHas('product_subcategories', function($q) use ($subcategory_id_arr) {
                $q->whereIn('product_categories.category_id', $subcategory_id_arr);
            });
        }

        if($brand_id) {
            $brand_id_explode = explode(',', $brand_id);
            $brand_id_arr = [];
            foreach ($brand_id_explode as $brand) {
                $brand_id_arr[] = $this->hashids_decode($brand);
            }

            $products = $products->whereIn('brand_id', $brand_id_arr);
        }

        if($outstanding)
            $products = $products->where('outstanding', 1);

        if($search)
            $products = $products->where('name', 'like', '%' . $search . '%');

        return $products->get();
    }

    // show the record with the given id
    public function show($_id)
    {
        return $this->find(new Product(), $_id);
    }

    // create a new record in the database
    public function store(array $product_data, array $brand_data, array $categories_data)
    {
        $product_data['brand_id'] = $this->hashids_decode($brand_data['_id']);
        $product = Product::create($product_data);

        foreach ($categories_data as $category) {

            ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $this->hashids_decode($category['_id']),
                'type' => 'category'
            ]);

            foreach ($category['subcategories'] as $subcategory) {
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $this->hashids_decode($subcategory['_id']),
                    'type' => 'subcategory'
                ]);
            }
        }
        return $product;
    }

    // update record in the database
    public function update(array $product_data, array $brand_data, array $categories_data, $_id)
    {

        $record = $this->show($_id);

        $product_data['brand_id'] = $this->hashids_decode($brand_data['_id']);
        $record->update($product_data);

        ProductCategory::where('product_id', $record->id)->update(
            ['state' => 3]
        );

        foreach ($categories_data as $category) {

            ProductCategory::create([
                'product_id' => $record->id,
                'category_id' => $this->hashids_decode($category['_id']),
                'type' => 'category'
            ]);

            foreach ($category['subcategories'] as $subcategory) {
                ProductCategory::create([
                    'product_id' => $record->id,
                    'category_id' => $this->hashids_decode($subcategory['_id']),
                    'type' => 'subcategory'
                ]);
            }
        }

        return $record;
    }

    // remove record from the database
    public function delete($_id)
    {
        $record = $this->show($_id);
        $record->state = 3;
        $record->save();

        return $record;
    }
}
