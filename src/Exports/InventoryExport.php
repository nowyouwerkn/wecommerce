<?php

namespace Nowyouwerkn\WeCommerce\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Illuminate\Support\Facades\Schema;
use Nowyouwerkn\WeCommerce\Models\StockRecord;

class InventoryExport implements FromCollection
{
    public function collection()
    {
       return StockRecord::all();
    }
}
