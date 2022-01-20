<?php

namespace Nowyouwerkn\WeCommerce\Services\Auth;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Nowyouwerkn\WeCommerce\Models\Coupon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \Nowyouwerkn\WeCommerce\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);


        $coupon_rule = UserRule::where('type', 'Cupon de Registro')->first();
        if (!empty($coupon_rule) && $coupon_rule->is_active == true) {
                $coupon = new Coupon;
                $coupon->code = $input['name'] . rand();
                $coupon->description = "Codigo de registro de " . $input['email'];
                $coupon->type = "percentage_amount";
                $coupon->usage_limit_per_code = "1";
                $coupon->usage_limit_per_user = "1";
                $coupon->qty = $coupon_rule->value;
                $coupon->is_active = true;
                $coupon->save();   
        }

        $user->assignRole('customer');

        return $user;
    }
}
