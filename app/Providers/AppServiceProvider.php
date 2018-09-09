<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\Resource;

use Illuminate\Support\Facades\Validator;
use Facades\App\Repositories\Api\BrandRepository;
use Facades\App\Repositories\Api\CategoryRepository;
use Facades\App\Repositories\Api\SubCategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Resource::withoutWrapping();

        Validator::extend('valid_brand', function ($attribute, $_id, $parameters, $validator) {
            try {
                $brand = BrandRepository::show($_id);
                return TRUE;
            } catch (\Exception $e) {
                return FALSE;
            }
        });

        Validator::extend('valid_category', function ($attribute, $_id, $parameters, $validator) {
            try {
                $category = CategoryRepository::show($_id);
                return TRUE;
            } catch (\Exception $e) {
                return FALSE;
            }
        });

        Validator::extend('valid_subcategory', function ($attribute, $_id, $parameters, $validator) {
            try {

                $inputs = $validator->getData();
                $attribute_explode = explode('.', $attribute);

                $subcategory = SubCategoryRepository::show($inputs[$attribute_explode[0]][$attribute_explode[1]]['_id'], $_id);
                return TRUE;
            } catch (\Exception $e) {
                return FALSE;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
