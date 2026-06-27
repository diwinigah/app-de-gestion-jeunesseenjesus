<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Mode gracieux : si les clés ne sont pas configurées, ne pas bloquer
        if (!config('services.recaptcha.secret_key')) {
            return;
        }

        // En dev ou si le JS n'a pas pu injecter le token, ne pas afficher d'erreur visible.
        if (empty($value)) {
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('services.recaptcha.secret_key'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
                $fail('La vérification de sécurité a échoué. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            // Mode gracieux : en cas d'erreur de vérification, ne pas bloquer
            \Log::error('reCAPTCHA verification error', ['error' => $e->getMessage()]);
        }
    }
}
