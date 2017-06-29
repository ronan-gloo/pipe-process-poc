<?php
namespace Batch\InputFilter;

class Report
{
    private $object;
    private $property;
    private $messages;
    private $value;

    public function __construct(string $object, string $property, $value, array $messages)
    {
        $this->object   = $object;
        $this->property = $property;
        $this->messages = $messages;
        $this->value    = $value;
    }

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
