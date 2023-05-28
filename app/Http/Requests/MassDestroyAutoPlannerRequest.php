<?php

namespace App\Http\Requests;

use App\Models\AutoPlanner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAutoPlannerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('auto_planner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:auto_planners,id',
        ];
    }
}
