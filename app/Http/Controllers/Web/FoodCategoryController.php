<?php  

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\FoodCategory;
use Illuminate\Http\Request;
  
class FoodCategoryController extends Controller
{
    public function index()
    {
        $foodcategories = FoodCategory::paginate(15);
  
        return view('foodcategories.index',compact('foodcategories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    public function create()
    {
        return view('foodcategories.create');
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:256|string'
        ]);
  
        $category = FoodCategory::create($request->all());

        if($request->hasFile('image')){
            $category->addMediaFromRequest('image')->toMediaCollection('images');
        }
   		
        return redirect()->route('foodcategories.index')->with('success', 'FoodCategory Created Successfully!');
    }
   
    public function show(FoodCategory $foodcategory)
    {
        return view('foodcategories.show',compact('foodcategory'));
    }
   
    public function edit(FoodCategory $foodcategory)
    {
        return view('foodcategories.edit',compact('foodcategory'));
    }
  
    public function update(Request $request, FoodCategory $foodcategory)
    {
        $request->validate([
            'name' => 'required|max:256|string'
        ]);
  
        $foodcategory->update($request->all());

        if($request->hasFile('image')){
            $foodcategory->clearMediaCollection('images');
            $foodcategory->addMediaFromRequest('image')->toMediaCollection('images');
        }
  
        return redirect()->route('foodcategories.index')
                        ->with('success','FoodCategory updated successfully');
    }
  
    public function destroy(FoodCategory $foodcategory)
    {
        $foodcategory->delete();
  
        return redirect()->route('foodcategories.index')
                        ->with('success','FoodCategory deleted successfully');
    }
}