<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                        'name_ar' => 'required|max:100|min:1|string',
                        'name_en' => 'required|max:100|min:1|string',
                        'body_ar' => 'required',
                        'body_en' => 'required',
                        'category_id' => 'required',
                        'price' => 'required|numeric|min:0',
                        'discount_price' => 'nullable|numeric|min:0',
                        'image' => 'required|mimes:jpg,jpeg,png,svg|max:5000',
                        'images.*' => 'required|mimes:jpg,jpeg,png,svg|max:5000',
                        'video' => 'mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
                    ];
                }
                break;
            case 'PATCH':
                {
                    $rules = [
                        'name_ar' => 'required|max:100|min:1|string',
                        'name_en' => 'required|max:100|min:1|string',
                        'body_ar' => 'required',
                        'body_en' => 'required',
                        'category_id' => 'required',
                        'price' => 'required|numeric|min:0',
                        'discount_price' => 'nullable|numeric|min:0',
                        'image' => 'mimes:jpg,jpeg,png,svg|max:5000',
                        'images.*' => 'mimes:jpg,jpeg,png,svg|max:5000',
                        'video' => 'mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
                    ];
                }
                break;
            default:
                break;
        }
        return $rules;
    }
}
