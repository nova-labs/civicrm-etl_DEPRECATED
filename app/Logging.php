<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    protected $fillable = ['message', 'error', 'success'];

    protected $table = 'logging';
}
