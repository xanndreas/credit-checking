<?php

namespace App\Http\Requests;

use App\Models\Tenor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTenorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tenor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tenors,id',
        ];
    }
}
