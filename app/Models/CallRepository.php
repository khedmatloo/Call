<?php

namespace App\Models;

use App\Models\Call;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallRepository
{

    public function store($input)
    {
        return Call::create($input);
    }

    public function index()
    {
        return Call::all();
    }

    public function show($data)
    {
    }
}
