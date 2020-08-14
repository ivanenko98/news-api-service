<?php

namespace Tests\Feature;

use App\Entities\News;
use App\Repositories\NewsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetListNews()
    {
        $response = $this->get('/api/news');

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
        ]);
    }

    public function testCreateNews()
    {
        $response = $this->postJson('/api/news', [
            'archived' => 0,
            'title' => 'test 1',
            'text' => 'test content 1',
        ]);

        $response->assertStatus(201)->assertJson([
            'status' => 'success',
        ]);
    }

    public function testUpdateNews()
    {
        $news = $this->get('/api/news');

        $id = $news['data']['data'][0]['id'];

        $response = $this->putJson('/api/news/'.$id, [
            'archived' => 0,
            'title' => 'test 1',
            'text' => 'test content 1',
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
        ]);
    }

    public function testArchiveNews()
    {
        $news = $this->get('/api/news');

        $id = $news['data']['data'][0]['id'];

        $response = $this->get('/api/news/archive/'.$id);

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
        ]);
    }

    public function testRestoreNews()
    {
        $news = $this->get('/api/news');

        $newsId = $news['data']['data'][0]['id'];

        $this->get('/api/news/archive/'.$newsId);

        new NewsRepository(app()['em'], app()['em']->getClassMetaData(News::class));

        app()['em']->getClassMetaData(News::class)->setTableName('archive_news');

        $archiveNews = $this->get('/api/news');

        $archiveNewsId = $archiveNews['data']['data'][0]['id'];

        $response = $this->get('/api/news/restore/'.$archiveNewsId);

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
        ]);
    }
}
