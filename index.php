<?php
	define('DS', DIRECTORY_SEPARATOR);  
	
	function __autoload($class_name) {
	    $class_name = str_replace('\\', DS, $class_name);
	    if (file_exists("lib".DS."{$class_name}.php"))
	    	require_once "lib".DS."{$class_name}.php";
	    else
	    	echo " file lib".DS."{$class_name}.php NOT found \n";
	}

	$xlsx = new simplexlsx\SimpleXLSX("docs".DS."changed_dates.xlsx");
	$salesForecasts = $xlsx->rows();

	$wf = new WeatherForecast($_GET['lat'],$_GET['lon']);  

	if(!$wf->timeseries) {
		die("Coordinates are out of bounds..");
	}
	$sf = new SalesForecast($wf->timeseries, $salesForecasts);

	$updatedForecast = $sf->get();  

	$format = (isset($_GET['format']) && ($_GET['format'] !== ''))? $_GET['format'] : 'html';

	if($format === 'json') {
		// Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');
 
        // Format data into a JSON response
        echo json_encode($updatedForecast);
	} else {
		include 'html/index.php';
	}
?>