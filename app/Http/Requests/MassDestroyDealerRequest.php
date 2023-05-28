<?php

namespace App\Http\Requests;

use App\Models\Dealer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDealerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dealer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dealers,id',
        ];
    }
}
