<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Admin_Brand extends Model
{
    protected $table = 'admin_brand';
    protected $primaryKey='brand_id';
    public $timestamps=false;
    protected $fillable = ['brand_name','site_url','brand_logo','sort_order','is_show'];
}
