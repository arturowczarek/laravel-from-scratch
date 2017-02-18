<?php

namespace App\Http\Controllers;

use App\Post;

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

    public function store()
    {
//        $post = new Post;
//        $post->title = request('title');
//        $post->body = request('body');
//        $post->save();

//        Post::create([
//            'title' => request('title'),
//            'body' => request('body')
//        ]);

//        Post::create(request()->all());

        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        Post::create(request(['title', 'body']));

        return redirect('/');
    }
}
