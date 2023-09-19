<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    protected $fillable = [
        'query',
        'request',
        'response',
    ];
}