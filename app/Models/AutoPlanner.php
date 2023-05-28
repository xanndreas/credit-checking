<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoPlanner extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'auto_planners';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_RADIO = [
        'individu'    => 'Individu',
        'badan_usaha' => 'Badan Usaha',
    ];

    protected $fillable = [
        'auto_planner_name_id',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function auto_planner_name()
    {
        return $this->belongsTo(User::class, 'auto_planner_name_id');
    }
}
