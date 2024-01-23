<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FireRegisterController extends GroundController
{
    public function fireregister(Request $request):JsonResponse
    {
        try {
            echo '<pre>';
            print_r($request->all());
            echo '</pre>';
            exit();

            return response()->json($data, 200);
        } catch (\Exception $exception) {
            $data= [];
            $data['success'] = false;
            $data['errors'] = [
                'code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ];
            return response()->json($data, 500);
        }
    }
}
