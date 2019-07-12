<?php
/**
 * This is the Server configuration script
 *
 * PHP version 7.2
 *
 * @category Server_Configuration
 * @package  Server_Configuration
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
// Database Configuration
$host='localhost';
$db = 'AWLCRwanda2019';
$username = 'root';
$password = 'anitapc';
// SMS Configuration
$smstoken = 's2EpyQl989Jm8QdjKs0FbtIkpoOVKrPjZCfzsDnW5wBz0mKsewYTyRpr7JgV';
// Email Configuration
$emailHost = 'mail.awlo.org';
$emailUsername = 'anita@awlo.org';
$emailPassword = '//defaultp//';
$SMTPDebug = 0;
$SMTPAuth = true;
$SMTPSecure = 'ssl';
$Port = 465;
// API credentials from https://login.sendpulse.com/settngs/#api
$apiUserId = '2b111126c7e6bfe91321de7f47ff7ebe';
$apiSecret = '2f74e50fbf0bb8513f11cccfcadf8f0a';
define('PATH_TO_ATTACH_FILE', __FILE__);
