<?php

namespace InitSoftBot\Http\Requests\Dashboard;

use InitSoftBot\App;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppRequest extends FormRequest
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
                Rule::unique('apps', $this->name)->ignore($this->app->id)
            ]
        ];
    }

    public function updateApp(App $app)
    {
        $app->update([
            'name' => $this->name
        ]);

        return $app;
    }
}
