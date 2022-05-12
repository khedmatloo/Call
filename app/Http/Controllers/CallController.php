<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Jobs\CallIndexJob;
use App\Models\Call;
use App\Jobs\CallStoreJob;
use Illuminate\Support\Facades\Auth;



class CallController extends Controller
{
    public function store(CallRequest $request)
    {
        $inputs = $request->validated();
        $inputs['admin_id'] = Auth::user()->id;
        $call = CallStoreJob::dispatchSync($inputs);

        return response()->success($call);
    }

    public function index()
    {
        $calls = CallIndexJob::dispatchSync();
        return response()->success($calls);
    }

    public function show($data)
    {
    }
}
