<?php
namespace Batch;

use Batch\Operation\FlushableInterface;
use Batch\Operation\OperationInterface;

class Pipe
{
    /**
     * @var array
     */
    private $operations = [];

    /**
     * @param OperationInterface|FlushableInterface $operation
     *
     * @return $this
     */
    public function pipe($operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * @param iterable $iterable
     */
    public function apply(iterable $iterable)
    {
        $queue = array_reverse(array_filter($this->operations, function($operation) {
            return $operation instanceof OperationInterface;
        }));

        foreach ($iterable as $element) {
            (new Apply($queue))($element);
        }

        (new Flush(array_reverse(array_filter($this->operations, function($operation) {
            return $operation instanceof FlushableInterface;
        }))))();
    }
}
