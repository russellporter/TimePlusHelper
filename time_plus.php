<?php
/**
* @author Russell Porter
* Time helper that is smart about timezones, wraps the CakePHP time helper
* Can add other functions from Time as needed
* It is a work in progress. If you improve this, submit a pull request with your changes!
*/
class TimePlusHelper extends AppHelper {
	var $helpers = array("Time");

	function nice($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		return $this->Time->nice($date_string, $offset);
	}

	// This doesn't work properly, there is a bug with $offset on CakePHP time so it sometimes shows Yesterday when it should be Today
	function niceShort($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		echo "Offset ${offset} \n\n";
		return $this->Time->niceShort($date_string, $offset);
	}

	/**
	* Converts a date string to UTC of form 2008-01-21 00:00:00
	*/
	function toSQL($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		echo "Offset ${offset} \n\n";
		return $this->Time->dayAsSql($date_string, $offset);
	}

	/**
	* Returns the current time in SQL format (2008-01-21 00:00:00)
	*/
	function nowSQL() {
		$time = new DateTime();
		$offset = $this->_computeOffset($time);
		return $this->Time->format('Y-m-d H:i:s', $time->format('U'), false, $offset);
	}

	/**
	* Converts a date string from UTC SQL returning the same form (2008-01-21 00:00:00)
	*/
	function fromSQL($date_string) {
		$offset = -1 * $this->_computeOffset(new DateTime($date_string));
		echo "Offset ${offset} \n\n";
		return $this->Time->format($date_string, $offset);
	}

	function format($format, $date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		return $this->Time->format($format, $date_string, false, $offset);
	}

	/**
	* Time offset in hours returned
	*/
	function _computeOffset($date) {
		// Load a timezone here - could look at the user session or other approaches to decide which timezone to show
		$clubTimezone = new DateTimeZone('America/Vancouver');

		return $clubTimezone->getOffset($date)/3600;
	}
}
?>