<?php

namespace Tests\Stubs;

use App\Traits\FailedValidation;
use Illuminate\Support\Facades\Validator;

class FakeClassTraitValidator
{
    use FailedValidation;

    public function validate(array $data): void
    {
        $validator = Validator::make($data, ['field' => 'required']);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }
    }
}
