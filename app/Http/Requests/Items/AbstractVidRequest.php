<?php

namespace Tidy\Http\Requests\Items;

use Tidy\Http\Requests\Request;

class AbstractVidRequest extends Request
{
    const ROUTE_KEY = 'unknown';
    const MODEL = 'unknown';
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = $this->route(static::ROUTE_KEY);
        $modelId = $model instanceof AbstractVid ? $model->id : $model;

        if (!$modelId) {
            return true; // Creates will pass
        }

        return forward_static_call([static::MODEL, 'where'], 'id', $modelId)->whereIn('account_id', $this->getUserAccountIds());
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
            'account_id'  => 'required|integer' // @TODO make sure the account id is limited to the accounts the user belongs to
        ];
    }
}
