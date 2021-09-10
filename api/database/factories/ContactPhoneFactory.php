<?php

namespace Database\Factories;

use App\Models\ContactPhone;
use Illuminate\Database\Eloquent\Factories\Factory;


class ContactPhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactPhone::class;

    static $contact_id = null;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone_number' => $this->faker->unique(false, 5000000)->phoneNumber(),
            'contact_id' => self::$contact_id,
        ];
    }
}
