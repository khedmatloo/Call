<?php

namespace App\Models;

use App\Models\Comment;


class CommentRepository
{

    public function store($input)
    {
        return Comment::create($input);
    }
}
