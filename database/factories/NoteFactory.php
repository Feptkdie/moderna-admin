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
            "title" => $this->faker->name,
            "address" => $this->faker->address,
            "phone" => $this->faker->phoneNumber,
            "description" => $this->faker->text,
            "coord_x" => "47.91960245308338",
            "coord_y" => "106.9517069618988",
        ];
    }
}
