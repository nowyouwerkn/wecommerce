<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

// Ayudantes
use Carbon\Carbon;

use Config;
use Mail;
use Auth;
use Session;

// Modelos
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;


/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $config = MembershipConfig::find('1');
        return view('wecommerce::back.membership.index')->with('config', $config);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function statusUpdate(Request $request, $id)
    {
           $config = MembershipConfig::find($id);

           $config->is_active = $request->is_active;

           $config->save();

           if ($config->is_active == true) {
            Session::flash('success', 'Se ha activado tu sistema de lealtad');
           } else{
            Session::flash('success', 'Se ha desactivado tu sistema de lealtad');
           }
           // Mensaje de session

            // Enviar a vista
            return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $config = MembershipConfig::find($id);

        $config->is_active = $request->is_active;

        $config->minimum_purchase = $request->minimum_purchase;
        $config->qty_for_points = $request->qty_for_points;
        $config->earned_points = $request->earned_points;
        $config->point_value = $request->point_value;

        $config->has_expiration_time = $request->has_expiration_time;
        $config->point_expiration_time = $request->point_expiration_time;

        $config->has_cutoff = $request->has_cutoff;
        $config->cutoff_date = $request->cutoff_date;

        $config->vip_clients = $request->vip_clients;

        $config->has_vip_minimum_points = $request->has_vip_minimum_points;
        $config->vip_minimum_points = $request->vip_minimum_points;

        $config->has_vip_minimum_orders = $request->has_vip_minimum_orders;
        $config->vip_minimum_orders = $request->vip_minimum_orders;

        $config->on_account_creation = $request->on_account_creation;
        $config->points_account_created = $request->points_account_created;

        $config->on_birthday = $request->on_birthday;
        $config->points_birthdays = $request->points_birthdays;

        $config->on_vip_account = $request->on_vip_account;
        $config->points_vip_accounts = $request->points_vip_accounts;

        $config->on_review = $request->on_review;
        $config->points_review = $request->points_review;

        $config->on_review_with_image = $request->on_review_with_image;
        $config->points_review_with_image = $request->points_review_with_image;


        $config->save();


        // Mensaje de session
        Session::flash('success', 'Se ha actualizado tu configuración del sistema de lealtad');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
       //
    }
}
