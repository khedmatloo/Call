<?php

namespace App\Models;

use App\Models\Call;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallRepository
{

    public static function store($input)
    {
        echo json_encode($input);
        DB::table('calls')->insert([
            'user_id' => $input->user_id,
            'user_type' => $input->user_type,
            'admin_id' => Auth::user()->id,
            'order_id' => $input->order_id,
            'category' => $input->category,
            'subcategory' => $input->subcategory,
            'description' => $input->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function index()
    {
        return Call::all();
    }

    public function show($data)
    {
    }
}
