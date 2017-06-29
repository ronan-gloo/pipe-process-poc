<?php
namespace Batch\InputFilter;

class Reporter
{
    public const ERROR   = 3;
    public const WARNING = 2;
    public const NOTICE  = 1;
    public const UNKNOWN = 0;

    private const ERROR_MSG = [
        self::ERROR   => 'ERROR',
        self::WARNING => 'WARNING',
        self::NOTICE  => 'NOTICE',
        self::UNKNOWN => 'UNKNOWN',
    ];

    public function __construct(array $levelMap)
    {
        $this->levelMap = $levelMap;
    }

    public function report(Report $report)
    {
        $map = $this->levelMap[$report->getProperty()] ?? [];
        foreach ($report->getMessages() as $errorType => $message) {
            $level = $map[$errorType] ?? self::UNKNOWN;
            $this->export($level, $errorType, $message, $report);
        }
    }

    private function export(int $level, string $type, string $message, Report $report)
    {
        echo sprintf(
            "%s %s.%s[%s] %s - %s\n",
            self::ERROR_MSG[$level],
            $report->getObject(),
            $report->getProperty(),
            $report->getValue(),
            $type,
            $message
        );
    }
}
