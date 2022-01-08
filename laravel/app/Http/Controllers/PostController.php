<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\Comments;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showForm()
    {
        return view('showForm');
    }

    public function Home()
    {
        return view('home');
    }

    public function create(Request $request)
    {
        try {
            $post = Post::create($request->all());
            if ($post) {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function get()
    {
        try {
            $post = Post::all();
            return $post;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function test(Post $post)
    {
        $post = Post::with('comments')->find(2);
        return $post;
        // dd($post->comments()->with('post')->get()->toArray());
        return $post->with('comments')->get();
    }
}
