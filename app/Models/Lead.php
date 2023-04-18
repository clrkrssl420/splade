<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'leads';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'phone',
        'description',
        'user_id',
        'lead_status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lead_status()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('M-d-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('M-d-Y');
    }
}
