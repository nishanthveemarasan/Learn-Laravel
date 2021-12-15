<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = 'Post';
    public function definition()
    {
        return [
            'uuid' => (String)Str::orderedUuid(),
            'title' => $this->faker->name,
            'content' => $this->faker->text
        ];
    }
}
