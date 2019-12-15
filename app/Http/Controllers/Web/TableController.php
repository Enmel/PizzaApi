<?php  

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Table;
use Illuminate\Http\Request;
  
class TableController extends Controller
{
    public function index()
    {
        $tables = Table::paginate(15);
  
        return view('tables.index',compact('tables'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    public function create()
    {
        return view('tables.create');
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:256|string',
            'chairs' => 'required|integer',
            'description' => 'max:512|string|nullable'
        ]);
  
        Table::create($request->all());
   		
        return redirect()->route('tables.index')->with('success', 'Table Created Successfully!');
    }
   
    public function show(Table $table)
    {
        return view('tables.show',compact('table'));
    }
   
    public function edit(Table $table)
    {
        return view('tables.edit',compact('table'));
    }
  
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|max:256|string',
            'chairs' => 'required|integer',
            'description' => 'max:512|string|nullable'
        ]);
  
        $table->update($request->all());
  
        return redirect()->route('tables.index')
                        ->with('success','Table updated successfully');
    }
  
    public function destroy(Table $table)
    {
        $table->delete();
  
        return redirect()->route('tables.index')
                        ->with('success','Table deleted successfully');
    }
}