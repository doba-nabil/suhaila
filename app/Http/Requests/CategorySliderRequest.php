<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorySliderRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch($this->method())
        {
            case 'POST':
                {
                    $rules = [
                        'title_ar' => 'required|max:100|min:1|string',
                        'title_en' => 'required|max:100|min:1|string',
                        'subtitle_ar' => 'required|max:100|min:1|string',
                        'subtitle_en' => 'required|max:100|min:1|string',
                        'image' => 'required|mimes:jpg,jpeg,png,svg|max:5000',
                    ];
                }
                break;
            case 'PATCH':
                {
                    $rules = [
                        'title_ar' => 'required|max:100|min:1|string',
                        'title_en' => 'required|max:100|min:1|string',
                        'subtitle_ar' => 'required|max:100|min:1|string',
                        'subtitle_en' => 'required|max:100|min:1|string',
                        'image' => 'mimes:jpg,jpeg,png,svg|max:5000',
                    ];
                }
                break;
            default:
                break;
        }
        return $rules;
    }
}
