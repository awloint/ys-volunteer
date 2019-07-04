<?php
/**
 * This script handles registration and payment
 *
 * PHP version 7.2
 *
 * @category Form_Processor
 * @package  Form_Processor
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Require Classes
require '../config.php';
require './DB.php';
require './Notify.php';
require './Newsletter.php';

$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$linkedinHandle = $_POST['linkedinHandle'];
$twitterHandle = $_POST['twitterHandle'];
$instagramHandle = $_POST['instagramHandle'];
$facebookHandle = $_POST['facebookHandle'];
$familiarHandles = $_POST['familiarHandles'];
$reasonForVolunteering = $_POST['reasonForVolunteering'];

$name = $firstName . " " . $lastName;
require './emails.php';
$details = array(
    "firstName" => $_POST['firstName'],
    "middleName" => $_POST['middleName'],
    "lastName" => $_POST['lastName'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone'],
    "location" => $_POST['location'],
    "linkedinHandle" => $_POST['linkedinHandle'],
    "twitterHandle" => $_POST['twitterHandle'],
    "instagramHandle" => $_POST['instagramHandle'],
    "facebookHandle" => $_POST['facebookHandle'],
    "familiarHandles" => $_POST['familiarHandles'],
    "reasonForVolunteering" => $_POST['reasonForVolunteering'],
);
$emails = array(
    array(
            "email"         =>  $email,
            "variables"     =>  array(
            "phone"         =>  $phone,
            "name"          =>  $firstName,
            "middleName"    =>  $middleName,
            "lastName"      =>  $lastName,
            "familiarHandles"        =>  $familiarHandles,
            "reasonForVolunteering" => $reasonForVolunteering,
            )
    )
);
$db = new DB($host, $db, $username, $password);

$notify = new Notify($smstoken, $emailHost, $emailUsername, $emailPassword, $SMTPDebug, $SMTPAuth, $SMTPSecure, $Port);
$newsletter = new Newsletter($apiUserId, $apiSecret);

// Check if the person has signed up to volunteer before
if($db->userExists($email, "awlcrwanda_volunteers")) {
    echo json_encode("user_exists");
}
// Put the User into the Database
if ($db->insertUser("awlcrwanda_volunteers", $details)) {
    $notify->viaEmail("volunteer@awlo.org", "Volunter at African Women in Leadership Organisation", $email, $name, $emailBodyVolunteer, "Thanks for Signing Up to Be Our Media Volunteer");
    $notify->viaEmail("volunteer@awlo.org", "Volunteer at African Women in Leadership Organisation", "volunteer@awlo.org", "Admin", $emailBodyOrganisation, "New Social Media Volunteer SignUp");
    $notify->viaSMS("AWLOInt", "Dear {$firstName} {$lastName}, Thank you for volunteering and sharing your good heart with us. Kindly check your email for the next steps. Cheers!", $phone);
    $notify->viaSMS("AWLOInt", "A Social Media Volunteer just signedup for the AWLCRwanda2019. Kindly check your email for the details.", "08037594969,08022473972");
    $newsletter->insertIntoList("2309698", $emails);
    echo json_encode("success");
}