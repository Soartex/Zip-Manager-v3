<?php
// Check if the user is logged in
session_start();
if (!$_SESSION['logged']) {
  header("Location: ../login/");
  exit ;
}
?>
<!DOCTYPE html>
<html>
<head>
  <!-- Page information -->
  <title>Zip-Manager | Options</title>
  <meta charset="UTF-8"/>
  <!-- Icon -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" />
  <!-- Stylesheets -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!--Header-->
    <div class="page-header">
      <h2>Zip Manager | Options</h2>
    </div>
    <ul class="breadcrumb">
      <li><a href="../login/">Home</a></li>
      <li class="active">Options</li>
    </ul>
    <hr>
    <!--Content -->
    <?php
    // Get option information
    $string = file_get_contents("../data/options.json");
    $json = json_decode($string, true);
    // Get the keys/presets
    $preset_array = array_keys($json);

    echo '<form action="./UpdateOptions.php" method="post" class="form-inline">';
    echo '<label>Pick a preset</label><br>';
    $first = True;
    foreach($preset_array as &$profile) {
      // Auto select the first preset
      if($first){
        echo '<div class="radio" style="padding:10px">';
        echo '<label>';
        echo '<input type="radio" name="preset" value="'.$profile.'" checked> '.$profile;
        echo '</label>';
        echo '</div>';
        $first=False;
      }
      // Do not select the rest of them
      else{
        echo '<div class="radio" style="padding:10px">';
        echo '<label>';
        echo '<input type="radio" name="preset" value="'.$profile.'"> '.$profile;
        echo '</label>';
        echo '</div>';
        
      }
      // Update button
      //echo '<a type="button" class="btn btn-primary" href="'.$json[$profile]["Update_Path"].'"">Update</a><br>';
      // Commit infos
      $ctx = stream_context_create(array('http'=>
        array(
          'timeout' => 5
        )
      ));
      $commit = file_get_contents($json[$profile]["Version_Path"], false, $ctx);
      $commit = explode("\n", $commit);
      if(!$commit){
        $commit = "null";
      }
      echo '<div class="alert alert-info">';
      echo "Latest Commits:<br>";
      for ($i=0;$i<count($commit);$i++) {
          echo $commit[$i].'<br>';
      }
      echo '</div>';
    }
    // Get api rate info
    ini_set('user_agent','Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17');
    $string = file_get_contents("https://api.github.com/rate_limit");
    $json = json_decode($string, true);

    // Submit Button
    echo '<br>';
    echo '<div class="label label-danger" style="padding:10px;font-size:120%;">Requests Left: '.$json['resources']['core']['remaining'].'</div>';
    echo '<button style="margin-left:20px; type="submit" name="submit" class="btn btn-success">Submit</button>';
    echo '</form>';    
    ?>
    <!-- Footer -->
    <hr>
    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright &copy; Soartex 2013-2014</p>
        </div>
      </div>
    </footer>
</body>
<!-- Javascripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</html>