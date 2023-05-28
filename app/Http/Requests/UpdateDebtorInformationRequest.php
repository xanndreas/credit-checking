<?php

namespace App\Http\Requests;

use App\Models\DebtorInformation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDebtorInformationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('debtor_information_edit');
    }

    public function rules()
    {
        return [
            'debtor_name' => [
                'string',
                'required',
            ],
            'id_type' => [
                'required',
            ],
            'id_number' => [
                'string',
                'required',
            ],
            'partner_name' => [
                'string',
                'nullable',
            ],
            'guarantor_id_number' => [
                'string',
                'nullable',
            ],
            'guarantor_name' => [
                'string',
                'nullable',
            ],
            'auto_planner_information_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
