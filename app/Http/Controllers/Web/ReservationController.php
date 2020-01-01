<?php  

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
  
class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::paginate(15);

        return view('reservations.index', compact('reservations'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    public function status(Reservation $reservation)
    {
        $date = new Carbon($reservation->date);

        if($date->lt(Carbon::now())){
            return redirect()->route('reservations.index')->with('danger', 'No se puede cambiar los estados de reservaciones cuya fecha ya paso');
        }

        if($reservation->status == 'accepted'){
            $reservation->status = 'rejected';
        }else {
            $reservation->status = 'accepted';
        }

        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Cambio de estado realizado con exito');
    }
  
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
  
        return redirect()->route('reservations.index')
                        ->with('success','Reservation deleted successfully');
    }
}