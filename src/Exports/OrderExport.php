<?php

namespace Nowyouwerkn\WeCommerce\Exports;

use Nowyouwerkn\WeCommerce\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }
}
