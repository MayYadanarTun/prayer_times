<?php
include "../app/helper/App.php";
$app = new App();
$prayerazone = $_REQUEST['prayerazone'];
$prayerArray = [];
$data=[];
$currentDate = (new DateTime())->format("Y-m-d");
// print_r($currentDate);
$prayerTimes = $app->select_list("select prayertime from songs where prayerazone='$prayerazone' and prayertimedate='$currentDate'");
$days = ['IMASK','SUBUH','SYURUK','ZOHOR','ASAR','MAGHRIB','ISYAK'];

foreach ($prayerTimes as $prayerTime) {
    $prayerArray []= $prayerTime;
}

for ($i = 0; $i < count($prayerArray); $i++) {
  $data[$days[$i]] = $prayerArray[$i]["prayertime"];
}
// print_r($data);
echo json_encode($data);
