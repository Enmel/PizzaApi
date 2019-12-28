<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Table;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Http\Resources\Table as TableResource;
use App\Http\Resources\TableCollection as TablesResource;
//Spatie uses
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;

class TableController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $tables = QueryBuilder::for(Table::class)
            ->allowedFilters([AllowedFilter::scope( 'available_seats','has_seats'), 'name'])
            ->defaultSort('id')
            ->allowedSorts('chairs')
            ->paginate(15)
            ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }

        return new TablesResource($tables);
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

        return new TableResource($table);
    }

}
