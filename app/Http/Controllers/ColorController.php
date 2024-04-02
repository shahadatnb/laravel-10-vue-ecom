<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function getColors(){
        $colors = Color::all();
        return response()->json($colors);
    }

    public function create()
    {
        return view('admin.colors.createOrEdit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors',
            'code' => 'required',
        ]);

        $color = new Color;
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        session()->flash('success', 'Color created successfully');
        return redirect()->route('color.index');
    }

    public function show(Color $color)
    {
        
    }

    public function edit(Color $color)
    {
        return view('admin.colors.createOrEdit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|unique:colors,name,' . $color->id,
            'code' => 'required',
        ]);
        
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        session()->flash('success', 'Color updated successfully');
        return redirect()->route('color.index');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        session()->flash('success', 'Color deleted successfully');
        return redirect()->route('color.index');
    }
}
