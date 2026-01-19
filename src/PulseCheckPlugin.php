<?php

namespace PulseCheck;

require_once __DIR__ . '/Result.php';
require_once __DIR__ . '/Contracts/CheckInterface.php';
require_once __DIR__ . '/Checks/PhpVersionCheck.php';

use PulseCheck\Checks\PhpVersionCheck;

class PulseCheckPlugin
{
    public static function init(): void
    {
        add_filter('site_status_tests', [self::class, 'registerSiteHealthChecks']);
    }

    public static function registerSiteHealthChecks(array $tests): array
    {
        $tests['direct']['pulsecheck_php_version'] = [
            'label' => 'PHP Version Health',
            'test'  => [self::class, 'runPhpVersionCheck'],
        ];

        return $tests;
    }

    public static function runPhpVersionCheck(): array
    {
        $check  = new PhpVersionCheck();
        $result = $check->run();

        return $result->toSiteHealthFormat();
    }
}
