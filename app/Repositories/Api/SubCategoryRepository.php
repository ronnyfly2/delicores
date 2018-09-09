<?php

namespace App\Repositories\Api;

use App\Category;

use App\Repositories\RepositoryBase;

class SubCategoryRepository extends RepositoryBase
{

    // Constructor to bind model to repo
    public function __construct()
    {
    }

    public function index($_category_id = FALSE)
    {
        $search = request('search');

        $subcategories =  Category::whereNotNull('category_id')->active();
        if($_category_id) {
            $category = $this->find(new Category(), $_category_id);

            $subcategories = $subcategories->where('category_id', $category->id);
        }

        if($search)
            $subcategories = $subcategories->where('name', 'like', '%' . $search . '%');

        return $subcategories->get();
    }

    // show the record with the given id
    public function show($_category_id, $_sub_category_id)
    {
        $category = $this->find(new Category(), $_category_id);

        $subcategory = Category::where([
            ['id', '=', $this->hashids_decode($_sub_category_id)],
            ['category_id', '=', $category->id]
        ])->active()->first();

        if(!$subcategory)
            throw new \Exception(_i("El ID ingresado no esa válido."), 400);

        return $subcategory;
    }

    // create a new record in the database
    public function store(array $data, $_category_id)
    {
        $category = $this->find(new Category(), $_category_id);

        $data['category_id'] = $category->id;
        return Category::create($data);
    }

    // update record in the database
    public function update(array $data, $_category_id, $_sub_category_id)
    {
        $record = $this->show($_category_id, $_sub_category_id);
        $record->update($data);

        return $record;
    }

    // remove record from the database
    public function delete($_category_id, $_sub_category_id)
    {
        $record = $this->show($_category_id, $_sub_category_id);
        $record->state = 3;
        $record->save();

        return $record;
    }
}
