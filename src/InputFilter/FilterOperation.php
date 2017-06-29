<?php
namespace Batch\InputFilter;

use Batch\Operation\OperationInterface;
use Zend\InputFilter\InputFilterInterface;

class FilterOperation implements OperationInterface
{
    /**
     * @var InputFilterInterface
     */
    private $filter;

    /**
     * @var Reporter
     */
    private $reporter;

    /**
     * @param InputFilterInterface $filter
     * @param Reporter             $reporter
     */
    public function __construct(InputFilterInterface $filter, Reporter $reporter)
    {
        $this->filter   = $filter;
        $this->reporter = $reporter;
    }

    /**
     * @inheritdoc
     */
    public function apply($element, callable $next)
    {
        $this->filter->setData($element);
        if ($this->filter->isValid()) {
            return $next($this->filter->getValues());
        }

        foreach ($this->filter->getMessages() as $property => $messages) {
            $report = new Report('Price', $property, $this->filter->getValue($property), $messages);
            $this->reporter->report($report);
        }
    }
}
