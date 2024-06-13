<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access_Permission extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'access_permission';
    protected $fillable = ['role_id','status','name','slug'];

}
