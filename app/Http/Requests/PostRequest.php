<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'exists:post_categories,id'],
            'body' => ['required'],
            'thumbnail_img' => ['file', 'image', 'mimes:jpeg,png', 'max:2048'],
            'tags' => ['array', 'exists:post_tags,id']
        ];
    }

    /**
     * 記事に関するユーザー入力値を返却
     *
     * @return array
     */
    public function postAttr() {

        return $this->only([
            'title',
            'category_id',
            'body',
            'thumbnail_img'
        ]);
    }
}
