<?php

namespace PulseCheck\Checks;

use PulseCheck\Contracts\CheckInterface;
use PulseCheck\Result;

class PhpVersionCheck implements CheckInterface
{
    private string $recommended = '8.1';

    public function run(): Result
    {
        $current = PHP_VERSION;

        if (version_compare($current, $this->recommended, '>=')) {
            return new Result(
                id: 'pulsecheck_php_ok',
                status: 'good',
                label: 'PHP version is modern',
                description: "Your site is running PHP $current, which meets modern WordPress compatibility and security expectations.",
                confidence: 'High',
                impact: 'Stability, Security'
            );
        }

        return new Result(
            id: 'pulsecheck_php_outdated',
            status: 'critical',
            label: 'PHP version is outdated',
            description: "Your site is running PHP $current. Older PHP versions increase security risk and plugin incompatibility. Plan an upgrade using a staging environment.",
            confidence: 'High',
            impact: 'Security, Stability'
        );
    }
}
