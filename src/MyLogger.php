<?php

namespace Ns3777k\DoctrineDbalYoutube;

use Psr\Log\NullLogger;

class MyLogger extends NullLogger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        echo sprintf("%s: %s, %s\r\n", $level, $message, json_encode($context));
    }
}
