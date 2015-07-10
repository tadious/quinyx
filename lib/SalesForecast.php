<?php
	
	/**
	* 
	*
	*
	*/

	use Ruler\RuleBuilder;

	/*
		SOLID Rules:	
		1. 15 < Temperature < 28 : ADD forecast *(Temperature-15)*2%
		2. 28 <= Temperature : SUBTRACT forecast *(28-Temperature)*6%
		3. 1 < Precipitation && Fri 16:00 <= Date  <= Sun 23:00 : ADD forecast*10%
		4. SUBTRACT (Precipitation*10%*forecast >= (forecast/2))? forecast/2: Precipitation*10%*forecast

	*/

	class SalesForecast {
		
		static $rb;
		
		//Rules for updating sales forecasts
		private $rule_isWeekendPeak; 
		private $rule_temperatureGreaterThanOrEqualTo;
		private $rule_temperatureLessThanOrEqualTo;
		private $rule_rainfallGreaterThanOrEqualTo;
		private $rule_rainfallLessThanOrEqualTo;
		
		private $initialForecast = null;
		private $weatherSeries = null;

		private $forecast = null;

		function __construct($_weatherSeries, $_initialForecast) {
			self::$rb = new Ruler\RuleBuilder;

			$this->weatherSeries = $_weatherSeries;
			$this->initialForecast = $_initialForecast;

			$this->updateSalesForecast();
		}

		public function get() {
			return $this->forecast;
		}

		public function updateSalesForecast() {
			$this->forecast = [];

			foreach ($this->initialForecast as $sales_forecast) {
				
				if(is_numeric($sales_forecast[0]) && is_numeric($sales_forecast[1])) {
					//TODO[Tadious]: Technical Debt
					$date = gmdate('Y-m-d H:i:s', 1+Utils::excelToUnixTimestamp($sales_forecast[0]));
					$index = Utils::indexAtHalfHour($date);

					if (array_key_exists($index, $this->weatherSeries)) {
						
						$this->forecast[] = $this->recalculate($date, $sales_forecast, $this->weatherSeries[$index]);
					} else {
						
						$this->forecast[] = [$date, $sales_forecast[1], 0, null, null];	
					}

				} else {
					$this->forecast[] = [$sales_forecast[0], $sales_forecast[1], 'Updated Forecast', 'Temperature', 'Average Rainfall'];
				}
			}
		}

		private function recalculate($date, $forecast, $weather) {
			$initialForecast = $forecast[1];
			$moderate_temp_increase = $high_temp_decrease = $wkend_low_rain_increase = $rainfall_decrease = 0;

			// 15 < temp < 28
			$moderateTempRule = self::$rb->create(
				self::$rb->logicalAnd(
			        self::$rb['temperatureForecast']->lessThan(self::$rb['maxTemperatureThreshold']),
			        self::$rb['temperatureForecast']->greaterThan(self::$rb['minTemperatureThreshold'])
			    ));
			$tempContext = new Ruler\Context(array('temperatureForecast' => $weather->t,'minTemperatureThreshold' => function() { return 15; },'maxTemperatureThreshold' => function() { return 28; }));

			if($moderateTempRule->evaluate($tempContext)) {
				$moderate_temp_increase = (($weather->t-15)*2*$initialForecast)/100;
			}

			// 28 <= temp
			$highTempRule = self::$rb->create(self::$rb['temperatureForecast']->greaterThanOrEqualTo(self::$rb['maxTemperatureThreshold']));
			if ($highTempRule->evaluate($tempContext)) {
				$high_temp_decrease = (($weather->t-28)*6*$initialForecast)/100;
			}

			$lowRainfallRule = self::$rb->create(self::$rb['rainfallForecast']->lessThan(self::$rb['lowRainfallThreshold']));
			$rainfallContext = new Ruler\Context(array('rainfallForecast'=>$weather->pmean, 'lowRainfallThreshold'=>function(){ return 1;}));

			if ($this->isWeekendPeak($date) && $lowRainfallRule->evaluate($rainfallContext)) {
				$wkend_low_rain_increase = ($initialForecast*10)/100;
			}

			if ($weather->pmean > 0) {
				$rainfall_decrease_factor = ($weather->pmean*10*$initialForecast)/100;  
				$rainfall_decrease = ($rainfall_decrease_factor > ($initialForecast/2))? $initialForecast/2 : $rainfall_decrease_factor;	
			}
			

			$updatedForecast = $initialForecast + $moderate_temp_increase - $high_temp_decrease + $wkend_low_rain_increase - $rainfall_decrease;
			
			return [$date, $initialForecast, $updatedForecast, $weather->t, $weather->pmean];
		}

		//TODO[Tadious]: Add this rule to the Rules Engine
		private function isWeekendPeak($date) {
			$isItWeekend = false;
			$day = (int)date('N', strtotime($date));
			$hour = (int)date('H', strtotime($date));

			switch($day) {
				case 1: //Monday
				case 2: //Tuesday
				case 3: //Wednesday
				case 4: //Thursday
					$isItWeekend = false;
				break;
				case 5: //Friday
					if ($hour >= 16)
						$isItWeekend = true;
				break;

				case 6: //Saturday
					$isItWeekend = true;
				break;

				case 7: //Sunday
					if ($hour < 23)
						$isItWeekend = true;
				break;
			}

			return $isItWeekend;
		}
	}
?>