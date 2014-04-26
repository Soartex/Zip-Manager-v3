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
      echo "[Zip Url]: ".$_SESSION['Zip_Path']."<br>";
      echo "[Repo Url]: ".$_SESSION['Repo_Path']."<br>";
      ?>
    </div>
    <?php
    // Patcher config get
    ini_set('user_agent','Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17');
    $string = file_get_contents("../".$_SESSION['Config_Path']);
    $patcher_json = json_decode($string, true);

    // Lets get the mod folders
    $dirFiles = array();
    // Request info
    $contents = file_get_contents($_SESSION['Repo_Path'], false);
    $json_data = json_decode($contents);

    // Create table to print the data out in
    echo '<table class="table table-hover table-bordered" id="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>File Name</th>';
    echo '<th>Mod Version</th>';
    echo '<th>MC Version</th>';
    echo '<th>Options</th>';
    echo '</tr>';
    echo '</thead>';
    // Main body
    echo '<tbody>';
    if($json_data) {
      foreach($json_data->{'tree'} as &$j_object) {
        // Check if this is a folder
        if ($j_object->{'type'} === 'blob')
          continue;
        // Check if this is a top level folder
        if (strpos($j_object->{'path'}, '/') !== FALSE)
          continue;

        // Start table
        echo '<tr>';
        echo '<td>'.$j_object->{'path'}.'.zip</td>';

        // Add spaces and remove ending
        $filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $j_object->{'path'});
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
          <a class="btn btn-primary btn-xs" href="'.$_SESSION['Zip_Path'].$j_object->{'path'}.'.zip">Download</a>
        </td>';
        echo '</tr>';
      }// End of foreach
    }// End of if
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