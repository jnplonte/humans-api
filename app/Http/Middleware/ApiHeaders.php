<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiHeaders
{
  public function handle($request, Closure $next)
   {

     $accessToken = $request->header(str_replace("=","",base64_encode($request->segment(1))));
     if($accessToken != env('API_KEY')){
       $err = ['error'=>'Not authorized. Access token needed'];
       return response()->json($err, 403);
     }

     $headers = [
         'Access-Control-Allow-Origin' => '*',
         'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
         'Content-Type' => 'application/x-www-form-urlencoded, application/json'
         //base64_encode($request->segment(1)) => env('API_KEY')
     ];

     if($request->getMethod() == "OPTIONS") {
        // The client-side application can set only headers allowed in Access-Control-Allow-Headers
        return Response::make('OK', 200, $headers);
    }

    $response = $next($request);

    foreach($headers as $key => $value){
      $response->header($key, $value);
    }

    // echo '<pre>';
    // print_r($response);
    // exit();

    return $response;
   }
}
