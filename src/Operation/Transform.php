<?php
namespace Batch\Operation;

class Transform implements OperationInterface
{
    /**
     * @var callable
     */
    private $transformer;

    /**
     * @param callable $transformer
     */
    public function __construct(callable $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param          $element
     * @param callable $next
     *
     * @return mixed
     */
    public function apply($element, callable $next)
    {
        $next(
            call_user_func($this->transformer, $element)
        );
    }
}
