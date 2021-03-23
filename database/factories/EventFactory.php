<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{

    protected $model = Event::class;

    public function definition()
    {
        return [
            'day' => "2021/04/".rand(1,30),
            'comment' => $this->faker->text,
            'event_type' => rand(1,3),
            'user_id' => rand(1, \App\Models\User::count()),
        ];
    }
}
