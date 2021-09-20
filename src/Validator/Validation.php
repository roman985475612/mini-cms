<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

use Home\CmsMini\Validator\ValidatorInterface;

class Validation
{
    public array $sourceData = [];

    public array $cleanedData = [];

    public array $errors = [];

    public bool $hasErrors = false;

    private array $constraint = [];

    public function __construct(array $sourceData)
    {
        $this->sourceData = $sourceData;
    }

    public function rule(string $key, ValidatorInterface $validator)
    {
        if (!isset($this->constraint[$key])) {
            $this->constraint[$key] = [];
        }
        
        $this->constraint[$key][] = $validator;
        
        return $this;
    }

    public function validate(): bool
    {
        foreach ($this->constraint as $key => $validators) {
            foreach ($validators as $validator) {
                if ($validator->validate($this->sourceData[$key])) {
                    $this->cleanedData[$key] = $this->sourceData[$key];
                } else {
                    $this->hasErrors = true;
                    $this->errors[$key] = $validator->errorMessage();
                }    
            }
        }
 
        return $this->isValid();
    }

    public function isValid(): bool
    {
        return !$this->hasErrors;
    }

    public function getCleanedDate(string $key): mixed
    {
        return $this->cleanedData[$key];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}