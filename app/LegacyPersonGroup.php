<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyPersonGroup extends Model
{
    protected $table = 'person_groups';

    protected $connection = 'legacy';
}
