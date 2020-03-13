<?php

namespace App\Http\Controllers\WEB;

use App\FoodCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $foodcategories = FoodCategory::paginate(15);

        return view('foodcategories.index', compact('foodcategories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('foodcategories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:256|string',
            'very_small_label' => 'required|max:256|string',
            'small_label' => 'required|max:256|string',
            'medium_label' => 'required|max:256|string',
            'large_label' => 'required|max:256|string',
            'very_large_label' => 'required|max:256|string',
        ]);

        if (!$request->hasFile('image')) {
            return redirect()->route('foodcategories.index')->with('error', 'Debe cargar una imagen');
        }

        $category = FoodCategory::create($request->all());
        $category->addMediaFromRequest('image')->toMediaCollection('images');

        return redirect()->route('foodcategories.index')->with('success', 'Categoria creada exitosamente!');
    }

    public function show(FoodCategory $foodcategory)
    {
        return view('foodcategories.show', compact('foodcategory'));
    }

    public function edit(FoodCategory $foodcategory)
    {
        return view('foodcategories.edit', compact('foodcategory'));
    }

    public function update(Request $request, FoodCategory $foodcategory)
    {
        $request->validate([
            'name' => 'required|max:256|string',
            'very_small_label' => 'required|max:256|string',
            'small_label' => 'required|max:256|string',
            'medium_label' => 'required|max:256|string',
            'large_label' => 'required|max:256|string',
            'very_large_label' => 'required|max:256|string',
        ]);

        if ($request->hasFile('image')) {
            $foodcategory->clearMediaCollection('images');
            $foodcategory->addMediaFromRequest('image')->toMediaCollection('images');
        }

        $foodcategory->update($request->all());

        return redirect()->route('foodcategories.index')
            ->with('success', 'Categoria actualizada con exito');
    }

    public function destroy(FoodCategory $foodcategory)
    {
        $foodcategory->delete();

        return redirect()->route('foodcategories.index')
            ->with('success', 'Categoria borrada con exito');
    }
}
