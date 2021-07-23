<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTheme extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function get_name()
    {
        return $this->where('is_active', true)->value('name');
    }
}
