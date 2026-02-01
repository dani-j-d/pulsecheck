<?php

namespace PulseCheck\Checks;

use PulseCheck\Contracts\CheckInterface;
use PulseCheck\Result;

class CoreVersionCheck implements CheckInterface
{
    public function run(): Result
    {
        // Load core update info
        require_once ABSPATH . 'wp-admin/includes/update.php';

        $current_version = get_bloginfo('version');
        $updates         = get_core_updates();

        // If we can't determine updates
        if (empty($updates) || !isset($updates[0]->current)) {
            return new Result(
                id: 'pulsecheck_wp_core_unknown',
                status: 'recommended',
                label: 'WordPress core version status unclear',
                description: 'Unable to determine the latest WordPress version at this time.',
                confidence: 'Medium',
                impact: 'Platform currency'
            );
        }

        $latest_version = $updates[0]->current;

        if (version_compare($current_version, $latest_version, '>=')) {
            return new Result(
                id: 'pulsecheck_wp_core_up_to_date',
                status: 'good',
                label: 'WordPress core is up to date',
                description: "Your site is running WordPress $current_version, the latest stable release.",
                confidence: 'High',
                impact: 'Platform currency'
            );
        }

        return new Result(
            id: 'pulsecheck_wp_core_update_available',
            status: 'recommended',
            label: 'WordPress core update available',
            description: "Your site is running WordPress $current_version. The latest stable version is $latest_version.",
            confidence: 'High',
            impact: 'Platform currency, Security'
        );
    }
}
