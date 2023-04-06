<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'team_name' => [
                'string',
                'required',
            ],
            'team_leader_id' => [
                'required',
                'integer',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
        ];
    }
}