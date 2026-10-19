<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    /** A 10-digit US (NANP) number: area code and exchange can't start with 0 or 1. */
    private const US_PHONE = '/^[2-9]\d{2}[2-9]\d{6}$/';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reduce the phone to its digits so "(555) 234-5678", "555.234.5678" and
     * "+1 555 234 5678" all validate the same way.
     */
    protected function prepareForValidation(): void
    {
        if (! is_string($this->input('phone'))) {
            return;
        }

        $digits = preg_replace('/\D/', '', $this->input('phone'));

        if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
            $digits = substr($digits, 1);
        }

        $this->merge(['phone' => $digits]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:'.self::US_PHONE],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid 10-digit US phone number.',
        ];
    }

    /** Validated data with the phone stored in the standard US format, e.g. (555) 234-5678. */
    public function quoteData(): array
    {
        $data = $this->validated();
        $data['phone'] = preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $data['phone']);

        return $data;
    }
}
