<?php

namespace App\Http\Requests\InvoiceController;

use Illuminate\Foundation\Http\FormRequest;

class EditStockRequest extends FormRequest
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
            'id' => ['required', 'exists:invoices,id'],
            'invNumber' => ['required'],
            'invProductName' => ['required'],
            'invQuantity' => ['required'],
            'invPrice' => ['required'],
            'invPlace' => ['required'],
            'invDate' => ['required'],
            'search' => ['sometimes']
        ];
    }
}
