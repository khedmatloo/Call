<?php

namespace App\Models;

use App\Models\Call;


class CallRepository
{

    public function store($input)
    {
        return Call::create($input);
    }

    public function index()
    {
        $calls = Call::with('comments')->get();
        return $calls;
    }

    public function show($data)
    {
    }
}
