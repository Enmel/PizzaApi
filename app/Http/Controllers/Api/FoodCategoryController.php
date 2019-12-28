<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\FoodCategory;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\FoodCategory as FoodCategoryResource;
use App\Http\Resources\FoodCategoryCollection as FoodCategoriesResource;
//Spatie uses
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;

class FoodCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = FoodCategory::all();

        try {
            $categories = QueryBuilder::for(FoodCategory::class)
            ->allowedFilters(['name'])
            ->defaultSort('id')
            ->allowedSorts('name', 'created_at')
            ->paginate(15)
            ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }

        return new FoodCategoriesResource($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCategory $category)
    {
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }

        return new FoodCategoryResource($category);
    }
}
