<?php

namespace App\index;

use Illuminate\Database\Eloquent\Model;

class Index_User extends Model
{
    protected $table = 'index_user';
    protected $primaryKey='user_id';
    public $timestamps=false;
    protected $fillable = ['emil','pwd'];
}
