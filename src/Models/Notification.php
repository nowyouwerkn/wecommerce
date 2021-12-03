<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_by',
        'type',
        'data',
        'model_action',
        'model_id',
        'read_at',
        'is_hidden'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'action_by');
    }

}
