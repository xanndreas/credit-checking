<?php

namespace App\Http\Requests;

use App\Models\Tenor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTenorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tenor_edit');
    }

    public function rules()
    {
        return [
            'year' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
