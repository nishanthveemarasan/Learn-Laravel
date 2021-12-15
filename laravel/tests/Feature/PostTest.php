<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_no_posts_when_no_data_in_table()
    {
        $post = new Post();
        $post->title = 'a';
        $post->content = 'csc';
        $post->save();

        $this->assertDatabaseHas('posts', [
            'title' => 'a'
        ]);
    }
}
