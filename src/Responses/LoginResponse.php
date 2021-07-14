<?php

namespace Nowyouwerkn\WeCommerce\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $home = auth()->user()->hasRole('customer') ? '/profile' : '/w-admin';

        return redirect()->intended($home);
    }
}
