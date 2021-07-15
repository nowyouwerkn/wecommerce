<?php

namespace Nowyouwerkn\WeCommerce\Exports;

use Nowyouwerkn\WeCommerce\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::role('customer')->get();
    }
}
