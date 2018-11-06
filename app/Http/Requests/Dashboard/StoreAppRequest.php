<?php

namespace InitSoftBot\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppRequest extends FormRequest
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
            'name' => [
                'required',
                'min:6',
                'max:80',
                function ($attribute, $value, $fail) {
                    if (\DB::table('apps')->whereRaw('LOWER(`name`) = LOWER(?)', $value)->count() > 0) {
                        $fail("El valor del campo {$attribute} ya está en uso.");
                    }
                },
            ]
        ];
    }

    public function createApp()
    {
        return auth()->user()->apps()->create([
            'name' => $this->name
        ]);
    }
}
