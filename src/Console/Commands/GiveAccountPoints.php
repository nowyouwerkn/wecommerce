<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

/* Loyalty system */
use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserPoint;
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;

class GiveAccountPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wecommerce:account:points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando le otorga puntos al usuario si es su cumpleaños.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*SISTEMA DE LEALTAD*/
        $membership = MembershipConfig::where('is_active', true)->first();
        $users = User::all();

        if (!empty($membership)) {
            if($membership->on_birthday == true){
                foreach($users as $user){

                    if ($user->birthday != NULL) {
                        if (Carbon::parse($user->birthday)->format('d m') == Carbon::now()->format('d m')) {

                            $points = new UserPoint;
                            $points->user_id = $user->id;
                            $points->type = 'in';
                            $points->value = $membership->points_birthdays;

                            if ($membership->has_expiration_time == true){
                                $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                            }

                            $points->save();

                            $this->info('Puntos otorgados.');
                        }
                    }
                }
            }
        }

        $this->info('Comando exitosamente ejecutado.');
    }
}
