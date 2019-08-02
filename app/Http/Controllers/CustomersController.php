<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function list()
    {
	      $customers = Customer::all();

		    return view('internals.customers',[
				    'customers' => $customers
		    ]);
    }

    public function store()
    {
	      $customers = new Customer();
	      $customers -> name = request('name');
				$customers -> save();
				return back();
    }
}
