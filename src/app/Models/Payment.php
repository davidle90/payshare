<?php

namespace Davidle90\Payshare\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'label',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function contributors()
    {
        return $this->hasMany(Contributor::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Member::class, 'payment_participant');
    }
}
