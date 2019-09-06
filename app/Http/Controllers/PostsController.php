<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show(\App\Post $post)
    {
        return $post;
    }
}
