<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class CreateUserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60'],
            'email' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'email',
            ],
            'phone' => ['required', 'string', 'regex:^[\+]{0,1}380([0-9]{9})$^'],
            'position_id' => [
                'required',
                'numeric',
                'min:1',
            ],
            'photo' => [
                'required',
                'mimes:jpg,jpeg',
                File::image()
                    ->max(5 * 1024)
                    ->dimensions(
                        Rule::dimensions()->minHeight(70)->minWidth(70)
                    ),
            ],
        ];
    }
}
