<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Food;
use App\FoodCategory;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Food as FoodResource;
use App\Http\Resources\FoodCollection as FoodsResource;

//Spatie uses
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;

class FoodController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $foods = QueryBuilder::for(Food::class)
            ->allowedFilters(['name', AllowedFilter::exact('size'), AllowedFilter::exact('category')])
            ->defaultSort('id')
            ->allowedSorts('name', 'price')
            ->paginate(15)
            ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }catch(InvalidSortQuery $e){
            return $this->sendError('Sort invalido', $e->getMessage());
        }

        return new FoodsResource($foods);
    }

    public function promotions()
    {

        $FoodCategory = FoodCategory::where("name", "Promociones")->get()->first();

        try{
            $foods = QueryBuilder::for(Food::where("category", $FoodCategory->id))
            ->allowedFilters(['name', AllowedFilter::exact('size')])
            ->defaultSort('id')
            ->allowedSorts('name', 'price')
            ->paginate(15)
            ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }catch(InvalidSortQuery $e){
            return $this->sendError('Sort invalido', $e->getMessage());
        }

        return new FoodsResource($foods);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        if (is_null($food)) {
            return $this->sendError('Food not found.');
        }

        return new FoodResource($food);
    }
}
