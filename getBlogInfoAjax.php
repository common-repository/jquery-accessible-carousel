<?php

/** Define ABSPATH as this files directory */
define('ABSPATH', dirname(__FILE__) . '/../../../');
include_once(ABSPATH . "wp-config.php");

$output = get_bloginfo('wpurl');
$stuffToReturn = array();
$stuffToReturn["wpurl"] = $output;
echo json_encode($stuffToReturn);

?>
