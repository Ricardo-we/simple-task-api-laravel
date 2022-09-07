<?php
namespace App\Utils;
// use Illuminate\Http\Request;

class ResponseFormatter {

    private function __construct(){}
    
    public static function errorResponse(string $errorMessage="", int $status=500){
        return response([
            "error" => $errorMessage
        ], $status);
    }

    public static function defaultSuccess(){
        return response([
            "message" => "success"
        ], 200);
    }

    public static function formattedErrorResponse(string $entity, $status=500){
        switch ($status) {
            case 404:
                return ResponseFormatter::errorResponse(
                    sprintf("%s doesnt belong to user or does not exists", $entity), 
                    $status
                );
            case 401:
                return ResponseFormatter::errorResponse(
                    "Route is unauthorized for the current user", 
                    $status
                );
            case 409:
                return ResponseFormatter::errorResponse(
                    sprintf("Failed creating %s", $entity),
                    $status   
                );
            case 500:
                return ResponseFormatter::errorResponse(
                    sprintf("Internal server error", $entity),
                    $status   
                ); 
            default:
                return ResponseFormatter::errorResponse(
                    "Something went wrong",
                    $status
                );
                break;
        }
    }
}