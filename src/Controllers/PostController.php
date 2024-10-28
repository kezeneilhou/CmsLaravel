<?php

namespace Kezeneilhou\CmsLaravel\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('contentManagement.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contentManagement.addPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => auth()->id(),
                'slug' => Str::slug($request->title),
                'type' => $request->type,
                'date' => $request->date
            ]);
            DB::commit();
            return redirect()->route('dashboard');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('contentManagement.addPost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try{
            DB::beginTransaction();
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => auth()->id(),
                'slug' => Str::slug($request->title),
                'type' => $request->type,
                'date' => $request->date
            ]);
            DB::commit();
            return redirect()->route('post.edit', $post);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }
}
