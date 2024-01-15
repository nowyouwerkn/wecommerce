<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

    protected $table = 'user_queries';
    protected $primaryKey = 'id';

    protected $guarded = [];
}
