<?php

namespace App\ServiceBus\LoginUser;

use Auth;
use Lang;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginUserHandler
{
    use ValidatesRequests, ThrottlesLogins, RedirectsUsers;

    public function handle(LoginUserCommand $command)
    {
        $request = $command->request;
        
        $this->validateLogin($command->request);

        if ($throttles = $this->isUsingThrottlesLoginsTrait() && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    protected function getCredentials($request)
    {
        return $request->only($this->loginUsername(), 'password');
    }


    protected function validateLogin($request)
    {
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);
    }

    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(static::class)
        );
    }

    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }

    protected function handleUserWasAuthenticated($request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse($request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

}
