<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Traits\Wallets;
//use App\MobileVerify;
use App\Models\User;
use Session;
use Auth;

class ProfileController extends Controller
{    //use Wallets;

    public function __construct()
    {
        //$this->middleware(['auth','verified']);
    }

    public function index(){
        $user = User::find(Auth::user()->id);
        return view('admin.profile.profile',compact('user'));
    }

    public function fourceLogin($id){
        $user = User::find($id);
        if($user){
           Auth::loginUsingId($id); 
           return redirect()->route('dashboard');
        }
        Session::flash('waining','User can`t find');
        return redirect()->back();
    }
    
    public function userCreate(){
        $mode = 'create';
        return view('admin.profile.create', compact('mode'));
    }

    public function userStore(Request $request){
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'email' => ['required','email','max:40','unique:users,email'],
            'mobile' => 'required',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ));

        $user = new User;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success','Successfully Save');
        return redirect()->route('userRole');
    }
    
    public function userEdit($id){
        $user = User::find($id);
        $mode = 'edit';
        return view('admin.profile.create', compact('user','mode'));
    }

    public function userUpdate(Request $request, $id){
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'email' => ['required','email','max:40','unique:users,email,'. $id],
            'mobile' => 'required',
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ));

        $user = User::find($id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }        
        $user->save();

        session()->flash('success','Successfully Save');
        return redirect()->route('userRole');
    }

    public function userDelete($id){
        $user = User::find($id);
        $user->delete();
        session()->flash('success','Successfully Delete');
        return redirect()->route('userRole');
    }

// ##  User List
    public function users($id)
    {
        if($id==0){
            $id=Auth::User()->id;
        }

        $user = User::find($id);
        if($user){
            return view('admin.users.userList',compact('user'));
        }else{
            return redirect()->back();
        }
        
    }

    public function profileView($id){
       $user = User::find($id);
        return view('admin.profile.profile',compact('user')); 
    }

    public function editProfile(){
        $user = User::find(Auth::User()->id);
        return view('admin.profile.editProfile',compact('user'));
    }

    public function updateProfile(Request $request){
        $user_id = Auth::User()->id; 
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'email' => ['required','email','max:40','unique:users,email,'.$user_id],
            'mobile' => 'required',
        ));
                              
        $user = User::find($user_id);        
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        session()->flash('success','Successfully Save');
        return redirect()->route('profile');
    }


    public function changePhoto(Request $request){
    	$this->validate($request, array(
        'photo' => 'mimes:jpg,jpeg,png|max:2000'
        ));

        $user_id = Auth::User()->id;                       
        $data = User::find($user_id);
        $image = $request->file('photo');
        if ($image) {
            $upload = 'public/upload/member';
            $filename = time() . '_' . $image->getClientOriginalName();
            $success = $image->move($upload, $filename);

            if ($success) {
                $data->photo = $filename;
                $data->save();
                Session::flash('success','Successfully Save');

                return redirect()->route('profile');
            } else {
                Session::flash('warning', "Image couldn't be uploaded.");
                return redirect()->route('profile');
            }
        }
    }
    
    public function changePass(){
        return view('admin.profile.changePass');
    }

    public function chengePassword(Request $request){
    	$this->validate($request, array(
            'CurrentPassword'=>'required|max:15',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            ));
    	//return Auth::user()->password.'<BR>'.Hash::make($request->CurrentPassword);

    	if(Hash::check($request->CurrentPassword, Auth::user()->password )){                      
	        $obj_user = User::find(Auth::User()->id);
	        $obj_user->password = Hash::make($request->password);
	        $obj_user->save();
            Session::flash('success', "Password chenged.");
	        return redirect()->back();            
    	}else{
            Session::flash('warning', "CurrentPassword does not match.");
    		return redirect()->back();
    	}

    } 
    
    public function chengePasswordFource(Request $request){
    	$this->validate($request, array(
            'password' => ['required', 'string', 'min:6'],
        ));
                    
        $obj_user = User::find($request->id);
        $obj_user->password = Hash::make($request->password);
        $obj_user->save(); 
        Session::flash('success', "Password chenged.");
        return redirect()->back();
    } 


}
