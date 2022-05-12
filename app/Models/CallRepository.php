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

        return  Call::with('comments')->simplePaginate(5);
    }


    public function show($data)
    {
    }
}
