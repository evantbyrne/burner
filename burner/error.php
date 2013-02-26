<?php

namespace Core;

/**
 * Dingo Error
 * @param int Level
 * @param string Message
 * @param string File
 * @param mixed Line
 */
function burner_error($level, $message, $file = 'current file', $line='(unknown)') {
	
	$fatal = false;
	$exception = false;
	
	switch($level) {
		
		case('exception'):
			$prefix = 'Uncaught Exception';
			$exception = true;
			break;
			
		case(E_RECOVERABLE_ERROR):
			$prefix = 'Recoverable Error';
			$fatal	 = true;
			break;
			
		case(E_USER_ERROR):
			$prefix = 'Fatal Error';
			$fatal	 = true;
			break;
		
		case(E_NOTICE):
		case(E_USER_NOTICE):
			$prefix = 'Notice';
			break;
			
		case(E_DEPRECATED):
		case(E_USER_DEPRECATED):
			$prefix = 'Deprecated';
			break;
		
		case(E_STRICT):
			$prefix = 'Strict Standards';
			break;
			
		default:
			$prefix = 'Warning';
			
	}
	
	$error = array(
		'level'   => $level,
		'prefix'  => $prefix,
		'message' => $message,
		'file'    => $file,
		'line'    => $line
	);
	
	if($fatal or $exception or \Core\Config::get('debug')) {
	
		ob_clean();
		echo "<p>{$error['prefix']}: <strong>{$error['message']}</strong> In {$error['file']} At Line {$error['line']}</p>";
		ob_end_flush();
		exit;
	
	}
	
	if(\Core\Config::get('error_logging')) {
		
		$date = date('g:i A M d Y');
		$fh = fopen(\Core\Config::get('error_logging_file'), 'a');
		flock($fh, LOCK_EX);
		fwrite($fh, "[$date] {$error['prefix']}: {$error['message']} IN {$error['file']} ON LINE {$error['line']}\n");
		flock($fh, LOCK_UN);
		fclose($fh);
		
	}
	
}

/**
 * Burner Exception
 * @param \Exception
 */
function burner_exception($ex) {
	
	burner_error('exception', "\n{$ex->getMessage()}<pre>\n{$ex->getTraceAsString()}</pre>\n", $ex->getFile(), $ex->getLine());

}