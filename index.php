<?php
/**
 * Recipe class file
 *
 * PHP Version 7.1
 *
 * @category Recipe
 * @package  Recipe
 * @author   Martin Bouillaud <bouillaud.martin@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.bouillaudmartin.fr
 */
  // Displaying errors
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  // Include the functions file
  require "functions/functions.php";

$ini = parse_ini_file("../.nixstats.ini");
$telebottoken=getenv(YOUR_TELEGRAM_BOT_TOKEN);
$telegrambot=$ini["tgtoken"];
dump($telebottoken);
dump($telegrambot);
die;
// Check if there is a POST Playload request to start the Webhook
if (isset($_POST['payload'])) {
    // Initialize variables
    $ini = parse_ini_file("nixstats.ini");
    $telegrambot=$ini["tgtoken"];
    $telegramchatid=$ini["tgchatid"];
    $bitlyLogin=$ini["bitlylogin"];
    $bitlyApiKey=$ini["bitlyapikey"];

    // Pass the Json file
    $data = json_decode($_POST['payload'], true);

    // Check Type of Alert
    if ($data['domain_id']==null) {
        // Parameters
        $serverId = $data['server_id'];
        $serverNotificationId = $data['notification_id'];
        $serverAlertId = $data['alert_id'];
        $serverName = $data['server_name'];
        $serverMetric = $data['metric'];
        $serverStatus = strtoupper($data['status']);
        $serverValue = $data['value'];
        $serverSubject = $data['subject'];
        $serverThreshold = $data['threshold'];
        $serverDevice = $data['device'];
        $serverStartTime = $data['start_time'];
        $serverStartTimeAlert = date('d-m-Y H:i:s', $serverStartTime+($timezone*3600));
        $serverEndTimeAlert = date('d-m-Y H:i:s', $data['time']+($timezone*3600));
        //$serverDateDiff = diff_date($serverEndTimeAlert,$ServerStartTimeAlert);
        // Send the notification
        $notification = server_notification_text($serverStatus, $serverName, $serverMetric, $serverValue, $serverSubject, $serverThreshold, $serverStartTimeAlert, $serverEndTimeAlert, $serverId, $bitlyLogin, $bitlyApiKey, $serverDevice);
        telegram_notify($notification);
    } else {
        // Monitor parameters
        $domainId = $data['domain_id'];
        $domainName = $data['name'];
        $domainStatus = strtoupper($data['status']);
        $domainSubject = str_replace('Monitor', 'Le domaine', $data['subject']);
        $domainSubject = str_replace('is down!', 'est injoignable !', $domainSubject);
        $domainSubject = str_replace('is back online', 'est de nouveau en ligne', $domainSubject);
        $domainStartTime = date('d-m-Y H:i:s', $data['start_time']+($timezone*3600));
        $domainEndTime = date('d-m-Y H:i:s', $data['end_time']+($timezone*3600));
        $domainDateDiff = diff_date($domainEndTime, $domainStartTime);
        // Send the notification
        $notification = domain_notification_text($domainName, $domainStatus, $domainSubject, $domainStartTime, $domainEndTime, $domainId, $bitlyLogin, $bitlyApiKey, $domainDateDiff);
        telegram_notify($notification);
    }
}
