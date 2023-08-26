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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'in_stock' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
            'subcat_id' => 'required|exists:sub_categories,id',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
    // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    public function all($keys = null)
    {
        $data = parent::all($keys);

        if (!isset($data['in_stock'])) {
            $data['in_stock'] = true;
        }

        return $data;
    }
}
