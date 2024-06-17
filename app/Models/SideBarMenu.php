<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SideBarMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'side_bar_menus';
    protected $fillable = ['name', 'route', 'display_name'];
}
