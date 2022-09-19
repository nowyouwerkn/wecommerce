<?php

namespace Nowyouwerkn\WeCommerce\Services\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use Str;
use Carbon\Carbon;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Nowyouwerkn\WeCommerce\Models\Coupon;

/*Membresias*/
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;
use Nowyouwerkn\WeCommerce\Models\UserPoint;

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

        $coupon_rule = UserRule::where('type', 'Cupón de Registro')->where('is_active', true)->first();

        if (!empty($coupon_rule)) {
            $coupon = new Coupon;

            $coupon->code = Str::slug($input['name']) . '_' . rand();
            $coupon->description = "Cupón de descuento por registro de " . $input['email'];
            $coupon->type = "percentage_amount";
            $coupon->usage_limit_per_code = "1";
            $coupon->usage_limit_per_user = "1";
            $coupon->qty = $coupon_rule->value;
            $coupon->is_active = true;

            $coupon->start_date = Carbon::now();
            $coupon->end_date = Carbon::now()->addDays(15);

            $coupon->made_for_user = $user->id;

            $coupon->save();
        }

        $membership = MembershipConfig::where('on_account_creation', true)->where('is_active', true)->first();

        if (!empty($membership)){
            $points = new UserPoint;
            $points->user_id = $user->id;
            $points->type = 'in';
            $points->value = $membership->points_account_created;

            if ($membership->has_expiration_time == true){
                $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
            }

            $points->save();
        }

        $user->assignRole('customer');

        return $user;
    }
}
