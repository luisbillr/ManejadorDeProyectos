<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class ProyectoFormRequest extends FormRequest
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
        if(Auth::user()->roles[0]->name == 'admin')
        {
            return [
                //
                'nombre'=>'required|max:30',
                'descripcion'=>'required|max:250',
                'user_id' => 'required'
            ];

        }else
        {
            return [
                //
                'nombre'=>'required|max:30',
                'descripcion'=>'required|max:250'
            ];
        }

    }
}
