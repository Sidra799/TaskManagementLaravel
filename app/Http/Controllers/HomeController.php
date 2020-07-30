<?php

namespace TaskManagementApp\Http\Controllers;

use App\Helper\ConstantHelper;
use DateTime;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{ 
    /*
     * @name:    show
     * @author:    Sidra Ashfaq
     * @date:   07-6-2020
     * * @description:   To return all Data from API required to be rendered on Home Page
     */
    public function show(Request $request)
    {
        $accessToken = session()->get('access_token');
        $curlResponse = curlHelper("/user", 'get', null, null, $accessToken);
        $response = $curlResponse['response'];
        $jsonResponse = json_decode($response);
        $leadCode = ConstantHelper::LEAD_ROLE;
        $adminCode = ConstantHelper::ADMIN_ROLE;
        $devCode = ConstantHelper::DEVELOPER_ROLE;
        if ($jsonResponse->status != 'ERROR') {
            $jsoncurrentUserArray = $jsonResponse->data;
            session()->put('id', $jsoncurrentUserArray->id);
            session()->put('designation', $jsoncurrentUserArray->designation);
            session()->put('email', $jsoncurrentUserArray->email);
            session()->put('name', $jsoncurrentUserArray->name);
            session()->put('role', $jsoncurrentUserArray->roles->name);
            session()->put('permissions', $jsoncurrentUserArray->roles->permissions);
        } else {
            Session::flash('error', $jsonResponse->message);
            return Redirect::back();
        }
        if ($jsoncurrentUserArray->roles->name == ConstantHelper::$roles[$adminCode]) {
            $curlResponse = curlHelper("/allusers", 'get', null, null, $accessToken);
            $userresponse = $curlResponse['response'];
            $jsonuserArrayResponse = json_decode($userresponse);
            // dd($jsonuserArrayResponse);
            // dd($jsonuserArrayResponse);
            return view('Layouts.adminContent', [
                'data' => $jsoncurrentUserArray,
                'users' => $jsonuserArrayResponse->data->users,
                'roles' => $jsonuserArrayResponse->data->roles
            ]);
        } else {

            if ($jsoncurrentUserArray->roles->name == ConstantHelper::$roles[$leadCode]) {
                $taskArray = array(
                    'type' => 'lead',
                    'id' => $jsoncurrentUserArray->id
                );
                $curlResponse = curlHelper("/homeData", 'post', $taskArray, null, $accessToken);
                $homeDataResponse = $curlResponse['response'];
                $homeJSONResponse = json_decode($homeDataResponse);
                if ($homeJSONResponse->status != 'ERROR') {
                    $homeData = $homeJSONResponse->data;
                }
                return view('Layouts.home', [
                    'data' => $jsoncurrentUserArray,
                    'assignedUsers' => $homeData->assignedUsers
                ]);
            } elseif ($jsoncurrentUserArray->roles->name == ConstantHelper::$roles[$devCode]) {
                return view('Layouts.home', [
                    'data' => $jsoncurrentUserArray
                ]);
            }
        }
    }
    /*
     * @name:    editUser
     * @author:    Sidra Ashfaq
     * @date:   07-6-2020
     * * @description:   To call API to edit User Record on the basis of their designation
     */
    public function editUser(Request $request)
    {
        $roleName = $request->get('roleName');
        if ($roleName == 'Lead') {
            $parent = 0;
        } else {
            $parent = $request->get('assignTo');
        }

        $userArray = array(
            'id' => $request->get('id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'gender' => $request->get('gender'),
            'designation' => $request->get('designation'),
            'parent' => $parent,
            'role_id' => $request->get('roles')
        );
        $accessToken = session()->get('access_token');
        $curlResponse = curlHelper("/editUser", 'post', $userArray, null, $accessToken);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);

        if ($JSONResponse->status != "ERROR") {
            return Redirect::route('home');
        } else {
            return Redirect::route('home')->withErrors($JSONResponse->message);
        }
    }
    /* 
     * @name:    addTask
     * @author:    Sidra Ashfaq
     * @date:   07-6-2020
     * * @description:   To call API to add a new Task
     */
    public function addTask(Request $request)
    {
        $accessToken = session()->get('access_token');
        $createdBy = session()->get('id');
        $time = new DateTime( $request->get('startDate'));
        $startDate = $time->format('Y-m-d H:i:s');
        $postArray = array(
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'startDate' => $startDate,
            'durationUnit' => $request->get('durationFormat'),
            'duration' => $request->get('duration'),
            'priority' => $request->get('priority'),
            'createdBy' => $createdBy,
            'assignedUserId' => $request->get('assignTo'),
            'statusId' => 3
        );
        // dd($postArray);
        $curlResponse = curlHelper("/tasks", 'post', $postArray, null, $accessToken);
        $apiResponse = $curlResponse['response'];
        // dd($apiResponse);
        $JSONResponse = json_decode($apiResponse);
        // dd($JSONResponse);

        if ($JSONResponse->status != 'ERROR') {
           
            return Redirect::route('home');
        } else {
            return Redirect::route('home')->withErrors($JSONResponse->message);
        }
    }

    public function addTaskShow()
    {
        $accessToken = session()->get('access_token');
        $id = session()->get('id');
        $taskArray = array(
            'type' => 'lead',
            'id' => $id
        );
        $curlResponse = curlHelper("/homeData", 'post', $taskArray, null, $accessToken);
        $homeDataResponse = $curlResponse['response'];
        $homeJSONResponse = json_decode($homeDataResponse);
        if ($homeJSONResponse->status != 'ERROR') {
            $homeData = $homeJSONResponse->data;
        }
        return view('Layouts.AddTask', [
            'assignedUsers' => $homeData->assignedUsers
        ]);
    }
    /*
     * @name:    filterTask
     * @author:    Sidra Ashfaq
     * @date:   07-6-2020
     * * @description:   To return all Data on the basis of filters from API required to be rendered on Home Page
     */
    public function filterTask(Request $request)
    {
        $accessToken = session()->get('access_token');
        $id = session()->get('id');
        $designation = session()->get('designation');
        $title = $request->get('title');
        $date = $request->get('date');
        $priority = $request->get('filterPriority');
        $page = $request->get('page');

        $taskArray = array(
            'id' => $id,
            'page' => $page
        );
        if ($title) {
            $taskArray['title'] = $title;
        }
        if ($date) {
            $time = new DateTime($date);
            $startDate = $time->format('Y-m-d H:i:s');
            // dd($startDate);
            $taskArray['date'] = $startDate;
        }
        if ($priority) {
            $taskArray['priority'] = $priority;
        }
        if ($designation == 'lead') {
            $taskArray['type'] = 'lead';
            $assignTo = $request->get('assignTo');

            if ($assignTo) {
                $taskArray['assignTo'] = $assignTo;
            }
        } else {
            $taskArray['type'] = 'developer';
        }
        $curlResponse = curlHelper("/allTasks", 'post', $taskArray, null, $accessToken);
        $homeDataResponse = $curlResponse['response'];

        $homeJSONResponse = json_decode($homeDataResponse);
        if ($homeJSONResponse->status != 'ERROR') {
            $homeData = $homeJSONResponse->data;
        }
        $nextPage = null;
        $prePage = null;
        $currentPage = $homeData->allTasks->current_page;
        if ($homeData->allTasks->next_page_url) {
            $nextPage = $currentPage + 1;
        }
        if ($homeData->allTasks->prev_page_url) {
            $prePage = $currentPage - 1;
        }
        $array = array(
            'tasks' => $homeData->allTasks->data,
            'nextPage' => $nextPage,
            'prePage' => $prePage,
            'currentPage' => $currentPage,
            'total' => $homeData->allTasks->total,
            'taskPagination' => $homeData->taskPagination,
            'tableHeading' => $homeData->tableHeading
        );
        return $array;
    }
    /*
     * @name:    logout
     * @author:    Sidra Ashfaq
     * @date:   07-10-2020
     * * @description:   To logout current user
     */
    public function logout()
    {
        $accessToken = session()->get('access_token');
        $curlResponse = curlHelper("/logout", 'get', null, null, $accessToken);
        $apiResponse = $curlResponse['response'];
        $JSONResponse = json_decode($apiResponse);
        if ($JSONResponse->status != 'ERROR') {
            Session::flush();
            return Redirect::route('login');
        } else {
            Session::flash('error', $JSONResponse->message);
            return Redirect::route('login');
        }
    }
    public function addUserShow()
    {
        $accessToken = session()->get('access_token');
        $curlResponse = curlHelper("/allusers", 'get', null, null, $accessToken);
        $userresponse = $curlResponse['response'];
        $jsonuserArrayResponse = json_decode($userresponse);
        // dd($jsonuserArrayResponse);
        return view('Layouts.AddUser', [
            'users' => $jsonuserArrayResponse->data->users,
            'roles' => $jsonuserArrayResponse->data->roles
        ]);
    }

    public function addUser(Request $request)
    {
        $access_token = session()->get('access_token');
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'gender' => 'required'
        ]);
        $status = 0;
        $roleName = $request->get('roleName');
        $leadCode = ConstantHelper::LEAD_ROLE;
        $devCode = ConstantHelper::DEVELOPER_ROLE;
        $parent = null;

        if ($roleName == ConstantHelper::$roles[$leadCode]) {
            $parent = 0;
        } elseif ($roleName == ConstantHelper::$roles[$devCode]) {
            $parent = $request->get('assignTo');
        }


        $postArray = array(
            'name' => $request->get('name'),
            'email' =>  $request->get('email'),
            'password' => $request->get('password'),
            'status' => $status,
            'gender' => $request->get('gender'),
            'type' => 'user',
            'designation' => $request->get('designation'),
            'parent' => $parent,
            'role' => $request->get('roles'),
            'registeredBy' => 'admin'
        );
        $curlResponse = curlHelper("/register", 'post', $postArray, null, $access_token);
        $apiResponse = $curlResponse['response'];
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
}
