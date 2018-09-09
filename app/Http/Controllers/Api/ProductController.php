<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\ProductRequest;

use App\Repositories\Api\ProductRepository;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\SubcategoryRepository;
use App\Repositories\Api\BrandRepository;

use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\SubcategoryResource;
use App\Http\Resources\Api\BrandResource;

class ProductController extends Controller
{

    private $productRepository;
    private $categoryRepository;
    private $subcategoryRepository;
    private $brandRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, SubcategoryRepository $subcategoryRepository, BrandRepository $brandRepository) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');

        $categories = [];
        $subcategories = [];
        $brands = [];
        if(trim($search) != '') {
            $categories = CategoryResource::collection($this->categoryRepository->index());
            $subcategories = SubcategoryResource::collection($this->subcategoryRepository->index());
            $brands = BrandResource::collection($this->brandRepository->index());
        }

        return $this->buildApiResponse([
            'products' => ProductResource::collection($this->productRepository->index()),
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($_id)
    {
        return $this->buildApiResponse([
            'product' => new ProductResource($this->productRepository->show($_id))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        return $this->buildApiResponse([
            'product' => new ProductResource($this->productRepository->store($request->get('product'), $request->get('brand'), $request->get('categories')))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $_id)
    {
        return $this->buildApiResponse([
            'product' => new ProductResource($this->productRepository->update($request->get('product'), $request->get('brand'), $request->get('categories'), $_id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($_id)
    {
        return $this->buildApiResponse([
            'product' => new ProductResource($this->productRepository->delete($_id))
        ]);
    }
}
