<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleSiderBarJoin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role_sider_bar_joins';
    protected $fillable = ['role_id', 'siderbar_id', 'permission'];
}
