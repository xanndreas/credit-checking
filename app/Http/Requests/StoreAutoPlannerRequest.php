<?php

namespace App\Http\Requests;

use App\Models\AutoPlanner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAutoPlannerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('auto_planner_create');
    }

    public function rules()
    {
        return [
            'auto_planner_name_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}
