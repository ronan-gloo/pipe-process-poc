<?php
namespace Batch\Operation;

class Collect implements OperationInterface, FlushableInterface
{
    /**
     * @var callable
     */
    private $collector;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var array
     */
    private $elements = [];

    /**
     * @var integer
     */
    private $counter;

    /**
     * @param int      $amount
     * @param callable $collector
     */
    public function __construct(int $amount, callable $collector)
    {
        $this->collector = $collector;
        $this->amount    = $amount;
    }

    /**
     * @inheritdoc
     */
    public function apply($element, callable $next)
    {
        $this->elements[] = $element;
        $this->counter   += 1;

        if (0 === ($this->counter % $this->amount)) {
            $this->collect($next);
        }
    }

    /**
     * @inheritdoc
     */
    public function flush(callable $next)
    {
        if ($this->counter > 0) {
            $this->collect($next);
        }
    }

    private function collect(callable $next)
    {
        $elements       = $this->elements;
        $this->elements = [];
        $this->counter  = 0;

        call_user_func($this->collector, $elements);
        $next($elements);
    }
}
