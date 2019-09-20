<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => '1',
            'header' => 'Первая запись',
            'body' => 'Для добавления данных в БД используйте Artisan-команду make:seeder. Все начальные данные, сгенерированные фреймворком, будут помещены в папке database/seeds (для версии 5.1 — database/seeders):',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'header' => 'Вторая запись',
            'body' => 'Класс начальных данных содержит в себе только один метод по умолчанию — run(). Этот метод вызывается, когда выполняется Artisan-команда db:seed. В методе run() вы можете вставить любые данные в БД. Вы можете использовать конструктор запросов, чтобы вручную вставить данные. Также можно воспользоваться фабриками Eloquent моделей.',
        ]);
    }
}
