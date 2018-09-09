<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\SubCategoryRequest;

use App\Repositories\Api\SubCategoryRepository;

use App\Http\Resources\Api\SubCategoryResource;

class SubCategoryController extends Controller
{

    private $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository) {
        $this->subCategoryRepository = $subCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($_category_id)
    {
       return $this->buildApiResponse([
            'subcategories' => SubCategoryResource::collection($this->subCategoryRepository->index($_category_id))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($_category_id, $_sub_category_id)
    {
        return $this->buildApiResponse([
             'subcategory' => new SubCategoryResource($this->subCategoryRepository->show($_category_id, $_sub_category_id))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request, $_category_id)
    {
        return $this->buildApiResponse([
             'subcategory' => new SubCategoryResource($this->subCategoryRepository->store($request->get('subcategory'), $_category_id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, $_category_id, $_sub_category_id)
    {
        return $this->buildApiResponse([
            'subcategory' => new SubCategoryResource($this->subCategoryRepository->update($request->get('subcategory'), $_category_id, $_sub_category_id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($_category_id, $_sub_category_id)
    {
        return $this->buildApiResponse([
            'subcategory' => new SubCategoryResource($this->subCategoryRepository->delete($_category_id, $_sub_category_id))
        ]);
    }
}
