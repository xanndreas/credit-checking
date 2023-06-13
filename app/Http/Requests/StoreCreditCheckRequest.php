<?php

namespace App\Http\Requests;

use App\Models\DealerInformation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCreditCheckRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('credit_check_create');
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
            'debtor_name' => [
                'string',
                'required',
            ],
            'id_type' => [
                'required',
            ],
            'id_number' => [
                'numeric',
                'required',
                'digits:16',
            ],
            'partner_name' => [
                'string',
                'nullable',
            ],
            'guarantor_id_number' => [
                'numeric',
                'digits:16',
                'nullable',
            ],
            'guarantor_name' => [
                'string',
                'nullable',
            ],
            'dealer_id' => [
                'required',
                'integer',
            ],
            'sales_name' => [
                'string',
                'required',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'brand_id' => [
                'required',
                'integer',
            ],
            'models' => [
                'string',
                'required',
            ],
            'shareholders' => [
                'string',
                'required',
            ],
            'shareholder_id_number' => [
                'string',
                'required',
            ],
            'number_of_units' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'otr' => [
                'required',
            ],
            'debt_principal' => [
                'string',
                'required',
            ],
            'insurance_id' => [
                'required',
                'integer',
            ],
            'down_payment' => [
                'string',
                'required',
            ],
            'tenors_id' => [
                'required',
                'integer',
            ],
            'addm_addb' => [
                'string',
                'required',
            ],
            'effective_rates' => [
                'numeric',
                'required',
            ],
            'debtor_phone' => [
                'string',
                'required',
            ],
            'id_photos' => [
                'array',
                'required',
            ],
            'id_photos.*' => [
                'required',
            ],
            'kk_photos' => [
                'array',
                'required',
            ],
            'kk_photos.*' => [
                'required',
            ],
            'npwp_photos' => [
                'array',
                'required',
            ],
            'npwp_photos.*' => [
                'required',
            ],
            'other_photos' => [
                'array',
                'required',
            ],
            'other_photos.*' => [
                'required',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
