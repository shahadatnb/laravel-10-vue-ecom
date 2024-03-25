<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.createOrEdit');
    }

    public function store(Request $request)
    {
        $size = new Size;
        $size->name = $request->name;
        $size->save();
        session()->flash('success', 'Size created successfully');
        return redirect()->route('size.index');
    }

    public function show(Size $size)
    {
        //
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.createOrEdit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $size->name = $request->name;
        $size->save();
        session()->flash('success', 'Size updated successfully');
        return redirect()->route('size.index');
    }


    public function destroy(Size $size)
    {
        $size->delete();
        session()->flash('success', 'Size deleted successfully');
        return redirect()->route('size.index');
    }
}
