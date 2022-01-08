<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Events\CommentPosted;
use App\Mail\CommentPostedMail;
use App\Jobs\NotifyUsersPostCreated;
use Illuminate\Support\Facades\Gate;
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
    public function index()
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
        // NotifyUsersPostCreated::dispatch($post)->onConnection('database')->onQueue('high');
        /* Mail::to('iamnishanthveema@gmail.com')->queue(
            new CommentPostedMail($post)
        );

        $when = now()->addMinutes(10);
        Mail::to('iamnishanthveema@gmail.com')->later(
            $when,
            new CommentPostedMail($post)
        );*/
        // event(new CommentPosted($post));
        CommentPosted::dispatch($post);
        dd('mail sent');
    }

    public function get(Post $post)
    {
        if (Gate::denies('update-post', $post)) {
            abort(404,  "you cant edit the page");
        }
        dd($post->toArray());
    }

    public function destroy(Post $post)
    {
        // Gate::authorize('delete-post', $post);
        // Gate::authorize('edit-post', [$post, false]);
        $response = Gate::inspect('edit-post', [$post, false]);
        dd($response);
        dd($post->toArray());
    }
    public function update(Post $post)
    {
        $response = Gate::inspect('edit-post', [$post, false]);
        if (!$response->allowed()) {
            return ['message' => $response->message()];
        }
        dd($post->toArray());
    }
}
