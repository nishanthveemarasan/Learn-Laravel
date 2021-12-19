<?php

namespace Tests\Unit;

use App\Models\Comments;
use App\Models\Post;
use App\Models\PostTag;
// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function create_post_model()
    {
        $post = Post::factory()->create();
        $this->assertNotNull($post);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function post_has_more_comments()
    {
        $comments = Comments::factory()
            ->count(3)
            ->forPost()
            ->create();
        $this->assertNotNull($comments);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function posts_has_many_comments()
    {
        $post = Post::factory()
            ->hasPostTags(5)
            ->create();

        /*$tag = PostTag::latest()->first();
        $result = $tag->posts()->get()->toArray();
        $this->assertNotNull($result);*/
        $tags = $post->postTags()->get();
        $this->assertTrue(5 == $tags->count());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function comment_has_many_posts()
    {
        $tags = PostTag::factory()
            ->hasPosts(4)
            ->create();

        /* $tag = Post::latest()->first();
        $result = $tag->postTags()->get()->toArray();*/
        $posts = $tags->posts;
        $this->assertTrue(4 == $posts->count());

        $latestPost = Post::with('postTags')->latest()->first();
        $tagIdofPost = $latestPost->postTags[0]->pivot->tag_id;

        $this->assertTrue($tags->id == $tagIdofPost);

        //$this->assertNotNull($result);
    }
}
