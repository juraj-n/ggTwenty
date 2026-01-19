<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
class SigninController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return !$this->app->getAuth()->isLogged();
    }
    public function index(Request $request): Response
    {
        return $this->redirect('?c=signin&a=signin');
    }

    public function signin(Request $request): Response
    {
        if (!$request->hasValue('submit'))
            return $this->html();

        $username = trim($request->value('username'));
        $password = $request->value('password');
        $confirmPassword = $request->value('confirm-password');

        // Required fields
        if (empty($username) || empty($password))
        {
            $message = 'All fields are required!';
            return $this->html(compact('message'));
        }
        // Existing Username
        $existingUsers = User::getAll("username = ?", [$username]);
        if (!empty($existingUsers))
        {
            $message = 'Username already exists!';
            return $this->html(compact('message'));
        }
        // Passwords Match
        if ($password !== $confirmPassword)
        {
            $message = "Passwords do not match!";
            return $this->html(compact('message'));
        }

        $newUser = new User();
        $newUser->setUsername($username);
        $newUser->setPassword($password);

        try
        {
            $newUser->save();
        }
        catch (Exception $e) {
            $message = 'Error creating user: ' . $e->getMessage();
            return $this->html(compact("message"));
        }

        return $this->loginAfterSignin($username, $password);
    }

    private function loginAfterSignin(string $username, string $password)
    {
        $this->app->getAuth()->login($username, $password);

        return $this->redirect($this->url('home.index'));
    }
}
