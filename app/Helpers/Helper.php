<?php
function curlHelper($url, $method, $postArray = null, $concateId = null, $AuthorizationHeader = null)
{
    if ($concateId) {
        $url .= '/' . $concateId;
    }
    $cURLConnection = curl_init(env('API_URL') . $url);

    // dd($cURLConnection);
    if ($method == 'post') {
        curl_setopt($cURLConnection, CURLOPT_POST, 1);
    }
    if ($method == 'put') {
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
    }
    if ($postArray) {
        // dd($postArray);    
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postArray);
    }
    if ($method == 'delete') {
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "DELETE");
    }
    if ($AuthorizationHeader) {
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $AuthorizationHeader
        ));
    }
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $apiResponse = curl_exec($cURLConnection);
    $statusCode = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
    return array('response' => $apiResponse, 'statusCode' => $statusCode);
}
