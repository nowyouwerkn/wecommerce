<?php

namespace Nowyouwerkn\WeCommerce\Exports;

// Ayudantes
use DB;
use Str;
use Auth;
use Session;
use PDF;
use Carbon\Carbon;

// Modelos
use Nowyouwerkn\WeCommerce\Models\StockRecord;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\User;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $request = request()->all();

        /* Defining Dates */
        $date_start = Carbon::parse($request['event_date_start'])->startOfDay();
        $date_end = Carbon::parse($request['event_date_end'])->endOfDay();

        $movements = StockRecord::whereBetween('created_at', [$date_start, $date_end])->get();
        //$movements = StockRecord::where('id', '>', '9000')->get();

        return view('wecommerce::back.stocks._export')
        ->with('date_start', $date_start)
        ->with('date_end', $date_end)
        ->with('movements', $movements);
    }

    /*
    public function collection()
    {
       return StockRecord::all();
    }
    */
}
