<?php

namespace Nowyouwerkn\WeCommerce\Exports;

use Nowyouwerkn\WeCommerce\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientExport implements FromView
{
    public function view(): View
    {
        return view('wecommerce::back.exports.clients', [
            'clients' => User::role('customer')->get()
        ]);
    }
}
