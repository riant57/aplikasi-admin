<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'code',
    'name',
    'address',
    'city',
    'phone',
    'is_active',
])]

class Branch extends Model
{
    //
}
