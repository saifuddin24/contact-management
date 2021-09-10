<?php

namespace Database\Factories;

use App\Models\ContactEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactEmailFactory extends Factory
{



    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactEmail::class;

    static $contact_id = null;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            'email' => $this->faker->unique(false, 5000000)->email(),
            'contact_id' => self::$contact_id,
        ];
    }
}
