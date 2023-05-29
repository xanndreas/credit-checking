<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebtorInformation extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'debtor_informations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ID_TYPE_SELECT = [
        'ktp'      => 'KTP',
        'passport' => 'Passport',
        'npwp'     => 'NPWP',
    ];

    protected $fillable = [
        'debtor_name',
        'id_type',
        'id_number',
        'partner_name',
        'guarantor_id_number',
        'guarantor_name',
        'auto_planner_information_id',
        'shareholders',
        'shareholder_id_number',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function auto_planner_information()
    {
        return $this->belongsTo(AutoPlanner::class, 'auto_planner_information_id');
    }
}
