<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class statusController extends Controller
{
    public function show()
    {
        $access_token = session()->get('access_token');
        $curlResponse1 = curlHelper("/statusData", 'get', null, null, $access_token);
        $response = $curlResponse1['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            $status = $JSONResponse->data;
            return view('Layouts.statusContent', [
                'status' => $status
            ]);
        }
    }
    public function addStatus(Request $request)
    {
        $access_token = session()->get('access_token');
        $postarray = array(
            'status' => $request->all()['status']
        );

        $curlResponse1 = curlHelper("/status", 'post', $postarray, null, $access_token);
        $response = $curlResponse1['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('status');
        } else {
            return Redirect::route('status')->withErrors($JSONResponse->message);
        }
    }
    public function updateStatus(Request $request)
    {
        $access_token = session()->get('access_token');
        $postarray = array(
            'id' => $request->all()['id'],
            'status' => $request->all()['status']
        );
        $curlResponse1 = curlHelper("/updateStatus", 'post', $postarray, null, $access_token);
        $response = $curlResponse1['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('status');
        } else {
            return Redirect::route('status')->withErrors($JSONResponse->message);
        }
    }

    public function deteleStatus($id)
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/status", 'delete', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('status');
        }
        else{
            return Redirect::route('status')->withErrors($JSONResponse->message);

        }
    }
}
