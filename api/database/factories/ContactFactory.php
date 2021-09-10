<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    static $user_id = null;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition( )
    {
        return [
            'name' => $this->faker->firstName( ).' '.$this->faker->lastName( ),
            'user_id' => self::$user_id,
        ];
    }
}
