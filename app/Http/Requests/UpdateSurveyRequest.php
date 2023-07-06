<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSurveyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('survey_edit');
    }

    public function rules()
    {
        return [
            'domicile_address' => [
                'string',
                'required',
            ],
            'office_address' => [
                'string',
                'required',
            ],
            'guarantor_address' => [
                'string',
                'required',
            ],
            'requester_id'=> [
                'integer',
                'required',
            ],
        ];
    }
}
