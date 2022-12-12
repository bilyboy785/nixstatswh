<?php
// Function to send Telegram notification
function telegram_notify($msg){
	global $telegrambot,$telegramchatid;
	$url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage?chat_id='.$telegramchatid;
	$url = $url . "&disable_web_page_preview=true&parse_mode=markdown&text=" . urlencode($msg);
	$ch = curl_init();
    	$optArray = array(
        	CURLOPT_URL => $url,
        	CURLOPT_RETURNTRANSFER => true
    	);
    	curl_setopt_array($ch, $optArray);
    	$result = curl_exec($ch);
    	curl_close($ch);
}

//function telegram_notify($msg){
 //   global $telegrambot,$telegramchatid;
   // $url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage';$data=array('chat_id'=>$telegramchatid,'text'=>$msg);
    //$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
   // $context=stream_context_create($options);
   // $result=file_get_contents($url,false,$context);
   // return $result;
//}

// Function to convert a timestamp in readable date format
function timestamp_to_date($timestamp){
  $datetimeFormat = 'd-m-Y H:i:s';
  $date = new \DateTime();
  $date->setTimestamp($timestamp);
  $dateNotif = $date->format($datetimeFormat);
  return $dateNotif;
}

// Function to return date format from datediff
function diff_date($dateEnd,$dateStart){
	$date1 = new DateTime($dateEnd);
	$date2 = new DateTime($dateStart);
	$diff = $date2->diff($date1);
	$interval = $date1->diff($date2);
	$hours = $interval->format('%h');
	$minutes = $interval->format('%i');
	$seconds = $interval->format('%s');
	if($hours==0){
		$diffDate = $interval->format('%i')." minutes et ".$interval->format('%s')." secondes";
	}elseif($minutes==0){
		$diffDate = $interval->format('%s')." secondes";
	}else{
		$diffDate = $interval->format('%h')." heures ".$interval->format('%i')." minutes et ".$interval->format('%s')." secondes";
	}
	//$hours = $diff->h;
	//$hours = $hours + ($diff->days*24);
	return $diffDate;
}

// Function to check if status is "OPEN" or "CLOSE" to put an icon at the beggining of the alert
function check_status($status){
  if($status=="OPEN"){
    return true;
  }
}

// Function to check if alert comes from SERVER or MONITOR
function check_alert_type($domainName){
  if($domainName==""){
    return true;
  }
}

// Function to explode the subject for server Notifications
function explode_subject($serverSubject){
  $fullSubject = explode('-',$serverSubject);
  $explodedSubject = explode(' ',$fullSubject[1]);
  $detailSubject = $explodedSubject[2] . ' ' . $explodedSubject[3] . ' ' . $explodedSubject[4] . ' ' . $explodedSubject[5];
  return $detailSubject;
}

// Function to define the text for Server Notification
function server_notification_text($serverStatus,$serverName,$serverMetric,$serverValue,$serverSubject,$serverThreshold,$serverStartTimeAlert,$serverEndTimeAlert,$serverId,$serverDevice){
  $url = 'https://nixstats.com/server/' . $serverId . '/overview';
  $urlNixstats = 'https://nixstats.com/server/' . $serverId . '/overview';
  if($serverStatus=="OPEN"){
      if($serverThreshold=="updown"){
        $notification = '❌ #' . $serverStatus . ' - #' . $serverName . ' - Le service ' . $serverDevice . ' est *DOWN* (Début de panne : ' . $serverStartTimeAlert . ') - ' . $urlNixstats . '.';
      }else{
        $notification = '❌ #' . $serverStatus . ' - #' . $serverName . ' - ' . explode_subject($serverSubject) . ' - Seuil de : ' . $serverThreshold . '% dépassé : ' . $serverValue . '% - (Début de panne : ' . $serverStartTimeAlert . ') - ' . $urlNixstats . '.';
    }
  }else{
    if($serverThreshold=="updown"){
      $notification = '✔️ #' . $serverStatus . ' - #' . strtoupper($serverName) . ' - Le service ' . $serverDevice . ' est *UP* (Fin de la panne : ' . $serverEndTimeAlert . ' ) - ' . $urlNixstats . '.';
    }else{
      $notification = '✔️ #' . $serverStatus . ' - #' . strtoupper($serverName) . ' - ' . explode_subject($serverSubject) . ' - Retour à l\'état OK - (Fin de la panne : ' . $serverEndTimeAlert . ' ) - ' . $urlNixstats . '.';
    }
  }
  return $notification;
}

// Function to define the text for Domain Notification
function domain_notification_text($domainName,$domainStatus,$domainSubject,$domainStartTime,$domainEndTime,$domainId,$domainDateDiff){
  $urlNixstats = 'https://nixstats.com/domain/' . $domainId . '/overview';
  $detailAlert = str_replace("DOWN:", "", $domainSubject);
  $detailAlert = str_replace("UP:", "", $detailAlert);
  if($domainStatus=="OPEN"){
    $notification = '❌ #DOWN' . ' - ' . $domainName . ' - ' . $detailAlert . '  - (Injoignable depuis le ' . str_replace(' ',' à ',$domainStartTime) . ') - ' . $urlNixstats . '.';
  }else{
    $notification = '✔️ #UP'  . ' - ' . $domainName . ' - ' . $detailAlert . '  - (Résolu le : ' . str_replace(' ',' à ',$domainEndTime) . ' - ' . $domainDateDiff . ' de downtime ) - ' . $urlNixstats . '.';
  }
  return $notification;
}

// Fonction to send the telegram Notification
function send_telegram_notif($status,$domainName,$subject,$dateNotif,$notification,$urlNixstats){
  if(check_alert_type($domainName)==true){
    telegram_notify($notification);
  }else{
    telegram_notify($notification);
  }
}

/* returns a result form url */
function curl_get_result($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
