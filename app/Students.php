<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    protected  $primaryKey='stu_id';
    public 	  $timestamps = false;
    protected $fillable = ['stu_name','stu_age','stu_address1','stu_status','stu_address2'];
}
