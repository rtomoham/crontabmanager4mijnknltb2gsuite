<?php

require_once('Utils.php');
require_once('CrontabManager.php');
require_once('CronEntry.php');
require_once('Settings.php);

$manager = new CrontabManager();
$settings = Settings::getInstance();

if ($argc > 1) {
  echo("ARGUMENT provided: running settings->init($argv[1]).\n\n");
  $settings->init($argv[1]);
}

$cron = $settings->getCron();

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
$job->doJob('php ' . $settings->getProgramPath() . 'refresh.php > ' . $settings->getDataPath() . 'output.txt');
$manager->add($job);
$manager->save(False);

?>
