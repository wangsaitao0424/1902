<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Admin_User extends Model
{
    protected $table = 'admin_user';
    protected $primaryKey='user_id';
    public $timestamps=false;
    protected $fillable = ['usre_name','user_pwd','files','user_sex','user_grade','insert_time'];
}
