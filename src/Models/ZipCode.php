<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;

    protected $table = 'wk_zip_codes';
    protected $primaryKey = 'id';
    
    protected $fillable = ['country_id', 'int_code', 'zip_code', 'suburb', 'state', 'municipality', 'city'];
}