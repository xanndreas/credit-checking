<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateApprovalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('approval_edit');
    }

    public function rules()
    {
        return [
            'status' => [
                'required',
            ],
            'approval_user_id' => [
                'required',
                'integer',
            ],
            'dealer_information_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
