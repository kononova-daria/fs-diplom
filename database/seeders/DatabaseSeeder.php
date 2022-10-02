<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin1@gotocinema.ru',
            'password' => \Hash::make('admin111'),
        ]);

        \App\Models\Type::factory()->create([
            'name' => 'Обычные кресла',
            'key' => 'standard',
        ]);
        \App\Models\Type::factory()->create([
            'name' => 'VIP кресла',
            'key' => 'vip',
        ]);
        \App\Models\Type::factory()->create([
            'name' => 'Заблокированные (нет кресла)',
            'key' => 'blocked',
        ]);
        \App\Models\Type::factory()->create([
            'name' => 'Занятые кресла',
            'key' => 'taken',
        ]);
        \App\Models\Type::factory()->create([
            'name' => 'Выбранные кресла',
            'key' => 'selected',
        ]);
    }
}
