<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Users;

class UsersController extends Controller
{
    public function index(Request $request){
    	if($request->session()->get('login') && $request->session()->get('administrator') === 1){
    		return redirect('/music');
    	}else if($request->session()->get('login') && $request->session()->get('administrator') === 0){
            return redirect('/list');
        }

    	return view('index');
    }

    public function login(Request $request){
    	$this->validate($request, [
        	'email' => ['required'],
        	'password' => ['required']
    	]);

    	$users = Users::where('email', $request->email)->first();

    	if(!empty($users) && decrypt($users->password) === $request->password && $users->administrator === 1){
    		$request->session()->put('login', $users->id);
            $request->session()->put('administrator', 1);
    		return redirect('/music');
    	}else if(!empty($users) && decrypt($users->password) === $request->password && $users->administrator === 0){
            $request->session()->put('login', $users->id);
            $request->session()->put('administrator', 0);
            return redirect('/list');
        }

    	return view('index', ['message' => 'E-mail e password inválidos!']);
    }

    public function register(){
    	return view('register');
    }

    public function create(Request $request, Users $users){
    	$this->validate($request, [
        	'name' => ['required'],
        	'password' => ['required', 'min:3'],
        	'email' => ['required', 'email'],
        	'age' => ['required', 'numeric']
    	]);	

    	$user_registered = Users::where('email', $request->email)->first();

        if(empty($user_registered)){
            $users->name = $request->name;
            $users->password = encrypt($request->password);
            $users->email = $request->email;
            $users->age = $request->age;

            $user_exist = Users::select('id')->first();

            if(empty($user_exist)){
                $users->administrator = 1;
            }

            $users->save();

            return redirect('/');
        }
            
        return view('register', ['message' => 'E-mail já está sendo utilizado!']);
    }
}