<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Pizza;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Pizza as PizzaResource;
use App\Http\Resources\PizzaCollection as PizzasResource;

class PizzaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pizza = Pizza::all();
        return $this->sendResponse(new PizzasResource($pizza), 'Pizzas retrieved successfully.');
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
            'name' => 'required|unique:pizzas|max:250',
            'size' => [
                'required',
                Rule::in(['small', 'medium', 'big']),
            ],
            'price' => 'required',
            'description' => 'max:512'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $pizza = Pizza::create($input);

        return $this->sendResponse(new PizzaResource($pizza), 'Pizza created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pizza $pizza)
    {
        if (is_null($pizza)) {
            return $this->sendError('Pizza not found.');
        }

        return $this->sendResponse(new PizzaResource($pizza), 'Pizza retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pizza $pizza)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:pizzas|max:250',
            'price' => 'required',
            'size' => [
                Rule::in(['small', 'medium', 'big']),
            ],
            'description' => 'required|max:512'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $pizza->name = $input['name'];
        $pizza->size = $input['size'];
        $pizza->price = $input['price'];
        $pizza->description = $input['description'];
        $pizza->save();

        return $this->sendResponse(new PizzaResource($pizza), 'Pizza updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pizza $pizza)
    {
        $pizza->delete();

        return $this->sendResponse([], 'Pizza deleted successfully.');
    }
}
