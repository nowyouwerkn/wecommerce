<?php

namespace  Nowyouwerkn\WeCommerce\Imports;

use Nowyouwerkn\WeCommerce\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
           'name'     => $row[0],
           'slug'    => Str::slug($row[0]), 
           'description' => $row[1],
           'price' => $row[2],
        ]);
    }
}
