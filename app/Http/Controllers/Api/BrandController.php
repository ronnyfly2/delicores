<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\BrandRequest;

use App\Repositories\Api\BrandRepository;

use App\Http\Resources\Api\BrandResource;

class BrandController extends Controller
{

    private $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->buildApiResponse([
            'brands' => BrandResource::collection($this->brandRepository->index())
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
            'brand' => new BrandResource($this->brandRepository->show($_id))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        return $this->buildApiResponse([
            'brand' => new BrandResource($this->brandRepository->store($request->get('brand')))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $_id)
    {
        return $this->buildApiResponse([
            'brand' => new BrandResource($this->brandRepository->update($request->get('brand'), $_id))
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
            'brand' => new BrandResource($this->brandRepository->delete($_id))
        ]);
    }
}
