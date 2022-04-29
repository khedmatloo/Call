<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Jobs\CallStoreJob;


class CallController extends Controller
{
    public function store(CallRequest $request)
    {
        CallStoreJob::dispatch($request->all());
        echo json_encode($request->user_id);
        $content = ['message' => 'تماس با موفقیت ثبت شد',];
        return response()->json($content, 200);
    }

    public function index()
    {
        return Call::all();
    }

    public function show($data)
    {
    }
}
