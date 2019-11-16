<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyPersonEmails extends Model
{
    protected $table = 'person_emails';

    public function person()
    {
        return $this->belongsTo('App\LegacyPeople', 'person_id', 'id');
    }

    protected $connection = 'legacy';
}
