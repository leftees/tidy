<?php

namespace Tidy\Http\Requests;

use Tidy\Series;

class SeriesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $series = $this->route('series');
        $seriesId = $series instanceof Series ? $series->id : $series;

        if (!$seriesId) {
            return true; // Creates will pass
        }

        return Series::where('id', $seriesId)->whereIn('account_id', $this->getUserAccountIds());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'max:500',
            'for_dvd'     => 'boolean',
            'for_bluray'  => 'boolean',
            'for_book'    => 'boolean',
            'account_id'  => 'required|integer'
            // @TODO make sure the account id is limited to the accounts the user belongs to
        ];
    }
}
