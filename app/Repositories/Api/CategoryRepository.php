<?php

namespace App\Repositories\Api;

use App\Category;

use App\Repositories\RepositoryBase;

class CategoryRepository extends RepositoryBase
{

    // Constructor to bind model to repo
    public function __construct()
    {
    }

    // Get all instances of model
    public function index()
    {
        $search = request('search');

        $categories = Category::active()->whereNull('category_id');

        if($search)
            $categories = $categories->where('name', 'like', '%' . $search . '%');

        return $categories->get();
    }

    // show the record with the given id
    public function show($_id)
    {
        return $this->find(new Category(), $_id);
    }

    // create a new record in the database
    public function store(array $data)
    {
        return Category::create($data);
    }

    // update record in the database
    public function update(array $data, $_id)
    {
        $record = $this->show($_id);
        $record->update($data);

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
