<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'team_name',
        'team_leader_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function team_leader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
