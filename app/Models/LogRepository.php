<?php

namespace App\Models;

use App\Models\Base\BaseRepository;
use App\Models\Log;


class LogRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Log::class);
    }
}
