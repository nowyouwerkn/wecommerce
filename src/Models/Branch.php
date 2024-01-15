<?php

namespace Nowyouwerkn\WeCommerce\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function inventory()
    {
        return $this->belongsTo(BranchInventory::class, 'branch_id', 'id');
    }
}
