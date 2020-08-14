<?php

namespace App\Console\Commands;

use App\Entities\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\NewsRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ArchiveNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive old news';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return string
     */
    public function handle()
    {
        $rep = new NewsRepository(app('em'), app('em')->getClassMetaData(News::class));

        $oldNews = $rep->getOldNews();

        foreach ($oldNews as $news) {
            $rep->archive($news->id);
        }

        return 'success';
    }
}
