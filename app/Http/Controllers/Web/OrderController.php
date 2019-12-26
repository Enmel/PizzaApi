<?php  

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
  
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(15);

        return view('orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    public function create()
    {
        $categories = FoodCategory::all();
        return view('foods.create', compact('categories'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:App\Food|max:250',
            'size' => [
                'required',
                Rule::in(['small', 'medium', 'big']),
            ],
            'category' => 'required|exists:App\FoodCategory,id',
            'price' => 'required',
            'description' => 'max:512'
        ]);
  
        Food::create($request->all());
   		
        return redirect()->route('foods.index')->with('success', 'Food Created Successfully!');
    }
   
    public function show(Food $food)
    {
        return view('foods.show',compact('food'));
    }
   
    public function edit(Food $food)
    {
        $categories = FoodCategory::all();
        return view('foods.edit',compact(['food', 'categories']));
    }

    public function update(Order $order)
    {
        var_dump($order);
        exit;
        return redirect()->route('foods.index')->with('success', 'Food Created Successfully!');
    }

    public function paidout(Order $order)
    {
    	$order->paidout = (integer)!$order->paidout;
        $order->save();

        if($order->paidout === 1){
            return redirect()->route('orders.index')->with('success', 'Orden pagada!');
        }

        return redirect()->route('orders.index')->with('danger', 'Pago de orden cancelado');
    }

    public function status(Order $order)
    {
        if($order->status === 'pending'){
        	$order->status = 'accepted';
        	$order->save();
            return redirect()->route('orders.index')->with('success', 'Orden pagada!');
        }

        return redirect()->route('orders.index')->with('danger', 'Pago de orden ya confirmado.');
    }
  
    public function destroy(Order $order)
    {
        $order->delete();
  
        return redirect()->route('order.index')
                        ->with('success','Order deleted successfully');
    }
}