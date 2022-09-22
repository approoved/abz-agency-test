<?php

namespace App\Http\Requests;

final class RetrieveUserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'count' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
