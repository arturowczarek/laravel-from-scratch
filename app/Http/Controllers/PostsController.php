<?php

namespace App\Http\Controllers;

class PostsController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function show($post)
    {
        return view('posts.show');
    }

    public function create()
    {
        return view('posts.create');
    }
}
