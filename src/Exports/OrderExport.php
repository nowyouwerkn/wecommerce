<?php

namespace Nowyouwerkn\WeCommerce\Exports;

use Nowyouwerkn\WeCommerce\Models\Order;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    public function view(): View
    {
        return view('wecommerce::back.exports.orders', [
            'orders' => Order::all(),
        ]);
    }
}
