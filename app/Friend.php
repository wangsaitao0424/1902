<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friend';
    protected $primaryKey='friend_id';
    public 	  $timestamps = false;
    protected $fillable = ['site_name','friend_url','con_type','friend_linkman','files','friend_desc','is_state'];
}
