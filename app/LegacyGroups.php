<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyGroups extends Model
{
    protected $table = 'groups';

    public function people()
    {
        return $this->belongsToMany('App\LegacyPeople', 'person_groups', 'group_id', 'person_id');
    }

    protected $connection = 'legacy';
}
