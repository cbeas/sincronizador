<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            return [];
            
        //if ($this->input('persona_fisica') )

        $rules= [             
             'nombre' => 'required|string|max:255',
             'paterno' => 'required|max:80',
             'materno' => 'required|max:80',
             'email' => 'max:100',
             'celular' => 'max:32',
             'estatus' => 'required|boolean',
             'flotilla' => 'required|boolean',
             'tarjeta' => 'required|string|min:13|max:13',
             'membresia' => 'required|integer',
             'ubicacion' => 'required|integer',
             'sexo' => 'required|string',             //M,F
        ];

        return array_merge($rules,$rulesPersonaFisica);

    }


    public function attributes()
    {
        return [
             'persona_fisica' => 'Persona Fisica ',
             'nombre' => 'Nombre',
             'paterno' => 'Apellido Paterno',
             'materno' => 'Apellido Materno',
             'rfc' => 'RFC',
             'email' => 'Email',
             'celular' => 'Celular',
             'estatus' => 'Estatus',
             'flotilla' => 'Flotilla',
             'tarjeta' => 'Tarjeta',
             'membresia' => 'Membresia',
             'ubicacion' => 'Ubicacion',
             'sexo' => 'Sexo',           
            
        ];
}

}
