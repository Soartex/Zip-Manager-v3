<?php
// Check if user is logged in
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
  <title>Zip-Manager | Browse</title>
  <meta charset="UTF-8"/>
  <!-- Icon -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" />
  <!-- Stylesheets -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/bootstrap-editable.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!--Header-->
    <div class="page-header">
      <h2>Zip Manager | Browse</h2>
    </div>
    <ul class="breadcrumb">
      <li><a href="../login/">Home</a></li>
      <li><a href="../options/">Options</a></li>
      <li class="active">Browse</li>
    </ul>
    <hr>
    <!--Content -->
    <!--Session Info-->
    <div class="alert alert-info"> <strong>Current Zip Manager Options</strong>
      <button type='button' class='close' data-dismiss='alert'>&times;</button>
      <br>
      <?php
      echo "[Patcher Config]: ".$_SESSION['Config_Path']."<br>";
      echo "[Local Zip Directory]: ".$_SESSION['Zip_Path']."<br>";
      ?>
    </div>
    <?php
    // Patcher config
    $string = file_get_contents("../".$_SESSION['Config_Path']);
    $patcher_json = json_decode($string, true);
    // Lets get the current directory
    $dirFiles = array();
    // Opens zip directory
    if ($handle = opendir($_SESSION['Zip_Path'])) {
      while (false !== ($filename = readdir($handle))) {
        // Get all files that are not hidden folders
        if (substr($filename, 0, 1) !== '.'){
          $dirFiles[]=$filename;
        }
      }
    }
    // Sort the files alphabetically
    sort($dirFiles);
    // Create table to print the data out in
    echo '<table class="table table-hover table-bordered" id="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>File Name</th>';
    echo '<th>Date Modified</th>';
    echo '<th>Mod Version</th>';
    echo '<th>MC Version</th>';
    echo '<th>Options</th>';
    echo '</tr>';
    echo '</thead>';
    // Main body
    echo '<tbody>';
    foreach($dirFiles as &$zipName) {
      echo '<tr>';
      echo '<td>'.$zipName.'</td>';
      echo '<td>'.date('m-d-Y H:i:s', filemtime($_SESSION['Zip_Path'].$zipName)).'</td>';
      // Add spaces and remove ending
      $filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $zipName);
      $filename = str_replace('_', ' ', $filename);
      // See if there is a version in the mod.json
      if (isset($patcher_json["mods"][$filename]["version"])) {
        echo 
        '<td>
        <a href="#" class="editable" id="version" data-type="text" data-pk="'.$filename.'" title="Edit Mod">'.$patcher_json["mods"][$filename]["version"].'</a>
        </td>';
      } 
      // If there is no info, then say it is empty
      else {
        echo 
        '<td>
        <a href="#" class="editable" id="version" data-type="text" data-pk="'.$filename.'" title="Edit Mod"></a>
        </td>';
      }
      // See if there is a MC version in the mod.json
      if (isset($patcher_json["mods"][$filename]["mcversion"])) {
        echo 
        '<td>
        <a href="#" class="editable" id="mcversion" data-type="text" data-pk="'.$filename.'" title="Edit MC">'.$patcher_json["mods"][$filename]["mcversion"].'</a>
        </td>';
      } 
      // If there is no info, then say it is empty
      else {
        echo 
        '<td>
        <a href="#" class="editable" id="mcversion" data-type="text" data-pk="'.$filename.'" title="Edit MC"></a>
        </td>';
      }
      // Edit buttons
      echo 
      '<td>
      <div class="btn-group">
        <a class="btn btn-primary btn-xs" href="'.$_SESSION['Zip_Path'].$zipName.'">Download</a>
        <a class="btn btn-danger btn-xs" href="./deletezip.php?fileName='.$zipName.'" disabled >Delete</a>
      </div>
      </td>';
      echo '</tr>';
    }// End of foreach
    echo '</tbody>';
    echo '</table>';
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
<script type="text/javascript" src="../assets/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="../assets/js/main.js"></script>
</html>