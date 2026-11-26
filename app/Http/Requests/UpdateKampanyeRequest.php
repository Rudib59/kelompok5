<?php

namespace App\Http\Requests;

class UpdateKampanyeRequest extends StoreKampanyeRequest
{
    // Mewarisi rule, message, attribute. 'sometimes' agar PUT sebagian field tetap valid.
    public function rules(): array
    {
        return collect(parent::rules())
            ->map(fn ($rule) => array_merge(['sometimes'], $rule))
            ->all();
    }
}
