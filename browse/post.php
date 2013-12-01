<?php
    /*
    * Script for update record from X-editable.
    */

    // Type (version, mcversion)
    $pk = $_POST['pk'];
    // What config file (mod name)
    $name = $_POST['name'];
    // What should be the value
    $value = $_POST['value'];

    // Checks if there are any quotes or if it is blank
    if(!empty($value)){
        // Start session to get variables
        session_start();
        // Get config files
        $string = file_get_contents("../".$_SESSION['Config_Path']);
        $patcher_json = json_decode($string, true);
        // Change config information
        $patcher_json["mods"][$pk][$name] = addslashes($value);
        // Sort
        ksort($patcher_json["mods"]);
        // Output file
        $fp = fopen("../".$_SESSION['Config_Path'], 'w');
        fwrite($fp, json_encode($patcher_json, JSON_PRETTY_PRINT));
        fclose($fp);
    }
    // Return error if needed
    else{
        header('HTTP 400 Bad Request', true, 400);
        echo "Data can not be blank.";
    }
?>