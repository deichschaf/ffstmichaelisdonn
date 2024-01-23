<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait LoggerTrait
{
    /**
     * @param array $subdata
     * @param array $data
     * @return array
     */
    public function checkSubData(array $subdata, array $data):array
    {
        if ($subdata['success'] === false) {
            $data['success'] = false;
            $data['errorMessage'][]=$subdata['errorMessage'];
            $data['errors'][]=$subdata['errorMessage'];
            $data['errorCode']=$subdata['errorCode'];
        }
        return $data;
    }

    /**
     * @param string $class
     * @param string $function
     * @param int $line
     * @param int|string $errorcode
     * @param string|array $errormessage
     * @param int $json
     * @return array|JsonResponse
     */
    public function makeJsonLogging(
        string $class = '',
        string $function = '',
        int $line = 0,
        int | string $errorcode = 0,
        string | array $errormessage = '',
        int $json = 0
    ): array | JsonResponse {
        Log::error($class . ':' . $function . '(' . $line . ')', [$errorcode, $errormessage]);
        if ($json === 0) {
            return [
                'success' => false,
                'errorMessage' => $errormessage,
                'errorCode' => $errorcode,
                'errors' => [
                    $errormessage
                ]
            ];
        } else {
            $errorCode = 500;
            if (is_numeric($errorcode)) {
                if ($errorcode !== 0 && $errorcode >= 1 && $errorcode <= 511) {
                    $errorCode = $errorcode;
                }
            }
            $data = [
                'success' => false,
                'errorMessage' => $errormessage,
                'errorCode' => $errorcode,
                'errors' => [
                    $errormessage
                ]
            ];
            return response()->json($data, $errorCode);
        }
    }

    /**
     * @param string $message
     * @param string $class
     * @param string $function
     * @param int $line
     * @param string|array $content
     * @return void
     */
    public function makeLogInfo(
        string | array $content,
        string $message = '',
        string $class = '',
        string $function = '',
        int $line = 0,
        int $console = 0
    ) {
        if (env('DEBUG') === true && $console === 0) {
            echo '<div class="infobox">';
            echo '<pre>';
            print_r('CLASS: ' . $class);
            echo '</pre>';
            echo '<pre>';
            print_r('Function: ' . $function);
            echo '</pre>';
            echo '<pre>';
            print_r('Line: ' . $line);
            echo '</pre>';
            echo '<pre>';
            print_r($content);
            echo '</pre>';
            echo '</div>';
        }
        Log::info($message, [
            'Class' => $class,
            'Function' => $function,
            'Line' => $line,
            'content' => print_r($content, true)
        ]);
    }

    /**
     * @param string $message
     * @param string $class
     * @param string $function
     * @param int $line
     * @param int $errorcode
     * @param string|array $errormessage
     * @return void
     */
    public function makeLogError(
        string $message = '',
        string $class = '',
        string $function = '',
        int $line = 0,
        int | string $errorcode = 0,
        string | array $errormessage = '',
        int $console = 0
    ) {
        if (env('DEBUG') === true && $console === 0) {
            echo '<div class="errorbox">';
            echo '<pre>';
            print_r('CLASS: ' . $class);
            echo '</pre>';
            echo '<pre>';
            print_r('Function: ' . $function);
            echo '</pre>';
            echo '<pre>';
            print_r('Line: ' . $line);
            echo '</pre>';
            echo '<pre>';
            print_r('ErrorCode: ' . $errorcode);
            echo '</pre>';
            echo '<pre style="color:red;">';
            print_r($errormessage);
            echo '</pre>';
            echo '</div>';
        }
        Log::error($message, [
            'Class' => $class,
            'Function' => $function,
            'Line' => $line,
            'ErrorCode' => $errorcode,
            'ErrorMessage' => print_r($errormessage, true)
        ]);
    }
}
