<?php

namespace App\Controllers;

use App\Configuration;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class LoginController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return !$this->app->getAuth()->isLogged();
    }
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }
    public function login(Request $request): Response
    {
        $logged = null;
        if ($request->hasValue('submit'))
        {
            $username = trim($request->value('username'));
            $logged = $this->app->getAuth()->login($username, $request->value('password'));
            if ($logged)
                return $this->redirect($this->url("home.index"));
            else
                $message = 'Bad username or password!';
                return $this->html(compact('message', 'username'));
        }

        return $this->html();
    }
}
