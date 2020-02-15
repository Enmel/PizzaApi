<?php  

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Food;
use App\FoodCategory;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
  
class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::paginate(15);

        return view('foods.index',compact('foods'))
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
            'name' => 'required|max:250',
            'size' => [
                'required',
                Rule::in(['small', 'medium', 'big']),
            ],
            'category' => 'required|exists:App\FoodCategory,id',
            'price' => 'required',
            'description' => 'max:512'
        ]);
  
        $food = Food::create($request->all());

        if($request->hasFile('image')){
            $food->addMediaFromRequest('image')->toMediaCollection('images');
        }
   		
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
  
    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|max:250',
            'size' => [
                'required',
                Rule::in(['small', 'medium', 'big']),
            ],
            'category' => 'required|exists:App\FoodCategory,id',
            'price' => 'required',
            'description' => 'max:512'
        ]);
  
        $food->update($request->all());

        if($request->hasFile('image')){
            $food->clearMediaCollection('images');
            $food->addMediaFromRequest('image')->toMediaCollection('images');
        }
  
        return redirect()->route('foods.index')
                        ->with('success','Food updated successfully');
    }
  
    public function destroy(Food $food)
    {
        $food->delete();
  
        return redirect()->route('foods.index')
                        ->with('success','Food deleted successfully');
    }
}