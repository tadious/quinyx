<?php
	/*
	 * Some useful functions
	 */

	class Utils {
		
		public static function excelToUnixTimestamp($excelTimestamp) {
			$d = floor( $excelTimestamp ); // seconds since 1900
	    	$t = $excelTimestamp - $d;
	    	return ($d > 0) ? ( $d - 25569 ) * 86400 + $t * 86400 : $t * 86400;
		}

		public static function indexAtHalfHour($date) {
			return strtotime(date('Y-m-d H', strtotime($date)).':30:00');
		}
	}
?>