<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Description;

class ContactFormController extends Controller
{
	public function create()
	{
		return view('contact.create');
	}

	public function store()
	{
		$data = request()->validate([
				'name' => 'required',
				'email' => 'required|email',
				'message' => 'required'
		]);

		Mail::to('test@test.com')->send(new ContactFormMail($data));

		session()->flash('message', 'Thanks for your message. We\'ll be in touch.');

		return redirect('contact');
	}
}
