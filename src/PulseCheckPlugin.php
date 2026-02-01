<?php

namespace PulseCheck;

require_once __DIR__ . '/Result.php';
require_once __DIR__ . '/Contracts/CheckInterface.php';
require_once __DIR__ . '/Checks/PhpVersionCheck.php';
require_once __DIR__ . '/Checks/CoreVersionCheck.php';
require_once __DIR__ . '/Checks/CronHealthCheck.php';

use PulseCheck\Checks\PhpVersionCheck,
    PulseCheck\Checks\CoreVersionCheck;

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

        $tests['direct']['pulsecheck_wp_core_version'] = [
            'label' => 'WordPress Core Version Health',
            'test'  => [self::class, 'runWpCoreVersionCheck'],
        ];

        $tests['direct']['pulsecheck_cron_health'] = [
            'label' => 'Cron Health / Missed Schedules',
            'test'  => [ self::class, 'runCronHealthCheck' ],
        ];
        
        return $tests;
    }

    public static function runPhpVersionCheck(): array
    {
        $check  = new PhpVersionCheck();
        $result = $check->run();

        return $result->toSiteHealthFormat();
    }

    public static function runWpCoreVersionCheck(): array
    {
        $check  = new CoreVersionCheck();
        $result = $check->run();

        return $result->toSiteHealthFormat();
    }

    public static function runCronHealthCheck(): array
    {
        $check  = new \PulseCheck\Checks\CronHealthCheck();
        $result = $check->run();
        return $result->toSiteHealthFormat();
    }

}
