<?php
    namespace App\Helper;

    class Helper{
        public static function successResponse($data, $msg = "success",$status = STATUS_OK,){
             $response = ['data'=>$data,'success' => true, 'message' => $msg, 'code' => $status];
             return response()->json($response, $status);
        }

        public static function errorResponse($data, $msg = "Something went wrong", $status = STATUS_BAD_REQUEST,){
            $response = ['success' => false, 'message' => $msg, 'code' => $status];
            return response()->json($response, $status);
       }
    }
?>