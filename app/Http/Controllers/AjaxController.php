<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public static $interfaces = [
        'ajax' => [
            'controller' => 'App\Http\Controllers\AjaxController'
        ],
        'admin' => [
            'controller' => 'App\Http\Controllers\AdminController'
        ]
    ];

    public static $async = [
        'test' => [
            'conditions' => []
        ]
    ];

    /**
     * Executes the ajax-assigned method in the requested controller.
     *
     * @param $route
     * @param $method
     * @return \Illuminate\Http\JsonResponse
     */
    public function run($route, $method)
    {
        if (!isset(self::$interfaces[$route])) return self::deny();
        $controller = self::$interfaces[$route]['controller'];
        if (method_exists($controller, $method) && isset($controller::$async) && isset($controller::$async[$method])) {
            //TODO: implement the `conditions` handling
            return self::answer(...$controller::$method(Input::all()));
        } else {
            return self::deny();
        }
    }

    /**
     * An example ajax-callable function. The algorithm to allow the ajax access to the function:
     * 1. Create the public static function
     * 2. Add its entry to the $async of the controller
     * 3. Check if the controller has its alias in the $interfaces of the AjaxController
     *
     * KEEP IN MIND: the function should return either an array of single element or an array of data and HTTP code of the response.
     * The default HTTP code is 200.
     *
     * @param $args
     * @return array
     */
    public static function test($args)
    {
        return [$args];
    }

    /**
     * The function to give the denial of the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deny()
    {
        return response()->json([
            'success' => false,
            'message' => 'no controller'
        ], 404 );
    }

    /**
     * The function to give the correct AJAX answer.
     * Accepts one or two arguments got from the func_get_args and replacing the
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function answer()
    {
        $data = func_get_args();
        if (!isset($data[1]) || !is_int($data[1])) $data[1] = 200;
        return response()->json($data);
    }
}
