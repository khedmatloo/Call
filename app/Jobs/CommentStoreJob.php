<?php

namespace App\Jobs;

use App\Models\CommentRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentStoreJob implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    private $input = [];
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CommentRepository $commentRepository)
    {
        return $commentRepository->create(['data' => $this->input]);
    }
}
