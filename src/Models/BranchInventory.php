<?php

namespace Nowyouwerkn\WeCommerce\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchInventory extends Model
{
    use HasFactory;

    protected $table = 'branch_inventory';
    protected $primaryKey = 'id';

}
