<?php

namespace App\Jobs;

use App\Events\LogEvent;
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

        $result = $callRepository->create(['data' => $this->input]);
        event(new LogEvent($this->input));
        return $result;
    }
}
