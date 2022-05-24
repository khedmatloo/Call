<?php

namespace App\Models;

use App\Models\Base\BaseRepository;
use App\Models\Comment;
use Illuminate\Support\Arr;


class CommentRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Comment::class);
    }
    public function addWhereToGetAll($query, $params)
    {
        if (Arr::get($params, 'inputs')) {
            if (Arr::has($params['inputs'], 'commentable_type') and Arr::has($params['inputs'], 'commentable_id')) {
                $query = $query->where('commentable_type', $params['inputs']['commentable_type'])->where('commentable_id', $params['inputs']['commentable_id']);
            }
        } //end if
        return $query;
    }
}
