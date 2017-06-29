<?php
namespace Batch\Operation;

class FinalOperation implements FlushableInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function flush(callable $next)
    {
        return $next(call_user_func($this->callback));
    }
}
