<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(Profile $profile)
    {
        return $profile;
    }
}
