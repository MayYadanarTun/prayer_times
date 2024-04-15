<?php
include "../app/helper/App.php";
date_default_timezone_set('Asia/Yangon');
$app = new App();
$currentDate = (new DateTime())->format("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../app/libraries/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: black;
    }

    .circle {
      font-size: 75px;
    }

    h6 {
      margin: 0px 0px 10px 15px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="text-white">
      <?php
      echo (new DateTime())->format("d F Y") . "|";
      ?>
    </h1>

    <div class="text-center">
      <h4 class="text-white">Zohor</h4>
      <p class="text-warning">Next Prayer Time</p>
      <span id="nextPrayerTime"></span>
    </div>
    <div class="d-flex justify-content-around mt-2 circle">
      <div class="border border-5 rounded-circle border-warning ps-4 pe-4">
        <div id="hours">00</div>
        <h6 class="text-warning ms-3">Hours</h6>
      </div>
      <div class="border border-5 rounded-circle border-warning ps-4 pe-4">
        <div id="minutes">00</div>
        <h6 class="text-warning ms-3">Minutes</h6>
      </div>
      <div class="border border-5 rounded-circle border-warning ps-4 pe-4">
        <div id="seconds">00</div>
        <h6 class="text-warning ms-3">Seconds</h6>
      </div>
    </div>
    <p class="text-center text-warning mt-3">Until The Next Player Time In The Zone</p>
    <div class="text-center" id="audio">
    </div>
    <div id="selectedValue">
      <!-- SBH04 - song name -->
    </div>
    <div class="mt-3">
      <select id="mySelect" class="form-select">
        <option selected disabled>Change Zone...</option>
        <?php
        $previousPrayeraZone = "";
        $results = $app->select_list("select prayerazone,song_title,prayertimedate from songs where prayertimedate='$currentDate'");
        while ($row = $results->fetch_assoc()) {
          if ($row['prayerazone'] !== $previousPrayeraZone) {
            echo "<option value='{$row['prayerazone']}'> {$row['prayerazone']} - {$row['song_title']} </option>";
            $previousPrayeraZone = $row['prayerazone'];
          }
        }
        ?>

      </select>
    </div>
    <div class="mt-5">
      <span class="text-white">
        <?php
        $currentDateTime = new DateTime();
        echo $currentDateTime->format("d F Y") . "|";
        ?>
      </span>

      <div class="row text-warning mt-2" id="prayerTimes">
        <div class="col-md-3">
          <p class="text-uppercase">Imask</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Subuh</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Syuruk</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Zohor</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Asar</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Maghrib</p>
        </div>
        <div class="col-md-3">
          <p class="text-uppercase">Isyak</p>
        </div>

      </div>
    </div>
    <script src="../app/libraries/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      $(document).ready(() => {
        var hours = "",
          minutes = "",
          seconds = "",
          prayerTime = "",
          meridiem = "",
          storedData;
        var miniSecondsArr = [];

        $('#mySelect').val(value).change(() => {
          getPrayerTime();
          // console.log(prayerTime);

          setInterval(checkingTimer, 1000);
        });


        function PrepareNextPrayerTime(miniSecondsArr, data) {
          var miniSeconds = "",
            smallestIndex = "",
            nextPrayerTime = "",
            correspondingKey = "";

          miniSeconds = Math.max(...miniSecondsArr); //array ထဲကမှခြားနားမှုအနည်းဆုံး miniSeconds
          if (miniSecondsArr.length === 0) {
            prayerTime = "No upcoming prayer time found!";
          } else if (Object.keys(data).length === miniSecondsArr.length) {
            smallestIndex = miniSecondsArr.indexOf(miniSeconds);
            correspondingKey = Object.keys(data)[smallestIndex]; //IMASK
            prayerTime = document.getElementById(correspondingKey).textContent; //getting the next prayer tiem from ui
          } else {
            smallestIndex = miniSecondsArr.indexOf(miniSeconds);
            smallestIndex += (Object.keys(data).length - miniSecondsArr.length);
            correspondingKey = Object.keys(data)[smallestIndex]; //IMASK
            prayerTime = document.getElementById(correspondingKey).textContent; //getting the next prayer tiem from ui
          }

          nextPrayerTime = `<span class="text-white">${prayerTime}</span>`;
          $('#nextPrayerTime').empty().append(nextPrayerTime);
          miniSecondsArr.splice(miniSecondsArr.indexOf(miniSeconds), 1); //need to remove the miniSeconds form miniSecondsArr array cause to show the next prayer time
          return prayerTime;
        }

        function getPrayerTime() {
          var totalSeconds = "",
            currentTimeHours = "",
            currentTimeMinutes = "",
            currentTimeSeconds = "",
            prayerTimes = "",
            currentDateTime = "";
          miniSecondsArr = [];

          var selectZone = document.getElementById('mySelect');
          var selectedOption = selectZone.options[selectZone.selectedIndex];
          var selectedValue = selectedOption.value;
          document.getElementById("selectedValue").textContent = selectedOption.textContent;

          $.ajax({
            type: "get",
            dataType: "json",
            url: "./data-prepare-for-prayer-time.php?prayerazone=" + selectedValue,

            success: (data) => {
              storedData = data;
              $('#prayerTimes').html('');
              $('#audio').html('');
              $('#hours').html('00');
              $('#minutes').html('00');
              $('#seconds').html('00');

              currentDateTime = new Date().toLocaleString('en-US', {
                timeZone: 'Asia/Yangon',
                hour12: false
              });
              currentTimeHours = parseInt(currentDateTime.split(',')[1].split(":")[0]);
              currentTimeMinutes = parseInt(currentDateTime.split(',')[1].split(":")[1]);
              currentTimeSeconds = parseInt(currentDateTime.split(',')[1].split(":")[2]);

              for (let key in data) {
                hours = parseInt(data[key].split(":")[0]);
                minutes = parseInt(data[key].split(":")[1]);
                seconds = parseInt(data[key].split(":")[2]);
                if (hours > 12) {
                  data[key] = (hours - 12) + ":" + formatTimeWithLeadingZeros(minutes) + ":" + formatTimeWithLeadingZeros(seconds);
                }
                meridiem = checkMeridiem(hours, minutes, seconds);

                //showing for daily prayer times
                prayerTimes = `
                <div class="col-md-3 mb-3">
                  <p class="text-uppercase mb-0">${key}</p>
                  <span class="text-white" id=${key}>${data[key]} ${meridiem}</span>
                </div>`;
                $('#prayerTimes').append(prayerTimes);

                if ((hours > currentTimeHours) ||
                  (hours === currentTimeHours && minutes > currentTimeMinutes) ||
                  (hours === currentTimeHours && minutes === currentTimeMinutes && seconds > currentTimeSeconds)) {
                  totalSeconds = ((currentTimeHours - hours) * 3600) + ((currentTimeMinutes - minutes) * 60) + (currentTimeSeconds - seconds);
                  miniSecondsArr.push(totalSeconds);
                }
              }

              prayerTime = PrepareNextPrayerTime(miniSecondsArr, data);
              // console.log(prayerTime);
            },
            error: (error) => {
              console.log("Error" + error);
            }
          });
        }

        function playMP3(prayerTime) {
          var check_meridiem = prayerTime.split(" ")[1];
          var checkPrayerHours = parseInt(prayerTime.split(" ")[0].split(":")[0]);
          var checkPrayerMinutes = parseInt(prayerTime.split(" ")[0].split(":")[1]);
          var checkPrayerSeconds = parseInt(prayerTime.split(" ")[0].split(":")[2]);
          if (check_meridiem === "PM" && checkPrayerHours !== 12) {
            checkPrayerHours += 12;
          }
          var checkPrayerTime = `${checkPrayerHours}:${checkPrayerMinutes}:${checkPrayerSeconds}`;
          // console.log(checkPrayerTime, check_meri, prayerTime);

          $.ajax({
            type: 'get',
            dataType: 'json',
            url: './data-prepare-for-audio.php?prayertime=' + checkPrayerTime,
            success: (data) => {
              // Create a new audio element
              var audioElement = document.createElement('audio');
              audioElement.src = `../audios/${data.song_title}`;
              audioElement.controls = true;
              $('#audio').empty().append(audioElement);
              audioElement.play();
            },
            error: (error) => {
              console.log(error);
            }
          });
        }

        function formatTimeWithLeadingZeros(value) {
          return value < 10 ? '0' + value : value.toString();
        }

        function updateTimeDifference(timeDuration) {
          var timeFormat = [];
          var currentTime = new Date();
          var difference = timeDuration - currentTime;

          // Convert difference to hours, minutes, and seconds
          var hr = Math.floor(difference / (1000 * 60 * 60));
          var min = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
          var seds = Math.floor((difference % (1000 * 60)) / 1000);

          timeFormat.push(formatTimeWithLeadingZeros(Math.abs(hr)), formatTimeWithLeadingZeros(min), formatTimeWithLeadingZeros(seds));
          return timeFormat;
        }

        function checkMeridiem(hours, minutes, seconds) {
          if (hours < 12) {
            return "AM";
          } else if (hours == 12) {
            return "PM";
          } else {
            return "PM";
          }
        }

        function checkingTimer() {
          var prayerTimeFormat = "",
            hoursFormat = "",
            minutesFormat = "",
            secondsFormat = "",
            currentDate = "",
            timeDuration = "",
            requiredTimeToPlay;

          if (prayerTime !== "No upcoming prayer time found!") {
            //preparing requied prayer time form current time
            hoursFormat = prayerTime.split(" ")[0].split(":")[0];
            minutesFormat = prayerTime.split(" ")[0].split(":")[1];
            secondsFormat = prayerTime.split(" ")[0].split(":")[2];
            meridiem = prayerTime.split(" ")[1];
            if (meridiem === "PM" && parseInt(hoursFormat) !== 12) {
              hoursFormat = parseInt(hoursFormat) + 12;
            }
            prayerTimeFormat = `${hoursFormat}:${minutesFormat}:${secondsFormat}`;
            currentDate = new Date();
            [hours, minutes, seconds] = prayerTimeFormat.split(":").map(Number); //adding prayer time to current date 
            currentDate.setHours(hours, minutes, seconds);
            timeDuration = currentDate;
            requiredTimeToPlay = updateTimeDifference(timeDuration);

            //showing differences time to ui with live action
            document.getElementById('hours').textContent = requiredTimeToPlay[0];
            document.getElementById('minutes').textContent = requiredTimeToPlay[1];
            document.getElementById('seconds').textContent = requiredTimeToPlay[2];

            //preparing to play mp3 file when reach required time zero
            if (requiredTimeToPlay[0] === '00' && requiredTimeToPlay[1] === '00' && requiredTimeToPlay[2] === '00') {
              playMP3(prayerTime);
              prayerTime = PrepareNextPrayerTime(miniSecondsArr, storedData);
            }
          }
        }

      });
    </script>
</body>

</html>