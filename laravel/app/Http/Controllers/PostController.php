<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyUsersPostCreated;
use App\Mail\CommentPostedMail;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
            $hasFile = $request->hasFile('thumnail');
            if ($hasFile) {
                $path = $request->file('thumnail')->store('thumnails');
                $url = Storage::url($path);
                $post->image()->create(['path' => $url]);
                return 'post is created';
                /*    // dd($file->getClientMimeType(), $file->getClientOriginalExtension());
                //put // dd($file->storeAs('thumnails', $file->hashName()));
                // dd(Storage::putFile('thumnails', $file));
                $name1 = $file->storeAs('thumnails', $file->hashName());

                //get url
                $url = Storage::url($name1);
                */
            }
            exit();
            // if ($post) {
            //     return 'created';
            // }
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
    public function sendEmail()
    {
        $post = Post::all()->last();
        // Mail::to('iamnishanthveema@gmail.com')->send(
        //     new CommentPostedMail($post)
        // );
        NotifyUsersPostCreated::dispatch($post)->onConnection('database')->onQueue('high');
        /* Mail::to('iamnishanthveema@gmail.com')->queue(
            new CommentPostedMail($post)
        );

        $when = now()->addMinutes(10);
        Mail::to('iamnishanthveema@gmail.com')->later(
            $when,
            new CommentPostedMail($post)
        );*/
        dd('mail sent');
    }
}
