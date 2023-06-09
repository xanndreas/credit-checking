<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'surveys';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'domicile_address',
        'office_address',
        'guarantor_address',
        'approval_id',
        'requester_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function approval()
    {
        return $this->belongsTo(Approval::class, 'approval_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function office_surveyors() {
        return $this->belongsToMany(User::class, 'survey_user_offices', 'survey_id', 'user_office_id');
    }

    public function domicile_surveyors() {
        return $this->belongsToMany(User::class, 'survey_user_domiciles', 'survey_id', 'user_domicile_id');
    }

    public function guarantor_surveyors() {
        return $this->belongsToMany(User::class, 'survey_user_guarantors', 'survey_id', 'user_guarantor_id');
    }
}
