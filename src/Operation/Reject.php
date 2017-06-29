<?php
namespace Batch\Operation;

class Reject implements OperationInterface
{
    /**
     * @var callable
     */
    private $filter;

    /**
     * @param callable $filter
     */
    public function __construct(callable $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @inheritdoc
     */
    public function apply($element, callable $next)
    {
        if (false === call_user_func($this->filter, $element)) {
            $next($element);
        }
    }
}
