<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configure extends Model
{
    use HasFactory;
    protected $fillable = [
        'configure_title',
        'configure_name',
        'configure_value',
        'configure_type',
        'configure_publish',
        'configure_ordering',
        'group_name',
        'group_ordering',
    ];

}
