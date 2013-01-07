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

			foreach(scandir($dir) as $file) {
				
				if(substr($file, -4) === '.php' and file_exists("$dir/$file")) {

					$klass = '\\Listener\\' . str_replace('/', '\\', $event) . '\\'. substr($file, 0, -4);
					$listener = new $klass();
					$listener->run();
					$any = true;

				}

			}

		}

		return $any;

	}

}