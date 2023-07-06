<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'approvals';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'status',
        'slik',
        'approval_user_id',
        'dealer_information_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }

    public function dealer_information()
    {
        return $this->belongsTo(DealerInformation::class, 'dealer_information_id');
    }
}
