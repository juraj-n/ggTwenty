<?php
namespace App\Auth;
use App\Models\User;
use Framework\Core\App;
use Framework\Core\IAuthenticator;
use Framework\Core\IIdentity;
use Framework\Http\Session;

class Authenticator implements IAuthenticator
{
    private App $app;
    private Session $session;
    private ?IIdentity $user = null;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->session = $this->app->getSession();
    }
    public function login($username, $password): bool
    {
        $users = User::getAll("username = ?", [$username]);
        if (empty($users) || count($users) > 1)
            return false;

        $user = $users[0];
        if (!password_verify($password, $user->getPassword()))
            return false;

        $this->user = $user;
        $this->session->set('user', $this->user);

        return true;
    }
    public function logout(): void
    {
        $this->user = null;
        $this->session->destroy();
    }
    public function isLogged(): bool
    {
        return $this->getUser() instanceof IIdentity;
    }
    public function getUser(): ?IIdentity
    {
        if ($this->user instanceof IIdentity)
            return $this->user;

        $sessionValue = $this->session->get('user');

        if ($sessionValue instanceof User || $sessionValue instanceof IIdentity)
        {
            $this->user = $sessionValue;
            return $this->user;
        }

        return null;
    }

    public function __get(string $name): mixed
    {
        if ($name === 'user')
            return $this->getUser();

        return null;
    }
}