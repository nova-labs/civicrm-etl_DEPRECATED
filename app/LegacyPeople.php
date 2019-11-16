<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegacyPeople extends Model
{
    protected $table = 'people';

    public function sponsor()
    {
        return $this->hasOne('App\LegacyPeople','id','sponsor_id' );
    }

    public function groups()
    {
        return $this->belongsToMany('App\LegacyGroups', 'person_groups', 'person_id', 'group_id');
    }

    public function machines()
    {
        return $this->belongsToMany('App\LegacyMachines', 'person_machines', 'person_id', 'machine_id');
    }

    public function emails()
    {
        return $this->hasMany('App\LegacyPersonEmails', 'person_id');
    }

    public function stewards()
    {
        return $this->groups()->where('name', 'like', '[steward]%');
    }

    public function equipment()
    {
        return $this->groups()->where('name', 'like', '[equipment]%');
    }

    public function plaingroups()
    {
        return $this->groups()->where('name', 'not like', '[%');
    }

    public function entries()
    {
        return $this->hasMany('App\LegacyPeopleStatusChange', 'people_id');
    }

    public function payments()
    {
        return $this->hasMany('App\StripePayments', 'customer','stripe_customer_id')->orderby('date');
    }

    public function invoices()
    {
        return $this->hasMany('App\StripeInvoices', 'customer','stripe_customer_id')->orderby('date');
    }



    protected $connection = 'legacy';

    protected $hidden = [
        'password',
    ];
}
