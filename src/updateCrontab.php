<?php

include_once("Utils.php");
include_once("CrontabManager.php");
include_once("CronEntry.php");

$manager = new CrontabManager();

$settings = getSettings();
$cron = $settings[STRING_CRON];

$timecode = '';
foreach ($cron as $key=>$item) {
  if (0 >= strlen($item)) {
    $cron[$key] = '*';
  }
  $timecode .= $cron[$key] . ' ';
}
$timecode = substr($timecode, 0, -1);
                
		$onMinute = $cron[STRING_ON_MINUTE]; 
		$onHour = $cron[STRING_ON_HOUR];
		$onDayOfMonth = $cron[STRING_ON_DAY_OF_MONTH];
		$onMonth = $cron[STRING_ON_MONTH];
		$onDayOfWeek = $cron[STRING_ON_DAY_OF_WEEK];

$job = $manager->newJob();
$job->on($timecode);
$job->doJob('php /etc/somtoday2gsuite/refresh.php');
$manager->add($job);
$manager->save(False);

?>
