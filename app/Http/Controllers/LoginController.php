<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $curlResponse = curlHelper("/login", 'post', $request->all());
        $apiResponse = $curlResponse['response'];
        $statusCode = $curlResponse['statusCode'];
        $jsonArrayResponse = json_decode($apiResponse);

        if ($jsonArrayResponse->status == 'ERROR') {
            Session::flash('error', $jsonArrayResponse->message);
            return Redirect::back();
        } else {
            $access_token = $jsonArrayResponse->data->token;
            session()->put('access_token', $access_token);
            return redirect()->route('home');
        }
    }
    public function viewforgetPassword()
    {
        return view('forgetPasswordRequest');
    }
    public function forgetPassword(Request $request)
    {
        $email = $request->get('email');
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $forgetPasswordArray = array(
            'email' => $email
        );
        $curlResponse = curlHelper("/forgetPassword", 'post', $forgetPasswordArray);
        $apiResponse = $curlResponse['response'];
        $jsonArrayResponse = json_decode($apiResponse);

        if ($jsonArrayResponse->status == 'ERROR') {
            Session::flash('error', $jsonArrayResponse->message);
            return Redirect::back();
        } else {
            Session::flash('success', $jsonArrayResponse->message);
            return Redirect::back();
        }
    }
    public function forgetPasswordPage($id, $token)
    {
        $forgetPasswordArray = array(
            'token' => $token,
            'id' => $id
        );
        $curlResponse = curlHelper("/changePassword", 'post', $forgetPasswordArray);
        $apiResponse = $curlResponse['response'];

        $jsonArrayResponse = json_decode($apiResponse);

        if ($jsonArrayResponse->status == 'ERROR') {
            Session::flash('error', $jsonArrayResponse->message);
            return Redirect::route('login');
        } else {
            $userId = $jsonArrayResponse->data;
            return view('ChangePassword', [
                'userId' => $userId
            ]);
        }
    }
    public function forgetPasswordAction(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/' 
        ]);
        $id = $request->get('id');
        $password = $request->get('password');
        $forgetPasswordArray = array(
            'password' => $password,
            'id' => $id
        );
        $curlResponse = curlHelper("/changePasswordAction", 'post', $forgetPasswordArray);
        $apiResponse = $curlResponse['response'];
        $jsonArrayResponse = json_decode($apiResponse);
        if ($jsonArrayResponse->status == 'ERROR') {
            Session::flash('error', $jsonArrayResponse->message);
            return Redirect::back();
        } else {
            Session::flash('success', $jsonArrayResponse->message);
            return Redirect::route('login');
        }
    }
}
