<?php


namespace App\Repositories\Interfaces;


interface NewsRepositoryInterface
{
    public function create($title, $text, $created_at, $updated_at);

    public function update($news, $title = null, $text = null, $created_at = null, $updated_at = null);

    public function archive($id);

    public function restore($id);

    public function getOldNews($days = 30);
}
