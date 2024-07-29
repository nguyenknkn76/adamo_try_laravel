<?php
namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}