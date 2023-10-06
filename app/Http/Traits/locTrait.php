<?php
namespace App\Http\Traits;

use App\LocationCountry;
use App\LocationState;
use App\LocationCity;

trait locTrait {

    public function countryArray() {
        $userAll = LocationCountry::all();
        $users=array();
        foreach ($userAll as $data) {
            $users[$data->sortname]= $data->name;
        }
        return $users;
    }

    public function stateArray($country){
        $states = array();
        $country = LocationCountry::where('sortname',$country)->first();
        if($country){
            $state = LocationState::where('country_id',$country->id)->get();
            foreach ($state as $value) {
                $states[$value->id] = $value->name;
            }
        }
        return $states;
    }

}
