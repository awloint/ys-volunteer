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
$smstoken = 'CQxlc2gLTWCUUdsunjsTrqb19FP8QcZ0BD3HybQWATlOg4t9QQ1aP40I73sL';
// Email Configuration
$emailHost = 'mail.awlo.org';
$emailUsername = 'anita@awlo.org';
$emailPassword = '//defaultp//';
$SMTPDebug = 0;
$SMTPAuth = true;
$SMTPSecure = 'ssl';
$Port = 465;
// API credentials from https://login.sendpulse.com/settngs/#api
$apiUserId = 'f8ae10fb413129f719ee777ad865d098';
$apiSecret = '7558e174e5bb77887c40803ee4c2e099';
define('PATH_TO_ATTACH_FILE', __FILE__);
