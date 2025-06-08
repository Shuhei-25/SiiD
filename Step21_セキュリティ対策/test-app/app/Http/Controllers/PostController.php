<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts=Post::all();
        $posts=Post::paginate(5);
        return view( 'post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate ([
        'title' => 'required|max:20',
        'body' => 'required|max:400',
        ]);

    $validated ['user_id'] = auth()->id();

    $post = Post::create($validated);

    $request->session()->flash('message', 'Saved');
    return redirect ()->route('post.index');
    }

    public function show(Post $post)
    {
        return view( 'post.show', compact ('post'));
    }
    
    public function edit(Post $post)
    {
        return view('post.edit', compact ('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
        'title' => 'required|max:20',
        'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()-> id();

        $post->update($validated);

        $request->session()->flash('message', 'Updated');
        return redirect()->route( 'post.show', compact('post'));
    }

    public function destroy(Request $request, Post $post)  
    {
        $post->delete();
        $request->session()->flash('message','Deleted');
        return redirect()->route('post.index');
        }
        

}