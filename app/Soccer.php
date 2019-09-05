<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soccer extends Model
{
    protected $table = 'soccer';
    protected $primaryKey='soccer_id';
    public 	  $timestamps = false;
    protected $fillable = ['nba1','nba2','finish_time','soccer_result'];
}
