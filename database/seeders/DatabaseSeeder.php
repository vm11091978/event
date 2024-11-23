<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.ru',
            'password' => 'admin',
            'is_admin' => 1,
            'active' => 1,
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'ya.vol-vol@yandex.ru',
            'password' => '1234',
            'active' => 1,
        ]);

        Category::firstOrCreate([
            'name' => 'спортивные мероприятия',
            'active' => 1,
        ]);

        Category::firstOrCreate([
            'name' => 'культурные мероприятия',
            'active' => 1,
        ]);

        Event::firstOrCreate([
            'name' => 'Футбольный матч',
            'date' => '2024-12-01 19:30:00',
            'description' => 'Добрый вечер, уважаемые болельщики, я – комментатор Денисова Арина – веду репортаж со стадиона МОУ «СОШ №12», где будут соревноваться две сильнейшие команды: «Орлы» и «Соколы».',
            'active' => 1,
        ])->categories()->attach(1);

        Event::firstOrCreate([
            'name' => 'Марафон',
            'date' => '2024-11-30 09:00:00',
            'description' => 'В ближайшую субботу состоится пробежка по набережным нашего города. Участникам просьба регистрироваться заранее на нашем сайте.',
            'active' => 1,
        ])->categories()->attach(1);

        Event::firstOrCreate([
            'name' => 'Гребля на байдарках',
            'date' => '2024-11-30 12:00:00',
            'description' => 'Это заготовка для статьи.',
        ])->categories()->attach(1);

        Event::firstOrCreate([
            'name' => 'Концерт',
            'date' => '2024-11-30 20:00:00',
            'description' => 'Идея концерта заключается в музыкальном и визуальном путешествии по странам Востока, в прикосновении к их неразгаданной культуре, погружении слушателя в таинственную атмосферу гармонии звуков. Вместе с музыкой, исполняемой Сергеем Гасановым, Вы совершите удивительное путешествие по Востоку. Созданные на сцене декорации в сочетании с необычным звучанием, прорисовками светом и транслируемым видеорядом явят Вам ощущение волшебной атмосферы восточной сказки.',
            'active' => 1,
        ])->categories()->attach(2);

        Event::firstOrCreate([
            'name' => 'Шахматы в ДК',
            'date' => '2024-12-01 15:00:00',
            'active' => 1,
        ])->categories()->attach([1, 2]);
    }
}
