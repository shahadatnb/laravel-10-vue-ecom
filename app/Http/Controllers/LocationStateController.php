<?php

namespace App\Http\Controllers;

use App\Models\LocationState;
use App\Models\LocationCountry;
use Illuminate\Http\Request;
use App\Http\Traits\locTrait;

class LocationStateController extends Controller
{
    use locTrait;
    public function index()
    {
        $sortname = config('settings.defaultCountry','BD');
        $country = LocationCountry::where('sortname', $sortname)->first();
        $locationStates = LocationState::where('country_id', $country->id)->get();
        return view('admin.location.state.index', compact('locationStates'));
    }

    public function create()
    {
        $sortname = config('settings.defaultCountry','BD');
        $countries = LocationCountry::where('sortname', $sortname)->pluck('name', 'id');
        return view('admin.location.state.createOrEdit', compact('countries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'name'=>'required|string',
            'country_id'=>'required',
        ));
        $locationState = new LocationState;
        $locationState->name = $request->name;
        $locationState->country_id = $request->country_id;
        $locationState->save();
        session()->flash('success','Successfully Save');
        return redirect()->route('locationState.index');
    }

    public function show(LocationState $locationState)
    {
        //
    }

    public function edit(LocationState $locationState)
    {
        $sortname = config('settings.defaultCountry','BD');
        $countries = LocationCountry::where('sortname', $sortname)->pluck('name', 'id');
        return view('admin.location.state.createOrEdit', compact('locationState', 'countries'));
    }

    public function update(Request $request, LocationState $locationState)
    {
        $this->validate($request, array(
            'name'=>'required|string',
            'country_id'=>'required',
        ));
        $locationState->name = $request->name;
        $locationState->country_id = $request->country_id;
        $locationState->save();
        session()->flash('success','Successfully Save');
        return redirect()->route('locationState.index');
    }

    public function destroy(LocationState $locationState)
    {
        $locationState->delete();
        session()->flash('success','Successfully Deleted');
        return redirect()->route('locationState.index');
    }
}
