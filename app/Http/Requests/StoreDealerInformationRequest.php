<?php

namespace App\Http\Requests;

use App\Models\DealerInformation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDealerInformationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dealer_information_create');
    }

    public function rules()
    {
        return [
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
                'nullable',
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
            'remarks' => [
                'string',
                'nullable',
            ],
            'debtor_information_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
