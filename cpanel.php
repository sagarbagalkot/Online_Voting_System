<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control Panel</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

    <style>
      .headerFont {
        font-family: 'Ubuntu', sans-serif;
        font-size: 24px;
      }

      .subFont {
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
      }
      
      .specialHead {
        font-family: 'Oswald', sans-serif;
      }

      .normalFont {
        font-family: 'Roboto Condensed', sans-serif;
      }
      
      .winner {
        font-size: 24px;
        font-weight: bold;
        color: green;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    
  <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a href="cpanel.php" class="navbar-brand headerFont text-lg"><strong>eVoting</strong></a>
        </div>

        <div class="collapse navbar-collapse" id="example-nav-collapse">
          <ul class="nav navbar-nav">
             <li><a href="nomination.html"><span class="subFont"><strong>Nomination's List</strong></span></a></li>          
          </ul>
          
          <span class="normalFont"><a href="index.html" class="btn btn-success navbar-right navbar-btn"><strong>Sign Out</strong></a></span>
        </div>
      </div>
    </nav>

    <div class="container" style="padding:100px;">
      <div class="row">
        <div class="col-sm-12" style="border:2px solid gray;">
          
          <div class="page-header">
            <h2 class="specialHead">CONTROL PANEL</h2>
            <p class="normalFont">This is the Administration Panel.</p>
          </div>
          
          <div class="col-sm-12">
            <?php
              require 'config.php';

              $BJP = 0;
              $CONG = 0;
              $TV = 0;
              $FAN = 0;
              $totalVotes = 0;

              // Create connection
              $conn = mysqli_connect($hostname, $username, $password, $database);
              if (!$conn) {
                echo "Error while connecting.";
              } else {
                // Get Total Votes
                $sql = "SELECT * FROM tbl_users";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['voted_for']) {
                      $totalVotes++;
                    }
                  }
                }

                // BJP Votes
                $sql = "SELECT * FROM tbl_users WHERE voted_for='BJP'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['voted_for']) {
                      $BJP++;
                    }
                  }
                }
                
                // INC Votes
                $sql = "SELECT * FROM tbl_users WHERE voted_for='CONG'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['voted_for']) {
                      $CONG++;
                    }
                  }
                }

                // AAP Votes
                $sql = "SELECT * FROM tbl_users WHERE voted_for='TV'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['voted_for']) {
                      $TV++;
                    }
                  }
                }

                // TMC Votes
                $sql = "SELECT * FROM tbl_users WHERE voted_for='FAN'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['voted_for']) {
                      $FAN++;
                    }
                  }
                }

                // Calculate Percentages
                if ($totalVotes > 0) {
                  $bjpPercentage = ($BJP / $totalVotes) * 100;
                  $congPercentage = ($CONG / $totalVotes) * 100;
                  $tvPercentage = ($TV / $totalVotes) * 100;
                  $fanPercentage = ($FAN / $totalVotes) * 100;
                }

                // Display Results
                echo "<strong>BJP</strong> - " . round($bjpPercentage, 2) . "%<br>";
                echo "
                  <div class='progress'>
                    <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow=\"$bjpPercentage\" aria-valuemin=\"0\" aria-valuemax=\"100\" style='width: $bjpPercentage%'>
                      <span class='sr-only'>BJP</span>
                    </div>
                  </div>
                ";

                echo "<strong>Congress</strong> - " . round($congPercentage, 2) . "%<br>";
                echo "
                  <div class='progress'>
                    <div class='progress-bar progress-bar-primary' role='progressbar' aria-valuenow=\"$congPercentage\" aria-valuemin=\"0\" aria-valuemax=\"100\" style='width: $congPercentage%'>
                      <span class='sr-only'>Congress</span>
                    </div>
                  </div>
                ";

                echo "<strong>TV</strong> - " . round($tvPercentage, 2) . "%<br>";
                echo "
                  <div class='progress'>
                    <div class='progress-bar progress-bar-info' role='progressbar' aria-valuenow=\"$tvPercentage\" aria-valuemin=\"0\" aria-valuemax=\"100\" style='width: $tvPercentage%'>
                      <span class='sr-only'>TV</span>
                    </div>
                  </div>
                ";

                echo "<strong>FAN</strong> - " . round($fanPercentage, 2) . "%<br>";
                echo "
                  <div class='progress'>
                    <div class='progress-bar progress-bar-warning' role='progressbar' aria-valuenow=\"$fanPercentage\" aria-valuemin=\"0\" aria-valuemax=\"100\" style='width: $fanPercentage%'>
                      <span class='sr-only'>FAN</span>
                    </div>
                  </div>
                ";

                // Display Total Votes
                echo "<hr>";
                echo "<strong>Total Number of Votes</strong><br>";
                echo "<div class='text-primary'><h3 class='normalFont'>VOTES: $totalVotes</h3></div>";

                // Announce the Winner
                $maxPercentage = max($bjpPercentage, $congPercentage, $tvPercentage, $fanPercentage);
                if ($maxPercentage == $bjpPercentage) {
                  echo "<div class='winner'>BJP is the Winner with " . round($bjpPercentage, 2) . "% of the total votes!</div>";
                } elseif ($maxPercentage == $congPercentage) {
                  echo "<div class='winner'>Congress is the Winner with " . round($congPercentage, 2) . "% of the total votes!</div>";
                } elseif ($maxPercentage == $tvPercentage) {
                  echo "<div class='winner'>Aam Aadmi Party is the Winner with " . round($tvPercentage, 2) . "% of the total votes!</div>";
                } else {
                  echo "<div class='winner'>Trinamool Congress is the Winner with " . round($fanPercentage, 2) . "% of the total votes!</div>";
                }
              }
            ?>
          </div>

        </div>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
