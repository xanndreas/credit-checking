<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreSurveyReportRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('survey_report_create');
    }

    public function rules()
    {
        return [
            'parking_access' => [
                'string',
                'required',
            ],
            'owner_status' => [
                'string',
                'required',
            ],
            'owner_beneficial' => [
                'string',
                'required',
            ],
            'office_note' => [
                'string',
                'required',
            ],
            'attachments' => [
                'array',
                'required',
            ],
            'attachments.*' => [
                'required',
            ],
        ];
    }
}
