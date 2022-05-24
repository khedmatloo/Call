<?php

namespace App\Models;

use App\Models\Base\BaseRepository;
use App\Models\Call;
use Illuminate\Support\Arr;


class CallRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Call::class);
    }
    public function addWhereToGetAll($query, $params)
    {
        if (Arr::get($params, 'inputs')) {
            if (Arr::has($params['inputs'], 'order_id')) {
                $query = $query->where('order_id', $params['inputs']['order_id']);
            }
            if (Arr::has($params['inputs'], 'user_id')) {
                $query = $query->where('user_id', $params['inputs']['user_id']);
            }
        } //end if
        return $query;
    }
}
