<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Food;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Food as FoodResource;
use App\Http\Resources\FoodCollection as FoodsResource;

class FoodController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food = Food::all();
        return $this->sendResponse(new FoodsResource($food), 'Foods retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:App\Food|max:250',
            'size' => [
                'required',
                Rule::in(['small', 'medium', 'big']),
            ],
            'category' => 'required|exists:App\FoodCategory,id',
            'price' => 'required',
            'description' => 'max:512'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $food = Food::create($input);

        return $this->sendResponse(new FoodResource($food), 'Food created successfully.');
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

        return $this->sendResponse(new FoodResource($food), 'Food retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:foods|max:250',
            'price' => 'required',
            'size' => [
                Rule::in(['small', 'medium', 'big']),
            ],
            'description' => 'required|max:512'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $food->name = $input['name'];
        $food->size = $input['size'];
        $food->price = $input['price'];
        $food->description = $input['description'];
        $food->save();

        return $this->sendResponse(new FoodResource($food), 'Food updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return $this->sendResponse([], 'Food deleted successfully.');
    }
}
