<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
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

        return response()->json(['message' => 'تماس با موفقیت ثبت شد', 'data' => $call], 200);
    }

    public function index()
    {
        return Call::all();
    }

    public function show($data)
    {
    }
}
