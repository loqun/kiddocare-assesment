<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
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

        return [];

        // dd(request()->all(),$this->childName);
        $now = Carbon::now();
        $minDate = now(request()->timezone)->copy()->addHours(6)->format('Y-m-d\TH:i');
        $maxDate = now(request()->timezone)->copy()->addDays(30)->format('Y-m-d\TH:i');

        // dd($maxDate);

        return [
            'reservation_date' => [
                'required',
                'date_format:Y-m-d\TH:i',
                'after_or_equal:' . $minDate,
                'before_or_equal:' . $maxDate,
            ],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zipCode' => 'required|string|max:20',
            'childName' => 'required|array|min:1|max:4',
            'childName.*' => 'required|string|max:100',
            'childAge' => 'required|array|size:' . count($this->childName ?: []),
            'childAge.*' => 'required|integer|min:0|max:12',
            'childMonth' => 'required|array|size:' . count($this->childName ?: []),
            'childMonth.*' => [
                'required',
                'integer',
                'min:0',
                'max:11',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $age = $this->childAge[$index] ?? null;
                    
                    // Check if child is at least 1 month old
                    if ($age == 0 && $value < 1) {
                        $fail('Child must be at least 1 month old.');
                    }
                    
                    // Check if child is at most 12 years old
                    if (($age == 12 && $value > 11) || $age>13) {
                        $fail('Child must be at most 12 years old 11 month.');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reservation_date.after_or_equal' => 'Reservation must be at least 6 hours from now.',
            'reservation_date.before_or_equal' => 'Reservation must be within 30 days from today.',
            'childName.max' => 'Maximum 4 children are allowed.',
            'childName.min' => 'At least one child must be added.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If needed, transform input before validation
    }
}