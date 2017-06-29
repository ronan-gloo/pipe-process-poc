<?php require 'vendor/autoload.php';

$iteratorCount = 15555;

// Creates validators
$filter = new Zend\InputFilter\InputFilter();
$filter->add([
    'name'       => 'id',
    'validators' => [
        [
            'name'    => 'GreaterThan',
            'options' => [
                'min' => 5
            ]
        ],
        [
            'name'    => 'LessThan',
            'options' => [
                'max' => $iteratorCount - 5,
            ]
        ]
    ]
]);

// Define error level for reporter according validators property and validator name
$report = new \Batch\InputFilter\Reporter([
    'id' => [
        'notGreaterThan' => \Batch\InputFilter\Reporter::NOTICE,
        'notLessThan'    => \Batch\InputFilter\Reporter::WARNING
    ]
]);

// display elements count on collect
$collector = function(array $elements) use(&$batchCount) {
    echo sprintf('Batch %d count %d%s', ++$batchCount, count($elements), PHP_EOL);
};

// Created an array object to be passed to validator
$transform = function($element) {
    return ['id' => $element];
};

// Final handler
$final = function() {
    echo 'Pipe executed successfully' . PHP_EOL;
};

// Creates pipe
$pipe = new \Batch\Pipe();

// transform scalar to array
$pipe->pipe(new \Batch\Operation\Transform($transform));

// validate data with input filter adapter : it breaks the chain on error
$pipe->pipe(new \Batch\InputFilter\FilterOperation($filter, $report));

// Batch collect every 10000 elements
$pipe->pipe(new \Batch\Operation\Collect(1000, $collector));

// Add final handler
$pipe->pipe(new \Batch\Operation\FinalOperation($final));

// Run the pipe with iterator
$pipe->apply((function($limit) {
    foreach (range(1, $limit) as $id) {
        yield (string) $id;
    }
})($iteratorCount));