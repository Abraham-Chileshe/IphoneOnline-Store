<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name_en' => 'Moscow',
                'name_ru' => 'Москва',
                'slug' => 'Moscow',
                'is_active' => true,
            ],
            [
                'name_en' => 'Saint Petersburg',
                'name_ru' => 'Санкт Петербург',
                'slug' => 'Saint Petersburg',
                'is_active' => true,
            ],
            [
                'name_en' => 'Novokuznetsk',
                'name_ru' => 'Новокузнецк',
                'slug' => 'Novokuznetsk',
                'is_active' => true,
            ],
        ];

        foreach ($cities as $city) {
            \App\Models\City::create($city);
        }
    }
}
