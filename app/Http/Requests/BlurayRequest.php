<?php

namespace Tidy\Http\Requests;

use Tidy\Bluray;
use Tidy\Http\Requests\Request;

class BlurayRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $bluray = $this->route('bluray');
        $blurayId = $bluray instanceof Bluray ? $bluray->id : $bluray;

        dd($this->user());

        return Bluray::where('id', $blurayId)->where('account_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:500',
            'description' => 'max:4000'
        ];
    }
}
