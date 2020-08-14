<?php


namespace App\Repositories;


use App\Entities\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Traits\FormatResponse;
use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class NewsRepository extends EntityRepository implements NewsRepositoryInterface
{
    use PaginatesFromRequest, FormatResponse;

    public function create($title, $text, $created_at, $updated_at)
    {
        $news = new News(
            $title,
            $text,
            $created_at,
            $updated_at
        );

        EntityManager::persist($news);
        EntityManager::flush();

        return $news;
    }

    public function update($news, $title = null, $text = null, $created_at = null, $updated_at = null)
    {
        if ($title) {
            $news->setTitle($title);
        }

        if ($text) {
            $news->setText($text);
        }

        if ($created_at) {
            $news->setCreatedAt($created_at);
        }

        if ($updated_at) {
            $news->setUpdatedAt($updated_at);
        }

        EntityManager::persist($news);
        EntityManager::flush();

        return $news;
    }

    public function archive($id)
    {
        app()['em']->getClassMetaData(News::class)->setTableName('news');
        $news = EntityManager::find(News::class, $id);

        EntityManager::remove($news);
        EntityManager::flush();

        app()['em']->clear();
        app()['em']->getClassMetaData(News::class)->setTableName('archived_news');

        return $this->create($news->title, $news->text, $news->created_at, $news->updated_at);
    }

    public function restore($id)
    {
        app()['em']->getClassMetaData(News::class)->setTableName('archived_news');
        $news = EntityManager::find(News::class, $id);

        EntityManager::remove($news);
        EntityManager::flush();

        app()['em']->clear();
        app()['em']->getClassMetaData(News::class)->setTableName('news');

        return $this->create($news->title, $news->text, $news->created_at, $news->updated_at);
    }

    public function getOldNews($days = 30)
    {
        app()['em']->clear();
        app()['em']->getClassMetaData(News::class)->setTableName('news');

        $repository = EntityManager::getRepository(News::class);

        $query = $repository->createQueryBuilder('e')
            ->where('e.created_at < :date');

        $query = $query->setParameters(array(
            'date' => Carbon::now()->subDays($days)->format('Y-m-d')
        ));

        return $query->getQuery()->getResult();
    }
}
