<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;

use App\Models\User;
use App\Models\Client;
use App\Models\UserAddress;

use App\Models\Wishlist;

use Illuminate\Http\Request;

class ClientController extends Controller
{
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

        return view('back.clients.index')
        ->with('clients', $clients)
        ->with('new_clients', $new_clients)
        ->with('clients_today', $clients_today)
        ->with('wishlists', $wishlists)
        ->with('wishlists_today', $wishlists_today);
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

        return view('back.clients.show')->with('client', $client)->with('wishlist', $wishlist)->with('addresses', $addresses)->with('orders', $orders);
    }

    public function indexWishlist()
    {
        $wishlists = Wishlist::all();

        return view('back.clients.filters.wishlist')
        ->with('wishlists', $wishlists);
    }

    public function indexNew()
    {
        $clients = User::where('created_at', '>=', Carbon::now()->subWeek())->get();

        return view('back.clients.filters.new')
        ->with('clients', $clients);
    }

    //Add Address
    public function addAddress (Request $request)
    {
        UserAddress::create($request->all());
        return redirect()->route('address')->with('status', 'Se ha agregado la dirección');
    }
}
