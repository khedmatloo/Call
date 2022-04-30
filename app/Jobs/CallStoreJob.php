<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CallRepository;

class CallStoreJob
{
    use Dispatchable, SerializesModels;

    private $input;
    public function __construct($input)
    {
        $this->input = $input;
    }


    public function handle(CallRepository $callRepository)
    {
        return $callRepository->store($this->input);
    }
}
