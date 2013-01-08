<?php

namespace Core;

/**
 * Event Class
 * @author Evan Byrne
 */
class Event {
	
	/**
	 * Trigger
	 * @param string Event path
	 * @return boolean Whether any event listeners were triggered
	 */
	public static function trigger($event) {

		$any = false;
		$dir = APPLICATION . "/listener/$event";

		if(is_dir($dir)) {

			$listeners = array();
			foreach(scandir($dir) as $file) {
				
				if(substr($file, -4) === '.php' and file_exists("$dir/$file")) {

					$klass = '\\Listener\\' . str_replace('/', '\\', $event) . '\\'. substr($file, 0, -4);
					$priority = (isset($klass::$priority)) ? $klass::$priority : 0;
					$listeners[$klass] = $priority;
					$any = true;

				}

			}

			asort($listeners);
			foreach($listeners as $klass => $priority) {

				$listener = new $klass();
				$listener->run();

			}

		}

		return $any;

	}

}