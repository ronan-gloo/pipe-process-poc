<?php
namespace Batch\Operation;

interface OperationInterface
{
    public function apply($element, callable $next);
}
