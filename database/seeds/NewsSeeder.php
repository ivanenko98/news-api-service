<?php

use App\Entities\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['em']->getClassMetaData(News::class)->setTableName('news');
        entity(News::class, 40)->create();
    }
}
