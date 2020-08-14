<?php

namespace App\Http\Controllers;

use App\Entities\News;
use App\Http\Requests\NewsRequest;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Carbon\Carbon;

class NewsController extends Controller
{
    private $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;

        app()['em']->clear();

        if (request()->archived == true) {
            app()['em']->getClassMetaData(News::class)->setTableName('archived_news');
        } else {
            app()['em']->getClassMetaData(News::class)->setTableName('news');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = $this->newsRepository->paginateAll();

        $response = $this->formatResponse('success', null, $news);
        return response($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $now = Carbon::now();
        $news = $this->newsRepository->create($request->data()->title, $request->data()->text, $now, $now);

        $response = $this->formatResponse('success', null, $news->toArray());
        return response($response, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = $this->newsRepository->find($id);
        $this->newsRepository->update($news, $request->title, $request->text, null, Carbon::now());

        $response = $this->formatResponse('success', null, $news->toArray());
        return response($response, 200);
    }

    public function archive($id)
    {
        $news = $this->newsRepository->archive($id);

        $response = $this->formatResponse('success', null, $news->toArray());
        return response($response, 200);
    }

    public function restore($id)
    {
        $news = $this->newsRepository->restore($id);

        $response = $this->formatResponse('success', null, $news->toArray());
        return response($response, 200);
    }
}
