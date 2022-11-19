<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();

        $type1 = \App\Models\Type::create([
            "name" => "Deska",
            "description" => ""
        ]);
        $type2 = \App\Models\Type::create([
            "name" => "Miza",
            "description" => ""
        ]);

        $type1->hasManyItems()->create([
            "title" => "Nek izdelek",
            "description" => "Nek izdelek description",
            "available" => true,
            "price" => 123,
            "main_image" => "uploads/0qmQw77uMI6c4kGxUpUIDvtoG6G7DYUQXT5oq3WG.jpg",
        ]);
        $type2->hasManyItems()->create([
            "title" => "Nek izdelek za mize",
            "description" => "Nek izdelek description miza mizica",
            "available" => true,
            "price" => 456,
            "main_image" => "uploads/2xKrQcPMdVTa9xbBTwT902KUB2S7txbPysgbpXXj.jpg",
        ]);
        //uploads/0qmQw77uMI6c4kGxUpUIDvtoG6G7DYUQXT5oq3WG.jpg
    }
}
