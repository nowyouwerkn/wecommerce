<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Review;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/*Loyalty system*/
use Nowyouwerkn\WeCommerce\Models\UserPoint;
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
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

    public function store(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'review' => 'required|min:10'
        ));

        $product = Product::find($id);
        $user = User::where('email', $request->email)->first();

        $review = new Review();

        if (!empty($user)) {
            $review->user_id = $user->id;

            $membership = MembershipConfig::where('is_active', true)->first();

            if (!empty($membership)){
                if($membership->on_review == true){
                    $points = new UserPoint;
                    $points->user_id = $user->id;
                    $points->type = 'in';
                    $points->value = $membership->points_review;

                    if ($membership->has_expiration_time == true){
                        $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                    }

                    $points->save();
                }
            }

        }

        $review->name = $request->name;
        $review->email = $request->email;
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->is_approved = false;
        $review->product()->associate($product);

        $review->save();

        // Notificación
        $type = 'Reseña';
        $by = NULL;
        $data = 'Un usuario dejó una reseña para: ' . $product->name;
        $model_action = "create";
        $model_id = $product->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        Session::flash('success', 'Gracias por tu reseña. La estamos revisando para publicarla lo antes posible.');

        return redirect()->back();
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
        $model_action = "update";
        $model_id = $review->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        Session::flash('success', 'Reseña aprobada con éxito. Aparecerá en el detalle de producto en breve.');

        return redirect()->back();
    }

    public function disapprove($id)
    {
         $review = Review::find($id);

         $review->is_approved = false;
         $review->save();

         Session::flash('success', 'Reseña bloqueada. No aparecerá en el producto. Puedes eliminarla si asi lo prefieres.');

         return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $review = Review::find($id);



        // Notificación
        $type = 'Reseña';
        $by = Auth::user();
        $data = 'eliminó una reseña.';
        $model_action = "delete";
        $model_id = $review->id;
        $review->delete();

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        Session::flash('success', 'Reseña eliminada exitosamente. Ya no se mostrará en los productos.');

        return redirect()->back();
    }
}
