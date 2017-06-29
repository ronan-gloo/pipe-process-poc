<?php

namespace Batch\Operation;

interface FlushableInterface
{
    public function flush(callable $next);
}
