<?php

namespace App\Http\Requests;

use App\Models\DealerInformation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDealerInformationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dealer_information_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dealer_informations,id',
        ];
    }
}
