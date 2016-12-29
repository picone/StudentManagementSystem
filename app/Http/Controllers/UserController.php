<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 上午1:23
 */

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        switch($request->input('type')){
            case 1://管理员
                $auth=Auth::guard('admin');
                $credentials=[
                    'name'=>$request->input('username'),
                    'password'=>$request->input('password')
                ];
                break;
            case 2:
                $auth=Auth::guard('teacher');
                $credentials=[
                    'id'=>$request->input('username'),
                    'password'=>$request->input('password')
                ];
                break;
            case 3:
                $auth=Auth::guard('student');
                $credentials=[
                    'id'=>$request->input('username'),
                    'password'=>$request->input('password')
                ];
                break;
            default:
                return redirect()->route('user:login')->with('message',trans('response.101'));
        }
        if($auth->attempt($credentials,$request->input('remember',false))){
            return redirect()->route('index');
        }else{
            return redirect()->route('user:login')->with('message',trans('response.100'));
        }
    }
}
