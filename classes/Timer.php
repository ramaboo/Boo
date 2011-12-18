<?php
/* SVN FILE: $Id: Timer.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Timer class.
 * 
 * This class creates a simple timer usefull for timing blocks of code.
 * 
 * @class		Boo_Timer
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Timer {
	
	/**
	 * @brief Start time.
	 */
	protected $startTime = false;
	
	/**
	 * @brief Total time.
	 */
	protected $totalTime = false;
	
	/**
	 * @brief Default constructor.
	 * @return void
	 */
	public function __construct() {}
	
	/**
	 * @brief Start the timer.
	 * @return float The start time.
	 */
	public function start() {
		$time = $this->getMicroTime();
		$this->startTime = $time;
		return $time;
	}
	
	/**
	 * @brief Stop the timer.
	 * @return float The stop time.
	 */
	public function stop() {
		if ($this->startTime === false) {
			trigger_error('Timer has not been started, try Boo_Timer::start() first', E_USER_NOTICE);
			return false;
		}
		$time = $this->getMicroTime();
		// set total time
		$this->totalTime += $time - $this->startTime;
		// reset start time
		$this->startTime = false;
		return $time;
	}
	
	/**
	 * @brief Gets the time.
	 * @return float The time. If the timer is stopped the total time will be returned.
	 * if the timer is still running then the current time running will be returned.
	 */
	function getTime() {
		$time = $this->getMicroTime();
		if ($this->startTime === false) {
			// timer is stopped
			return $this->totalTime;
		} else {
			// timer is still running
			$currentTime =($time - $this->startTime) + $this->totalTime;
			return $currentTime;
		}
	}
	
	/**
	 * @brief Returns the micro time.
	 * @return float The micro time.
	 */
	static function getMicroTime() {
		$time = microtime();
		$time = explode(' ', $time);
		try {
			$time = $time[1] + $time[0];
		} catch (Exception $e) {
			trigger_error('Call to microtime() failed', E_USER_ERROR);
		}
		
		return $time;
	}
	
	/**
	 * @brief Resets the timer.
	 * @return bool Function always returns TRUE.
	 */
	public function reset() {
		$this->startTime = false;
		$this->totalTime = false;
		return true;
	}
}