<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CongregationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'required',
            'congregation' => 'required',
            'congregation_number' => 'required|unique:congregations,id',
            'contact_firstname' => 'required',
            'contact_lastname' => 'required',
            'contact_email' => 'required|email',
            'public' => 'required|boolean',
            'send_service_group_reports' => 'required|boolean',
            'send_publisher_reports' => 'required|boolean',
        ];
    }
}
