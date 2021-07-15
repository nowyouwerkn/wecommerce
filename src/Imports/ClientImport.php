<?php

namespace  Nowyouwerkn\WeCommerce\Imports;

use Nowyouwerkn\WeCommerce\Models\User;
use Illuminate\Support\Facades\Hash;

//Importación por medio de Colección
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*
    public function model(array $row)
    {
        return new User([
           'name'     => $row[0],
           'email'    => $row[1], 
           'password' => Hash::make($row[2]),
        ])->assignRole('customer');
    }
    */

    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {
            $client = User::create([
                'name' => $row[1],
                'email' => $row[2], 
                'password' => bcrypt($row[3]),
            ]);
            $client->assignRole('customer');
        }
    }
}
