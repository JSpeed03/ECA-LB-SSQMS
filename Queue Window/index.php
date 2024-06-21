<?php
require '../DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Queue Window</title>
  <link href="../logo/exact logo - HD.png" rel="icon">
  <link rel="stylesheet" href="Queue Window.css">
  <script type="text/javascript">

function refreshPage() {
    setTimeout(function() {
        location.reload();
    }, 10000); 
}
</script>
</head>
<body >
  
  <div class="grid">
  <div class="video-player">
  <?php
  $videoFolder = '../queue_screen_video/';
  $videoExtensions = ['mp4', 'webm', 'ogv']; // add more extensions if needed
  $videos = [];

  // Scan the directory for video files
  foreach (scandir($videoFolder) as $file) {
    $FileInfo = pathinfo($file);
    if (in_array($FileInfo['extension'], $videoExtensions)) {
      $videos[] = $FileInfo['basename'];
    }
  }

  // Generate the video playlist
  if (!empty($videos)) {
    $currentVideo = array_shift($videos); // play the first video
    echo '<video id="videoPlayer" autoplay controls muted>';
    echo '<source src="'. $videoFolder. $currentVideo. '" type="video/'. pathinfo($currentVideo, PATHINFO_EXTENSION). '">';
    echo 'Your browser does not support the video tag.';
    echo '</video>';

    // Add a script to cycle through the videos
    echo '<script>';
    echo 'var videos = ['. implode(',', array_map(function($video) {
      return "'" . $video . "'";
    }, $videos)). '];';
    echo 'var videoPlayer = document.getElementById("videoPlayer");';
    echo 'var videoIndex = 0;';
    echo 'videoPlayer.addEventListener("ended", function() {';
    echo '  videoIndex = (videoIndex + 1) % videos.length;';
    echo '  videoPlayer.src = "'. $videoFolder. '" + videos[videoIndex];';
    echo '  videoPlayer.load();';
    echo '  videoPlayer.play();';
    echo '});';
    echo '</script>';
  } else {
    echo 'No videos found in the directory.';
  }
  ?>
</div>

    
    <div class="queue" >
      <table id="queueTable">
      
        <thead>
        <tr>
            <th>Window</th>
            <th>Now Serving</th>
        </tr>
        </thead>
        <tbody>
        <audio id="notificationSound" src="notif.wav" preload="auto"></audio>

        </tbody>
      
   
      </table>
    </div>
    <div id="digital-clock"></div>
    <div id="date"></div>
  </div>
  <table>
    <tr>
      <td>
        <div class="logo-div">
          <img class="bottom-left-logo" src="../logo/exact logo - HD.png" alt="Logo logo_main" />
        </div>
      </td>
      <td>
        <div class="bottom-right-image">
          <img src="../logo/ECA ship and lighthouse cut.png" alt="Bottom Right Image" />
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div class="running-news">
          <h1 class="marquee" id="news"></h1>
        </div>
      </td>
    </tr>
  </table>
  <div class="bottom-image">
    <img src="../logo/eca bg.png" alt="Bottom Image">
  </div> 
  <div class="logo-bg">
          <img class="bottom-left-bg" src="../logo/gradient bg.png" alt="Logo logo_main" />
        </div>
  <script>
    function updateClock() {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");
  const seconds = now.getSeconds().toString().padStart(2, "0");
  const digitalClock = document.getElementById("digital-clock");
  digitalClock.textContent = `${hours}:${minutes}:${seconds}`;

  const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  const day = days[now.getDay()];
  const date = now.getDate();
  const month = months[now.getMonth()];
  const year = now.getFullYear();
  const dateString = `${day}, ${month} ${date}, ${year}`;
  const dateElement = document.getElementById("date");
  dateElement.textContent = dateString;
}

function changeLogo() {
  const logoDiv = document.querySelector(".logo-div img");
  const logos = ["exact logo - HD.png", "BSIS.png", "CBA.png", "Crim.png", "Educ.png", "BSIS.png", "Maritime.png", "Tourism.png", "NSTP.png", "SHS.png", "Nursing.png", "BSIS.png"]; // Add your logos here
  const randomLogo = logos[Math.floor(Math.random() * logos.length)];
  logoDiv.src = `../logo/${randomLogo}`;
}

async function fetchNews() { //limit of 52 character max space include
    try {
      const response = await fetch('news_data.txt'); 
      if (response.ok) {
        const news = await response.text();
        document.getElementById('news').textContent = news;
      } else {
        console.error('Error fetching news:', response.statusText);
      }
    } catch (error) {
      console.error('Error fetching news:', error);
    }
  }

  

setInterval(updateClock, 1000);
setInterval(changeLogo, 2000); // Change logo every 2 seconds
updateClock();
changeLogo();
fetchNews();
  </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  let previousData = [];

  const fetchData = (date = null) => {
    let url = 'fetchdata.php';
    if (date) {
      url += `?date=${date}`;
    }

    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        const tableBody = document.querySelector('#queueTable tbody');
        tableBody.innerHTML = '';

        if (Array.isArray(data) && data.length > 0) {
          const newData = data.filter(row => !previousData.some(prevRow => JSON.stringify(prevRow) === JSON.stringify(row)));

          newData.forEach(row => {
            const tr = document.createElement('tr');
            tr.classList.add('blink'); // Add blink class to new rows
            Object.values(row).forEach(cell => {
              const td = document.createElement('td');
              td.textContent = cell;
              tr.appendChild(td);
            });
            tableBody.appendChild(tr);
          });

          // Remove the blink class after 5 seconds
          setTimeout(() => {
            document.querySelectorAll('.blink').forEach(el => el.classList.remove('blink'));
          }, 5000);

          // Append all rows (new and existing) to the table
          data.forEach(row => {
            const tr = document.createElement('tr');
            if (!newData.includes(row)) { // If it's not a new row, don't add the blink class
              Object.values(row).forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell;
                tr.appendChild(td);
              });
              tableBody.appendChild(tr);
            }
          });

          previousData = data; // Update previousData after processing
        } else {
          const tr = document.createElement('tr');
          const td = document.createElement('td');
          td.colSpan = 2;
          td.textContent = 'No data available';
          tr.appendChild(td);
          tableBody.appendChild(tr);
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        const tableBody = document.querySelector('#queueTable tbody');
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 2;
        td.textContent = 'Error fetching data';
        tr.appendChild(td);
        tableBody.appendChild(tr);
      });
  };

  fetchData();

  setInterval(fetchData, 500); // Fetch data every 5 seconds

  document.getElementById('filterDate').addEventListener('change', function() {
    const date = this.value;
    fetchData(date);
  });
});

</script>



</body>
</html>
