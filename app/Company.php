<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
//    protected $guarded = [];

    protected $fillable = [
        'name', 'price', 'quantity'
    ];

    public function customers()
    {
    	return $this->hasMany(Customer::class);
    }
}
