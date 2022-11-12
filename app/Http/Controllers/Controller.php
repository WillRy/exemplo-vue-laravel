<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorAPI($message, $errors = [], $errorCode = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'error_code' => $errorCode
        ], 200);
    }

    public function successAPI($data, $message = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'errors' => null,
            'error_code' => null,
            "data" => $data,
        ], 200);
    }

    public function errorInertia($message, $dados = [], $routeName = null, $routeParams = [])
    {
        if ($routeName) {
            return redirect()->route($routeName, $routeParams)->with("error", $message)->with('dados', $dados);
        }

        //evita redirect loop se a rota antiga for igual a rota nova
        if (url()->previous() === url()->current()) {
            return redirect()->route("dashboard")->with("error", $message)->with('dados', $dados);
        }

        return redirect()->back()->with("error", $message)->with('dados', $dados);
    }

    public function successInertia($message, $dados = [], $routeName = null, $routeParams = [])
    {
        if ($routeName) return redirect()->route($routeName, $routeParams)->with("success", $message)->with('dados', $dados);
        else return redirect()->back()->with("success", $message)->with('dados', $dados);
    }
}
