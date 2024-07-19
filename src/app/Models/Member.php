<?php

namespace Davidle90\Payshare\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contributor::class);
    }

    public function participations()
    {
        return $this->belongsToMany(Payment::class, 'payment_participant');
    }
}
