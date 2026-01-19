<?php
/**
 * Plugin Name: PulseCheck
 * Description: High-signal diagnostic checks for WordPress developers.
 * Version: 0.1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/src/PulseCheckPlugin.php';

PulseCheck\PulseCheckPlugin::init();
