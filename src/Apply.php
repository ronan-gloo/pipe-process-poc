<?php
namespace Batch;

class Apply
{
    /**
     * @var array
     */
    private $queue;

    /**
     * @param array $queue
     */
    public function __construct(array $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @param $element
     */
    public function __invoke($element)
    {
        if ($current = array_pop($this->queue)) {
            $current->apply($element, $this);
        }
    }
}
