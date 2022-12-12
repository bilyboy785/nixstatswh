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
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);

  require "functions/functions.php";

if (isset($_POST)) {

    $input_data = json_decode(file_get_contents('php://input'), true);
    $array_data = json_encode($input_data);

    // Check if there is a POST Playload request to start the Webhook
    if (!empty($array_data)) {
        $telegrambot=getenv('TELEGRAM_BOT_TOKEN');
        $telegramchatid=getenv('TELEGRAM_CHATID');

        // Pass the Json file
        $data = json_decode($array_data, true);

        // print_r($data);

        // Check Type of Alert
        if (empty($data['domain_id'])) {
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
            $serverStartTimeAlert = date('d-m-Y H:i:s', $serverStartTime);
            $serverEndTimeAlert = date('d-m-Y H:i:s', $data['time']);
            // Send the notification
            $notification = server_notification_text($serverStatus, $serverName, $serverMetric, $serverValue, $serverSubject, $serverThreshold, $serverStartTimeAlert, $serverEndTimeAlert, $serverId, $serverDevice);
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
            $notification = domain_notification_text($domainName, $domainStatus, $domainSubject, $domainStartTime, $domainEndTime, $domainId, $domainDateDiff);
            telegram_notify($notification);
        }
    }
}