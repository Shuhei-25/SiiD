<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    
    
    public function index () {
        $posts=Post::all ();
        return view('post.index', compact ('posts'));
    }

    public function create() {
        return view('post.create');
    }

    


    public function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|max:20',
        'body' => 'required|max:400',
    ]);

    $validated['user_id'] = auth()->id(); // 認証ユーザーIDをセット

    Post::create($validated); // モデルのcreateで保存

    $request->session()->flash('message', 'Changed');
    return redirect()->route('post.index'); // 投稿一覧へリダイレクト
}


    public function show($id) {
        $post=post::find($id);
        return view('post.show', compact('post'));
    }
    
    public function edit(Post $post) {
        return view('post.edit', compact('post'));
       
    }
    public function destroy (Request $request,Post $post) {
        $post->delete ();
        $request->session()->flash('message','Deleted');
        return redirect('post');
    }


}