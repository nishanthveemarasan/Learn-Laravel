<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
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
}
