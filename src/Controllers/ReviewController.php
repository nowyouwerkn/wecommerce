<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;

use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Review;
use Nowyouwerkn\WeCommerce\Models\Notification;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new Notification;
    }

    public function index()
    {
        $reviews = Review::where('is_approved', true)->get();

        $reviews_pending = Review::where('is_approved', false)->get();

        return view('wecommerce::back.reviews.index')->with('reviews', $reviews)->with('reviews_pending', $reviews_pending);
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $product_id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'review' => 'required|min:10'
        ));

        $product = Product::find($product_id);
        $review = new Review();

        $review->name = $request->name;
        $review->email = $request->email;
        $review->review = $request->review;
        $review->is_approved = false;
        $review->product()->associate($product);

        $review->save();

        // Notificación
        $type = 'Reseña';
        $by = Auth::user();
        $data = 'dejó una reseña para: ' . $product->name;

        $this->notification->send($type, $by ,$data);

        Session::flash('success', 'Gracias por tu reseña. La estamos revisando para publicarla lo antes posible.');

        return redirect()->route('detalle', [$product->slug]);
    }

    public function show($id)
    {
        //
    }

    public function approve($id)
    {
        $review = Review::find($id);

        $review->is_approved = true;
        $review->save();

        // Notificación
        $type = 'Reseña';
        $by = Auth::user();
        $data = 'aprobó una reseña.';

        $this->notification->send($type, $by ,$data);

        Session::flash('success', 'Reseña aprobada con éxito. Aparecerá en el detalle de producto en breve.');

        return redirect()->back();
    }

    public function disapprove($id)
    {
         $review = Review::find($id);

         $review->is_approved = false;
         $review->save();

         Session::flash('success', 'Reseña bloqueada. No aparecerá en el producto.');

         return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        $review->delete();

        // Notificación
        $type = 'Reseña';
        $by = Auth::user();
        $data = 'eliminó una reseña.';

        $this->notification->send($type, $by ,$data);

        return redirect()->back();
    }
}
