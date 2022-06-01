<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\LogRepository;

class LogStoreJob
{
    use Dispatchable, SerializesModels;

    private $input;
    public function __construct($input)
    {
        dd($input);
        $this->input = $input;
    }


    public function handle(LogRepository $logRepository)
    {
        return $logRepository->create(['data' => $this->input]);
    }
}
