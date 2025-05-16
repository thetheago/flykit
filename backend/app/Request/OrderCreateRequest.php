<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'orderId' => 'required|numeric',
            'requesterName' => 'required|string',
            'destination' => 'required|string',
            'departureDate' => 'required|date',
            'arrivalDate' => 'required|date',
            'status' => 'required|in:approved,requested,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'orderId.required' => 'O campo orderId é obrigatório.',
            'orderId.numeric' => 'O campo orderId deve ser um número.',
            'requesterName.required' => 'O campo requesterName é obrigatório.',
            'requesterName.string' => 'O campo requesterName deve ser uma string.',
            'destination.required' => 'O campo destination é obrigatório.',
            'destination.string' => 'O campo destination deve ser uma string.',
            'departureDate.required' => 'O campo departureDate é obrigatório.',
            'departureDate.date' => 'O campo departureDate deve ser uma data válida no formato dd-mm-yyyy.',
            'arrivalDate.required' => 'O campo arrivalDate é obrigatório.',
            'arrivalDate.date' => 'O campo arrivalDate deve ser uma data válida no formato dd-mm-yyyy.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O campo status deve ser um dos valores permitidos: (approved, requested, cancelled).',
        ];
    }
}
