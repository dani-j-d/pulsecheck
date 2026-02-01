<?php

namespace PulseCheck\Checks;

use PulseCheck\Result;

class CronHealthCheck
{
    public function run(): Result
    {
        if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
            return new Result(
                id: 'pulsecheck_cron_disabled',
                status: 'recommended',
                label: 'WP-Cron is disabled',
                description: 'WP-Cron is disabled. Configure a system cron job to trigger wp-cron.php.',
                confidence: 'Medium',
                impact: 'Performance'
            );
        }

        $crons = _get_cron_array();

        if ( empty( $crons ) ) {
            return new Result(
                id: 'pulsecheck_cron_none',
                status: 'critical',
                label: 'No scheduled cron events',
                description: 'No cron events found. If this persists, scheduled processes may not run.',
                confidence: 'High',
                impact: 'Stability'
            );
        }

        $now = time();
        $overdue_found = false;

        foreach ( $crons as $timestamp => $hooks ) {
            if ( $timestamp < ( $now - HOUR_IN_SECONDS ) ) {
                $overdue_found = true;
                break;
            }
        }

        if ( $overdue_found ) {
            return new Result(
                id: 'pulsecheck_cron_overdue',
                status: 'recommended',
                label: 'Overdue cron events detected',
                description: 'Some scheduled events appear overdue by more than one hour.',
                confidence: 'Medium',
                impact: 'Performance'
            );
        }

        return new Result(
            id: 'pulsecheck_cron_ok',
            status: 'good',
            label: 'WP-Cron is functioning normally',
            description: 'Cron scheduled events are running within expected timeframes.',
            confidence: 'High',
            impact: 'Performance'
        );
    }
}
