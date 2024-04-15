<?php
include "../app/helper/App.php";
$app = new App();
$prayertime = $_REQUEST['prayertime'];
$currentDate = (new DateTime())->format("Y-m-d");
// print_r($currentDate);
$audio_url = $app->select_record("select song_title from songs where prayertime='$prayertime' and prayertimedate='$currentDate'");

echo json_encode($audio_url);
