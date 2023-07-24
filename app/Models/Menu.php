<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'parent_id',
        'ordering',
        'status',
    ];
    public function children()
    {
       return $this->hasMany(Menu::class, 'parent_id');
    }
    public function parents()
    {
        return $this->belongsTo(Menu::class);
    }
}
