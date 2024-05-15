<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightSearchRequest extends FormRequest
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
            'departure_airport' => ['nullable', 'string', 'size:3'],
            'arrival_airport' => ['nullable', 'string', 'size:3'],
            'airline_code' => ['nullable', 'string', 'size:2'],
            'departure_date' => ['nullable', 'date'],
            'arrival_date' => ['nullable', 'date']
        ];
    }
}
