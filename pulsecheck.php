<?php
/**
 * Plugin Name: PulseCheck
 * Description: High-signal diagnostic checks for WordPress developers.
 * Version: 0.1.0
 * Author: dani-j-d 
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/src/PulseCheckPlugin.php';

PulseCheck\PulseCheckPlugin::init();
