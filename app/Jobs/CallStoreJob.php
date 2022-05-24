<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\CallRepository;
use App\Exceptions\Calls\InvalidOrderException;

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
        return $callRepository->create(['data' => $this->input]);
    }
}
