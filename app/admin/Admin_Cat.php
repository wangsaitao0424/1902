<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Admin_Cat extends Model
{
    protected $table='admin_cat';
    protected $primaryKey='cat_id';
    public    $timestamps=false;
    protected $fillable = ['cat_name','parent_id','sort_order'];
}
