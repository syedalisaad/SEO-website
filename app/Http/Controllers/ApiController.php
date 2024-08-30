<?php namespace App\Http\Controllers;

/*
 * Swagger
 * 1) https://ivankolodiy.medium.com/how-to-write-swagger-documentation-for-laravel-api-tips-examples-5510fb392a94
 * 2) https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration
 * Bugs: https://ivankolodiy.medium.com/how-to-write-swagger-documentation-for-laravel-api-tips-examples-5510fb392a94
 * Docs:
 * 1: https://swagger.io/specification/v2/
 * 2: https://ikolodiy.com/posts/laravel-swagger-tips-examples
 * 3: https://ivankolodiy.medium.com/how-to-write-swagger-documentation-for-laravel-api-tips-examples-5510fb392a94
 * 4: https://github.com/zircote/swagger-php/tree/master/Examples/petstore.swagger.io
 *
 * **/

/**
 * @OA\Info(
 *  title="Good Hospital & Bad Hospital API",
 *  version="1.0.0",
 * )
 *
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  in="header",
 *  name="bearerAuth",
 *  type="http",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 * )
 */
class ApiController extends \App\Http\Controllers\Controller
{
    protected $handleCodes = [
        'NOT_VERIFIED' => 400
    ];

    protected $ACCESS_TOKEN_SECRET = 'ooOyvEcuRO6jaX64JrXpmDJhoZb9IpN3qwDybvcW';

    public function __construct() {

    }

    public function sendResponse( $message, $data = null, $status = 200, $collection = 'data' )
    {
        $response = [
            'status'    => $status,
            'message'   => $message
        ];

        if ( !is_null($data) ) {
            $response[$collection] = $data;
        }

        return response()->json( $response );
    }

    public function sendError( $message, $data = null, $status = 400, $collection = 'error' )
    {
        $response = [
            'status'    => $status,
            'message'   => $message
        ];

        if ( !is_null($data) ) {
            $response[$collection] = $data;
        }

        return response()->json( $response );
    }
}
