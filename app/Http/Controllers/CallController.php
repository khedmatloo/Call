<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallRequest;
use App\Jobs\CallIndexJob;
use App\Jobs\CallStoreJob;
use App\Models\CallRepository;
use Illuminate\Http\Request;
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

    public function index(Request $request, CallRepository $callRepository)
    {
        $calls =  $callRepository->getAll(['inputs' => $request->all()]);

        return response()->success($calls);
    }
    public function delete($id, CallRepository $callRepository)
    {
        $data = $callRepository->delete(['id' => $id]);
        return response()->success($data);
    }
}
