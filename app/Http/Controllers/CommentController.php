<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Jobs\CommentStoreJob;
use App\Models\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $input = $request->validated();
        $input['admin_id'] = Auth::user()->id;
        $comment = CommentStoreJob::dispatchSync($input);

        return response()->success($comment);
    }
    public function delete($id, CommentRepository $callRepository)
    {
        $data = $callRepository->delete(['id' => $id]);
        return response()->success($data);
    }
}
