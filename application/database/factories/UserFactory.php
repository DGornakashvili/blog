<?php

namespace Database\Factories;

use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class UserFactory
 *
 * @package Database\Factories
 */
class UserFactory extends Factory
{
    /**
     * @inheritdoc
     */
    protected $model = User::class;

    /**
     * @inheritdoc
     */
    public function definition(): array
    {
        return [
            'name' => env('APP_USER'),
            'email' => env('APP_EMAIL'),
            'password' => Hash::make(env('APP_PASSWORD')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
