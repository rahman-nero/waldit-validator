<?php


namespace Waldit\Validator\Exception;


class NotExistsValidatorMethodException extends \Exception
{
    private string $methodName;
    /**
     * NotExistsValidatorMethodException constructor.
     */
    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}