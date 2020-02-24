<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;
use App\Table;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Reservation as ReservationResource;
use App\Http\Resources\ReservationCollection as ReservationsResource;
//Spatie uses
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;

class ReservationController extends BaseController
{

    public function index()
    {
        $user_id = Auth::id();

        try {
            $reservations = QueryBuilder::for(Reservation::where('user_id', $user_id))
            ->allowedFilters([AllowedFilter::exact('status'), AllowedFilter::exact('seats'), 'date'])
            ->defaultSort('id')
            ->allowedSorts(['date', 'seats'])
            ->paginate(15)
            ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }catch(InvalidSortQuery $e){
            return $this->sendError('Sort invalido', $e->getMessage());
        }

        return new ReservationsResource($reservations);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($input['date'] < time()){
             return $this->sendError('Validation Error.', 'La fecha ya paso o esta muy proxima. Sugerimos reservar con al menos 15 minutos de antelacion');
        }     

        $validator = Validator::make($input, [
            'seats' => 'required|integer',
        ]);

        $availableTables = Table::where('chairs', '>=', $input['seats'])->first();

        if(empty($availableTables)){
            return $this->sendError('Capacidad excedida', 'No hay mesas con esa cantidad de espacio disponible');
        }

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_id = Auth::id();

        $reservation = Reservation::create([
            'user_id' => $user_id,
            'status' => 'pending',
            'seats' => $input['seats'],
            'date' => date("Y/m/d H:i:s", $input['date']), 
            'comments' => $input['comments']
        ]);


        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return $this->sendResponse([], 'Reservation deleted successfully.');
    }
}
