<?php

namespace Kirago\BusinessCore\Modules;

use Illuminate\Validation\ValidationException;
use Throwable;

trait Validable {

    protected mixed $errors;

    public function validationRules(): array
    {
        return [];
    }

    public function validationMessages(): array
    {
        return [];
    }

    public function validationAttributes(): array
    {
        return [];
    }

    protected function validationSchema(): array
    {
        return [
            $this->validationRules(),
            $this->validationMessages(),
            $this->validationAttributes()
        ];
    }


    /**
     * Validate the model instance.
     *
     * @param array $data
     * @param bool $exception
     * @return bool
     * @throws Throwable
     */
    public function validate(array $data, bool $exception = false): bool
    {

        [$rules,$messages,$attributes] = $this->validationSchema();

        $validator = validator($data, $rules, $messages, $attributes);

        $failed = $validator->fails();

        if ($failed) {
            $this->errors = $validator->messages();
            throw_if($exception, new ValidationException($validator) );
            return false;
        }
        //return  $validator->validated();
        // validation pass
        return true;
    }

}
