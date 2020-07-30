<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function show()
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/role", 'get', null, null, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse);
        if ($JSONResponse->status != 'ERROR') {
            return view('Layouts.RolesContent', [
                'permissions' => $JSONResponse->data->permission,
                'roles' => $JSONResponse->data->roles
            ]);
        } else {
            return Redirect::route('roles')->withErrors($JSONResponse->message);
        }
    }
    public function addRole(Request $request)
    {
        $roleArray = $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);
        foreach ($roleArray['permissions'] as $id => $name) {
            $roleArray['permissions[' . $id . ']'] = $name;
        }
        unset($roleArray['permissions']);
        // dd($roleArray);

        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/role", 'post', $roleArray, null, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('roles');
        } else {
            return Redirect::route('roles')->withErrors($JSONResponse->message);
        }
    }
    public function getEditRoleData($id)
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/role", 'get', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);

        if ($JSONResponse->status != 'ERROR') {
            $array = [
                'id' => $JSONResponse->data->id,
                'name' => $JSONResponse->data->name,
                'permissions' => $JSONResponse->data->permissions
            ];
            return $array;
        } else {
            return "Hello";
        }
    }
    public function updateRole(Request $request)
    {
        $access_token = session()->get('access_token');
        $input = $request->all();
        $roleId = $input['id'];
        // dd($id);
        $roleArray = array(
            'name' => $input['roles'],
            'permissions' => $input['permissions']

        );
        foreach ($roleArray['permissions'] as $id => $name) {
            $roleArray['permissions[' . $id . ']'] = $name;
        }
        unset($roleArray['permissions']);
        // dd($roleArray);
        $curlResponse1 = curlHelper("/role", 'post', $roleArray, $roleId, $access_token);
        $response = $curlResponse1['response'];
        $JSONResponse = json_decode($response);
        // dd($JSONResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('roles');
        } else {
            return Redirect::route('roles')->withErrors($JSONResponse->message);
        }
    }
    public function deleteRole($id)
    {
        // dd($id);
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/role", 'delete', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('roles');
        } else {
            return Redirect::route('roles')->withErrors($JSONResponse->message);
        }
    }

    public function getRoleById($id)
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/role", 'get', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            return $JSONResponse->data->name;
        } else {
            return $JSONResponse->message;
        }
    }
}
