<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                // Generate a random user ID (assuming you have a User model)
                return \App\Models\User::factory()->create()->id;
            },
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}