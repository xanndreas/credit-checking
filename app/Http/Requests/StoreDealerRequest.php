<?php

namespace App\Http\Requests;

use App\Models\Dealer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDealerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dealer_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'aliases' => [
                'string',
                'nullable',
            ],
        ];
    }
}
