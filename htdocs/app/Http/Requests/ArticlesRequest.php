<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getValidatorInstance()
    {
        $oValidator = parent::getValidatorInstance();
        $oValidator->sometimes('a_group_id', 'exists:articles_categories,id', function($oInput) {
            return $oInput->a_group_id == 0 ? false : true;
        });
        return $oValidator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'a_name' => 'required|min:2|max:30',
            'a_text' => 'required|min:2|max:1000',
            'a_group_id' => 'required|integer'
        ];
    }
}
