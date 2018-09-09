<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\CategoryRequest;

use App\Repositories\Api\CategoryRepository;

use App\Http\Resources\Api\CategoryResource;

class CategoryController extends Controller
{

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->buildApiResponse([
            'categories' => CategoryResource::collection($this->categoryRepository->index())
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
            'category' => new CategoryResource($this->categoryRepository->show($_id))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        return $this->buildApiResponse([
            'category' => new CategoryResource($this->categoryRepository->store($request->get('category')))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $_id)
    {
        return $this->buildApiResponse([
            'category' => new CategoryResource($this->categoryRepository->update($request->get('category'), $_id))
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
            'category' => new CategoryResource($this->categoryRepository->delete($_id))
        ]);
    }
}
