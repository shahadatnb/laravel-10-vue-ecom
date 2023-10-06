<?php
namespace App\Http\Traits;

use App\TypeOfBody;
use App\AgentWallet;
use App\User;
use Auth;

trait mixTrait {

    public function acList($acType){
        $users = User::whereHas('roles', function($q) use ($acType){
            $q->where('name', $acType);
        })->get();

        return $users;
    }

    public function usersArray($acType) {
        $userAll = $this->acList($acType);
        $users=array();
        foreach ($userAll as $data) {
            $users[$data->id]= $data->id.' - '.$data->name;
        }
        return $users;
    }

    public function TypeOfBodyArray() {
        $TypeOfBody = TypeOfBody::all();
        $TypeOfBodys=array();
        foreach ($TypeOfBody as $data) {
            $TypeOfBodys[$data->id]= $data->name;
        }
        return $TypeOfBodys;
    }

    public function agentBallance($id){
        $data = AgentWallet::where('agent_id',$id)->sum('receive');
        $data2 = AgentWallet::where('agent_id',$id)->sum('payment');
        return $data-$data2;
    }

    public function agentBallanceAll(){
        $data = AgentWallet::sum('receive');
        $data2 = AgentWallet::sum('payment');
        return $data-$data2;
    }

    public function todayReceive(){
        $data = AgentWallet::whereBetween('created_at', array(date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'))->sum('payment');
        return $data;
    }

    public function todayPayment(){
        $data = AgentWallet::whereBetween('created_at', array(date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'))->sum('receive');
        return $data;
    }
 

    public function systemUser(){
    	return User::count();
    }


}
