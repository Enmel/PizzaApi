<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Table;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Http\Resources\Table as TableResource;
use App\Http\Resources\TableCollection as TablesResource;

class TableController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Table::all();
        return $this->sendResponse(new TablesResource($table), 'Tables retrieved successfully.');
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
            'name' => 'required|unique:tables'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $table = Table::create($input);

        return $this->sendResponse(new TableResource($table), 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Table::find($id);

        if (is_null($table)) {
            return $this->sendError('Table not found.');
        }

        return $this->sendResponse(new TableResource($table), 'Table retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Table $table)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $table->name = $input['name'];
        $table->save();

        return $this->sendResponse(new TableResource($table), 'Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return $this->sendResponse([], 'Table deleted successfully.');
    }
}
