<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class ListAllOrderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'departureDate' => 'nullable|date',
            'arrivalDate' => 'nullable|date|required_with:departureDate',
            'destination' => 'nullable|string',
            'status' => 'nullable|in:approved,requested,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'departureDate.date' => 'Departure date must be a valid date in the format dd-mm-yyyy.',
            'arrivalDate.date' => 'Arrival date must be a valid date in the format dd-mm-yyyy.',
            'arrivalDate.required_with' => 'Arrival date is required when departure date is provided.',
            'destination.string' => 'Destination must be a string.',
            'status.in' => 'Status must be one of the following values: (approved, requested, cancelled).',
        ];
    }
}
