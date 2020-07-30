<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use TaskManagementApp\Http\Controllers\Controller;

session_start();


class RegisterController extends Controller
{
    //
    public function show()
    {
        return view('register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'gender' => 'required'
        ]);

        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $status = 0;
        $confirm_Password = $request->get('password_confirmation');
        $gender = $request->get('gender');

        $postArray = array(
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'status' => $status,
            'gender' => $gender,
            'type' => 'user',
            'role' => 4,
            'registeredBy' => 'user'
        );

        $curlResponse = curlHelper("/register", 'post', $postArray);
        $apiResponse = $curlResponse['response'];
        $statusCode = $curlResponse['statusCode'];
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse->message);
        if ($JSONResponse->status != 'ERROR') {
            Session::flash('success', $JSONResponse->message);
            return Redirect::back();
        } else {
            Session::flash('error', $JSONResponse->message);
            return Redirect::back();
        }
    }

    public function confirmEmail($code)
    {
        $curlResponse = curlHelper("/email_verification", 'get', null, $code, null);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            Session::flash('success', $JSONResponse->message);
            return Redirect::route('login');
        } else {
            Session::flash('error', $JSONResponse->message);
            return Redirect::route('login');
        }
    }
}
