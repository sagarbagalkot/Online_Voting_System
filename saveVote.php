<?php

// Function to sanitize user inputs
if (!function_exists('test_input')) {
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
}

// Function to validate email
if (!function_exists('test_email')) {
  function test_email($email) {
    $email = trim($email);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      die("<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; text-align: center;'>
              <img src='images/error.png' width='100' height='100' style='margin-bottom: 20px;'>
              <h3 class='text-danger' style='font-weight: bold;'>Invalid Email Address.</h3>
              <button onclick=\"window.location.href='index.html'\" 
                style='margin-top: 20px; font-size: 18px; padding: 10px 30px; border-radius: 8px; background-color: #007BFF; color: white; border: none; cursor: pointer;'>
                <strong>Go Back</strong>
              </button>
          </div>");
    }
    return $email;
  }
}

require('config.php');

if (isset($_POST["submit"])) {
  if (!empty($_POST["voterName"]) && !empty($_POST["voterEmail"]) && !empty($_POST["voterID"]) && !empty($_POST["selectedCandidate"])) {
    $name = test_input($_POST["voterName"]);
    $email = test_email($_POST["voterEmail"]);
    $voterID = test_input($_POST["voterID"]);
    $selection = test_input($_POST["selectedCandidate"]);

    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "db_evoting";

    $conn = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
      or die("Couldn't Connect to Database :");

    // Use prepared statements to prevent SQL injection
    $checkEmailQuery = "SELECT * FROM tbl_users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; text-align: center;'>";
        echo "<img src='images/success.png' width='100' height='100' style='margin-bottom: 20px;'>";
        echo "<h3 class='text-success' style='font-weight: bold;'>Email Already Exist.</h3>";
        echo "<button onclick=\"window.location.href='index.html'\" 
                style='margin-top: 20px; font-size: 18px; padding: 10px 30px; border-radius: 8px; background-color: #007BFF; color: white; border: none; cursor: pointer;'>
                <strong>Go Back</strong>
              </button>";
        echo "</div>";
    } else {
      $insertQuery = "INSERT INTO tbl_users (full_name, email, voter_id, voted_for) VALUES (?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $insertQuery);
      mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $voterID, $selection);

      if (mysqli_stmt_execute($stmt)) {
        echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; text-align: center;'>";
        echo "<img src='images/success.png' width='100' height='100' style='margin-bottom: 20px;'>";
        echo "<h3 class='text-success' style='font-weight: bold;'>YOU'VE SUCCESSFULLY VOTED.</h3>";
        echo "<button onclick=\"window.location.href='index.html'\" 
                style='margin-top: 20px; font-size: 18px; padding: 10px 30px; border-radius: 8px; background-color: #007BFF; color: white; border: none; cursor: pointer;'>
                <strong>Finish</strong>
              </button>";
        echo "</div>";
      } else {
        echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; text-align: center;'>";
        echo "<img src='images/error.png' width='100' height='100' style='margin-bottom: 20px;'>";
        echo "<h3 class='text-danger' style='font-weight: bold;'>SORRY! WE'VE SOME ISSUE..</h3>";
        echo "<button onclick=\"window.location.href='index.html'\" 
                style='margin-top: 20px; font-size: 18px; padding: 10px 30px; border-radius: 8px; background-color: #007BFF; color: white; border: none; cursor: pointer;'>
                <strong>Finish</strong>
              </button>";
        echo "</div>";
      }
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } else {
    echo "<br>All Fields Required";
  }
}
?>
