<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;

use App\Models\Product;
use App\Models\Review;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('is_approved', true)->get();

        $reviews_pending = Review::where('is_approved', false)->get();

        return view('back.reviews.index')->with('reviews', $reviews)->with('reviews_pending', $reviews_pending);
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

        Session::flash('success', 'Thanks for your review. Pending moderation.');

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

         Session::flash('success', 'User Review is_approved!');

         return redirect()->back();
    }

    public function disapprove($id)
    {
         $review = Review::find($id);

         $review->is_approved = false;
         $review->save();

         Session::flash('success', 'User Review is_approved!');

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

        return redirect()->back();
    }
}
