<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $statuses = OrderStatus::all();
        return view('admin.orderStatus.index',compact('statuses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'sl'=>'required',
            'name'=>'required|max:150|unique:order_statuses,name',
        ));

        $orderStatus = new OrderStatus;
        $orderStatus->name = $request->name;
        $orderStatus->sl = $request->sl;
        $orderStatus->save();
        session()->flash('success','Successfully Save');
        return redirect()->back();
    }

    public function show(OrderStatus $orderStatus)
    {
        //
    }

    public function edit(OrderStatus $orderStatus)
    {
        if($orderStatus->is_default == 1){
            session()->flash('warning','This Item not Editable');
            return redirect()->back();
        }
        return view('admin.orderStatus.edit',compact('orderStatus'));
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $this->validate($request, array(
            'sl'=>'required',
            'name'=>'required|max:150|unique:order_statuses,name,'.$orderStatus->id,
        ));

        $orderStatus->name = $request->name;
        $orderStatus->sl = $request->sl;
        $orderStatus->status = $request->status;
        $orderStatus->save();
        session()->flash('success','Successfully Save');
        return redirect()->back();
    }

    public function destroy(OrderStatus $orderStatus)
    {
        //
    }
}
