<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Client;
use Nowyouwerkn\WeCommerce\Models\UserAddress;
use Nowyouwerkn\WeCommerce\Models\Wishlist;

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

        $clients = User::role('customer')->get();
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
        ));

        $client = User::create([
            'name' => $request->name,
            'code' => $request->code,
            'slug' => Str::slug($request->name),
        ]);

        //Session message
        Session::flash('success', 'El cliente fue registrado exitosamente.');

        return redirect()->route('cities.show', $city->id);
    }

    public function show($id)
    {
        $client = User::find($id);
        $wishlist = Wishlist::where('user_id', $client->id)->get();
        $addresses = UserAddress::where('user_id', $client->id)->get();

        $orders = $client->orders;
        
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

        return view('wecommerce::back.clients.show')->with('client', $client)->with('wishlist', $wishlist)->with('addresses', $addresses)->with('orders', $orders);
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
}
