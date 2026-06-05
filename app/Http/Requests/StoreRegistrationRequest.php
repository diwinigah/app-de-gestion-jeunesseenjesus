<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Services\RegistrationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return app(RegistrationService::class)->isRegistrationOpen();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $edition = app(RegistrationService::class)->getOpenEdition();

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'phone' => ['required', 'string', 'max:50'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:150'],
            'edition_section_id' => [
                'required',
                'integer',
                Rule::exists('edition_sections', 'id')
                    ->where('camp_edition_id', $edition?->getKey())
                    ->where('is_active', true),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Le prenom est obligatoire.',
            'first_name.max' => 'Le prenom ne peut pas depasser :max caracteres.',
            'last_name.required' => 'Le nom est obligatoire.',
            'last_name.max' => 'Le nom ne peut pas depasser :max caracteres.',
            'gender.required' => 'Le genre est obligatoire.',
            'gender' => 'Le genre selectionne est invalide.',
            'phone.required' => 'Le numero de telephone est obligatoire.',
            'phone.max' => 'Le numero de telephone ne peut pas depasser :max caracteres.',
            'whatsapp_phone.max' => 'Le numero WhatsApp ne peut pas depasser :max caracteres.',
            'city.max' => 'La ville ne peut pas depasser :max caracteres.',
            'edition_section_id.required' => 'La section est obligatoire.',
            'edition_section_id.exists' => 'La section selectionnee est indisponible.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'prenom',
            'last_name' => 'nom',
            'gender' => 'genre',
            'phone' => 'telephone',
            'whatsapp_phone' => 'WhatsApp',
            'city' => 'ville',
            'edition_section_id' => 'section',
        ];
    }
}
