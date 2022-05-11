<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Jobs\CommentStoreJob;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $input = $request->validated();
        $input['admin_id'] = Auth::user()->id;
        $comment = CommentStoreJob::dispatchSync($input);

        return response()->json(['message' => __('messages.comment.success_store'), 'data' => $comment], 201);
    }
}
