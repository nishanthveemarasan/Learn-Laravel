<?php

namespace Database\Factories;

use App\Models\Comments;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Comments::class;
    public function definition()
    {
        return [
            'uuid' => (string)Str::orderedUuid(),
            'content' => $this->faker->text(),
            'commentable_id' => Post::factory(),
            'commentable_type' => Post::class
        ];
    }
}
