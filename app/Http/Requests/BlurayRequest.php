<?php

namespace Tidy\Http\Requests;

use Tidy\Bluray;

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

        if (!$blurayId) {
            return true; // Creates will pass
        }

        $user = $this->user();
        $accountIds = $user->getAccountIds();

        return Bluray::where('id', $blurayId)->whereIn('account_id', $accountIds);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|max:500',
            'description' => 'max:4000',
        ];
    }
}
