<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;
    public function definition()
    {
        return [
            'uuid' => (string)Str::orderedUuid(),
            'title' => $this->faker->title(),
            'content' => $this->faker->text()
        ];
    }
}
