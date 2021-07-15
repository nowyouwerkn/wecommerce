<?php

namespace Nowyouwerkn\WeCommerce\Exports;

use Nowyouwerkn\WeCommerce\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }
}
