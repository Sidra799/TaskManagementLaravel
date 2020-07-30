<?php

namespace TaskManagementApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class taskController extends Controller
{

    public function show($id)
    {
        $access_token = session()->get('access_token');
        $currentId = session()->get('id');
        $designation = session()->get('designation');
        $taskArray = array(
            'type' => $designation,
            'taskId' => $id,
            'userId' => $currentId
        );
        $curlResponse = curlHelper("/editTaskData", 'post', $taskArray, null, $access_token);
        $taskresponse = $curlResponse['response'];
        $JSONResponse = json_decode($taskresponse);
        if ($designation == 'lead') {

            if ($JSONResponse->status != 'ERROR') {
                $editTaskData = $JSONResponse->data;
                return view('Layouts.editContent', [
                    'task' => $editTaskData->task,
                    'assignedUsers' => $editTaskData->assignedUsers,
                    'users' => $editTaskData->users,
                    'queries' =>  $editTaskData->queries,
                    'status' =>  $editTaskData->status
                ]);
            } else {
                return view('Layouts.editContent')->withErrors($JSONResponse->message);
            }
        } else {
            if ($JSONResponse->status != 'ERROR') {
                $editTaskData = $JSONResponse->data;
                return view('Layouts.editContent', [
                    'task' => $editTaskData->task,
                    'users' => $editTaskData->users,
                    'queries' =>  $editTaskData->queries,
                    'status' =>  $editTaskData->status
                ]);
            } else {
                return view('Layouts.editContent')->withErrors($JSONResponse->message);
            }
        }
    }
    public function editTask(Request $request)
    {
        $access_token = session()->get('access_token');
        $designation = session()->get('designation');
        if ($designation == 'lead') {
            $postArray = array(
                "id" => $request->get('id'),
                "title" => $request->get('title'),
                "description" => $request->get('description'),
                "startDate" => $request->get('startDate'),
                "durationHours" => $request->get('durationHours'),
                "durationMinutes" => $request->get('durationMinutes'),
                "assignTo" => $request->get('assignTo'),
                "priority" => $request->get('priority')
            );
        } else {
            $postArray = array(
                "id" => $request->id,
                "title" => $request->title,
                "description" => $request->description,
                "startDate" => $request->startDate,
                "durationHours" => $request->durationHours,
                "durationMinutes" => $request->durationMinutes,
                "priority" => $request->priority
            );
        }


        $curlResponse = curlHelper("/editTask", 'post', $postArray, null, $access_token);
        $response = $curlResponse['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            return redirect()->to( 'editTask/'.$request->get('id') );
        } else {
            return Redirect::route('home')->withErrors($JSONResponse->message);
        }
    }

    public function deteleTask($id)
    {
        $access_token = session()->get('access_token');
        $curlResponse = curlHelper("/task", 'delete', null, $id, $access_token);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            return Redirect::route('home');
        } else {
            return Redirect::route('home')->withErrors($JSONResponse->meesage);
        }
    }

    public function askQuery(Request $request, $id)
    {
        $formId = session()->get('id');
        $fromEmail = session()->get('email');
        $fromName = session()->get('name');
        $taskTitle = $request->all()['taskTitle'];
        $taskId = $id;
        $query = $request->all()['query'];
        $toId = $request->all()['toId'];

        $arr = explode(",", $toId);
        foreach ($arr as $userID) {
            $access_token = session()->get('access_token');
            $curlResponse = curlHelper("/users", 'get', null, $userID, $access_token);
            $Response = $curlResponse['response'];

            $apiResponse = json_decode($Response);
            $userDetails = $apiResponse->data;
            $statusCode = $curlResponse['statusCode'];
            if ($statusCode == 200) {
                $toEmail = $userDetails->email;
                $toName = $userDetails->name;
                $postArray = array(
                    'query' => $query,
                    'fromUid' => $formId,
                    'toUid' => $userID,
                    'taskId' => $taskId,
                    'fromName' => $fromName,
                    'toName' => $toName,
                    'taskTitle' => $taskTitle,
                    'toEmail' => $toEmail,
                    'fromEmail' => $fromEmail
                );
                $curlResponse = curlHelper('/askQuery', 'post', $postArray, null, $access_token);
                $addapiResponse = $curlResponse['response'];
                $statusCode = $curlResponse['statusCode'];
            }
        }
        return redirect()->to( 'editTask/'.$taskId);

    }

    public function updateStatus(Request $request)
    {
        $access_token = session()->get('access_token');
        $postArray = array(
            'id' => $request->all()['taskId'],
            'statusId' => $request->all()['selectStatus']
        );
        $curlResponse = curlHelper("/editTask", 'post', $postArray, null, $access_token);
        $response = $curlResponse['response'];
        $JSONResponse = json_decode($response);
        if ($JSONResponse->status != 'ERROR') {
            return redirect()->to( 'editTask/'.$request->all()['taskId'] );

        } else {
            return Redirect::route('home')->withErrors($JSONResponse->meesage);
        }
    }
}
