<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    //
    public function show()
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/permission", 'get', null, null, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            return view('Layouts.PermissionsContent', [
                'permissions' => $JSONResponse->data
            ]);
        } else {
            return Redirect::route('permission')->withErrors($JSONResponse->message);
        }
    }
    public function addPermission(Request $request)
    {
        $permissionArray = $this->validate($request, [
            'name' => 'required'
        ]);
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/permission", 'post', $permissionArray, null, $access_token);
        $apiResponse = $curlResponse['response'];

        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('permission');
        } else {
            return Redirect::route('permission')->withErrors($JSONResponse->message);
        }
    }
    public function updatePermission(Request $request)
    {
        $access_token = session()->get('access_token');
        $input = $request->all();
        $id = $input['id'];
        $permissionArray = array(
            'name' => $input['permission']
        );
        $curlResponse1 = curlHelper("/permission", 'post', $permissionArray, $id, $access_token);
        $response = $curlResponse1['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('permission');
        } else {
            return Redirect::route('permission')->withErrors($JSONResponse->message);
        }
    }
    public function deletePermission($id)
    {
        // dd($id);
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/permission", 'delete', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('permission');
        } else {
            return Redirect::route('permission')->withErrors($JSONResponse->message);
        }
    }
}
