<?php
namespace Batch;

class Flush
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

    public function __invoke()
    {
        if ($current = array_pop($this->queue)) {
            $current->flush($this);
        }
    }
}
