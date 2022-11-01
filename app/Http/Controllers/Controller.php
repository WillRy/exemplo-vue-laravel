<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successInertia($message, $dados = [], $routeName = null, $routeParams = [])
    {
        if ($routeName) return redirect()->route($routeName, $routeParams)->with("success", $message)->with('dados', $dados);
        else return redirect()->back()->with("success", $message)->with('dados', $dados);
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

    public function responseJSON($data = [], $statusCode = 200)
    {
        return response()->json([
            "data" => $data
        ], $statusCode);
    }

    public function errorJSON($message, $statusCode = 500, $errorCode = 'ERROR', $errors = [])
    {
        return response()->json(["error" => $message, 'code' => $errorCode, 'errors' => $errors], $statusCode);
    }
}
