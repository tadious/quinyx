<?php

	class WeatherForecast {
		
		const LOWER_LAT = 54;
		const UPPER_LAT = 70.666011;

		const LOWER_LON = 2.250475;
		const UPPER_LON = 37.934697;

		private $latitude = null;
		private $longitude = null;

		public $timeseries = null;

		function __construct($_latitude, $_longitude) {
			
			if (($_latitude >= self::LOWER_LAT) && ($_latitude <= self::UPPER_LAT) && ($_longitude >= self::LOWER_LON) && ($_longitude <= self::UPPER_LON)){
				$this->latitude = $_latitude;
				$this->longitude = $_longitude;

				$this->getForecast();	
			}
		}

		private function getForecast() {
			$restURL = "http://opendata-download-metfcst.smhi.se/api/category/pmp2g/version/1/geopoint/lat/{$this->latitude}/lon/{$this->longitude}/data.json";
			$json = $this->url_get_contents($restURL);
			if ($json) {
				$weatherForecasts = json_decode($json);
				$this->timeseries = [];
				foreach ($weatherForecasts->timeseries as $timeseries) {
					$index = Utils::indexAtHalfHour(date('Y-m-d H:i:s', strtotime($timeseries->validTime)));
					$this->timeseries[$index] = $timeseries;
				}	
			}
		}

		private function url_get_contents ($restURL) {
		    return file_get_contents($restURL);
		}
	}

?>