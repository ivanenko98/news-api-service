<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

final class NewsRequestData extends DataTransferObject
{
    public string $title;

    public string $text;
}
