<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Nowyouwerkn\WeCommerce\Models\Client;
use Nowyouwerkn\WeCommerce\Models\UserAddress;
use Nowyouwerkn\WeCommerce\Models\Wishlist;
use Nowyouwerkn\WeCommerce\Models\Coupon;

/*Loyalty system*/
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;
use Nowyouwerkn\WeCommerce\Models\UserPoint;

/* Exportar Info */
use Maatwebsite\Excel\Facades\Excel;
use Nowyouwerkn\WeCommerce\Exports\ClientExport;
use Nowyouwerkn\WeCommerce\Imports\ClientImport;

use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $today = Carbon::now();

        $clients = User::role('customer')->orderBy('name')->paginate(30);
        $new_clients = User::where('created_at', '>=', Carbon::now()->subWeek())->count();

        $clients_today = User::where('created_at', '>=', $today->endOfDay())
        ->where('created_at', '<=', $today)
        ->count();

        $wishlists = Wishlist::all();

        $wishlists_today = Wishlist::where('created_at', '<=', $today)
        ->count();

        return view('wecommerce::back.clients.index')
        ->with('clients', $clients)
        ->with('new_clients', $new_clients)
        ->with('clients_today', $clients_today)
        ->with('wishlists', $wishlists)
        ->with('wishlists_today', $wishlists_today);
    }

    public function create()
    {
        return view('wecommerce::back.clients.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'name' => 'required|max:255',
            'email' => 'unique:users|required|max:255',
        ));

        $client = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $client->assignRole('customer');

        $this->notification->registerUser($request->input('name'),$request->input('email'));

        //Session message
        Session::flash('success', 'El cliente fue registrado exitosamente.');

        return redirect()->back();
    }

    public function show($id)
    {

        $membership = MembershipConfig::where('is_active', true)->first();


        $client = User::find($id);
        $wishlist = Wishlist::where('user_id', $client->id)->get();
        $addresses = UserAddress::where('user_id', $client->id)->get();

        $points = UserPoint::where('user_id', $client->id)->get();

        $orders = $client->orders;

        /*
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        */

        return view('wecommerce::back.clients.show')->with('client', $client)
        ->with('wishlist', $wishlist)
        ->with('addresses', $addresses)
        ->with('orders', $orders)
        ->with('points', $points)
        ->with('membership', $membership);
    }

    public function indexWishlist()
    {
        $wishlists = Wishlist::all();

        return view('wecommerce::back.clients.filters.wishlist')
        ->with('wishlists', $wishlists);
    }

    public function indexNew()
    {
        $clients = User::where('created_at', '>=', Carbon::now()->subWeek())->get();

        return view('wecommerce::back.clients.filters.new')
        ->with('clients', $clients);
    }

    //Add Address
    public function addAddress (Request $request)
    {
        UserAddress::create($request->all());
        return redirect()->route('address')->with('status', 'Se ha agregado la dirección');
    }

    public function export()
    {
        return Excel::download(new ClientExport, 'clientes.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new ClientImport, $request->import_file);

        return redirect()->back()->with('success', 'Información guardad exitosamente.');
    }

    public function query(Request $request)
    {
        $search_query = $request->input('query');
         $client = User::where('name', 'LIKE', "%{$search_query}%")
        ->orWhere('email', 'LIKE', "%{$search_query}%")->paginate(30);


        return view('wecommerce::back.clients.index')
        ->with('clients', $client);
    }

    public function filter($order , $filter)
    {
        $wishlists = Wishlist::all();
        $client = User::orderBy($filter, $order)->paginate(30);
        return view('wecommerce::back.clients.index')
        ->with('wishlists', $wishlists)
        ->with('clients', $client);

    }
}
