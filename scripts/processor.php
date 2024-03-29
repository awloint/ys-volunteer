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
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// echo json_encode($_POST);

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
$unit = $_POST['unit'];
$reasonForVolunteering = htmlspecialchars($_POST['reasonForVolunteering'], ENT_QUOTES);

$name = $firstName . " " . $lastName;
require './emails.php';
$details = array(
    "firstName" => $firstName,
    "middleName" => $middleName,
    "lastName" => $lastName,
    "email" => $email,
    "phone" => $phone,
    "location" => $location,
    "linkedinHandle" => $linkedinHandle,
    "twitterHandle" => $twitterHandle,
    "instagramHandle" => $instagramHandle,
    "facebookHandle" => $facebookHandle,
    "familiarHandles" => $familiarHandles,
    "unit"        => $unit,
    "reasonForVolunteering" => $reasonForVolunteering
);
$emails = array(
    array(
            "email"         =>  $email,
            "variables"     =>  array(
            "firstName"         =>  $firstName,
            "middleName"          =>  $middleName,
            "lastName"    =>  $lastName,
            "phone"      =>  $phone,
            "location"        =>  $familiarHandles,
            "linkedinHandle"          => $linkedinHandle,
            "twitterHandle" => $twitterHandle,
            "instagramHandle" => $instagramHandle,
            "facebookHandle" => $facebookHandle,
            "familiarHandles" => $familiarHandles,
            "unit"            => $unit
            )
    )
);
$db = new DB($host, $db, $username, $password);

$notify = new Notify($smstoken, $emailHost, $emailUsername, $emailPassword, $SMTPDebug, $SMTPAuth, $SMTPSecure, $Port);

$newsletter = new Newsletter($apiUserId, $apiSecret);

// First check to see if the user is in the Database
if ($db->userExists($email, "iysvolunteer")) {
    echo json_encode("user_exists");
} else {
    // Insert the user into the database
    $db->getConnection()->beginTransaction();
    $db->insertUser("iysvolunteer", $details);
        // Send SMS
        $notify->viaSMS("YouthSummit", "Dear {$firstName} {$lastName}, Thank you for volunteering and sharing your good heart with us. Kindly check your email for the next steps. Cheers!", $phone);

        /**
         * Add User to the SendPulse Mail List
         */
        $emails = array(
            array(
                'email'             => $email,
                'variables'         => array(
                    'name'          => $firstName,
                    'middleName'    => $middleName,
                    'lastName'      => $lastName,
                    'phone'         => $phone,
                    'location'       =>$location,
                    'linkedinHandle'          => $linkedinHandle,
                    'twitterHandle' =>$twitterHandle,
                    'instagramHandle' =>$instagramHandle,
                    'facebookHandle' =>$facebookHandle,
                    'familiarHandles' => $familiarHandles,
                    'unit'            => $unit,
                    'reasonForVolunteering' => $reasonForVolunteering
                )
            )
        );

        $newsletter->insertIntoList("228660", $emails);

        $name = $firstName . ' ' . $lastName;
        // Send Email
        require './emails.php';
        // Send Email
        $notify->viaEmail("youthsummit@awlo.org", "AWLO Youth Summit", $email, $name, $emailBodyVolunteer, "AWLO International Youth Summit");

        $db->getConnection()->commit();

        echo json_encode("success");
}