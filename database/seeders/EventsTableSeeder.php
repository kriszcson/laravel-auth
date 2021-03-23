<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{

    public function run()
    {
        \App\Models\Event::factory()->count(10)->create(); 
    }
}
