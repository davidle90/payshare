<?php

namespace Davidle90\Payshare\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'group_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'group_id', 'id');
    }
}
