<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyReport extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'survey_reports';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'parking_access',
        'owner_status',
        'owner_beneficial',
        'office_note',
        'survey_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function survev_report_attributes() {
        return $this->belongsToMany(SurveyReportAttribute::class, 'survey_report_survey_report_attributes',
            'survey_report_id', 'survey_report_attribute_id');
    }
}
