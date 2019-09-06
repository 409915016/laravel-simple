<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //protected $fillable = ['phone'];

		protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
