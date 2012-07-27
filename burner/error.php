<?php

namespace Core;

/**
 * Dingo Error Handling Functions
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 *
 * Many thanks to Kalle for providing code
 * http://www.talkphp.com/show-off/4070-dingo-framework-alpha-testing-open-3.html#post23025
 */


// Errors
// ---------------------------------------------------------------------------
function dingo_error($level,$message,$file='current file',$line='(unknown)')
{
	$fatal = false;
	$exception = false;
	
	switch($level)
	{
		case('exception'):
		{
			$prefix = 'Uncaught Exception';
			$exception = true;
		}
		break;
		case(E_RECOVERABLE_ERROR):
		{
			$prefix = 'Recoverable Error';
			$fatal	 = true;
		}
		break;
		case(E_USER_ERROR):
		{
			$prefix = 'Fatal Error';
			$fatal	 = true;
		}
		break;
		case(E_NOTICE):
		case(E_USER_NOTICE):
		{
			$prefix = 'Notice';
		}
		break;
		/* E_DEPRECATED & E_USER_DEPRECATED, available as of PHP 5.3 - Use their numbers here to prevent redefining them and two E_NOTICE's */
		case(8192):
		case(16384):
		{
			$prefix = 'Deprecated';
		}
		case(E_STRICT):
		{
			$prefix = 'Strict Standards';
		}
		break;
		default:
		{
			$prefix = 'Warning';
		}
	}
	
	$error = array(
		'level'=>$level,
		'prefix'=>$prefix,
		'message'=>$message,
		'file'=>$file,
		'line'=>$line
	);
	
	if($fatal)
	{
		ob_clean();
		
		if(file_exists(APPLICATION.'/error/fatal.php'))
		{
			require(APPLICATION.'/error/fatal.php');
		}
		else
		{
			echo 'Could not locate error file at '.APPLICATION.'/error/fatal.php';
		}
		
		ob_end_flush();
		exit;
	}
	elseif($exception)
	{
		ob_clean();
		
		if(file_exists(APPLICATION.'/error/exception.php'))
		{
			require(APPLICATION.'/error/exception.php');
		}
		else
		{
			echo 'Could not locate exception file at '.APPLICATION.'/error/exception.php';
		}
		
		ob_end_flush();
		exit;
	}
	elseif(DEBUG)
	{
		if(file_exists(APPLICATION.'/error/nonfatal.php'))
		{
			require(APPLICATION.'/error/nonfatal.php');
		}
		else
		{
			echo 'Dingo could not locate error file at '.APPLICATION.'/error/nonfatal.php';
		}
	}
	
	if(ERROR_LOGGING)
	{
		dingo_error_log($error);
	}
}


// Exceptions
// ---------------------------------------------------------------------------
function dingo_exception($ex)
{
	dingo_error('exception',$ex->getMessage(),$ex->getFile(),$ex->getLine());
}


// Error Logging
// ---------------------------------------------------------------------------
function dingo_error_log($error)
{
	$date = date('g:i A M d Y');
	
	$fh = fopen(ERROR_LOG_FILE,'a');
	flock($fh,LOCK_EX);
	fwrite($fh,"[$date] {$error['prefix']}: {$error['message']} IN {$error['file']} ON LINE {$error['line']}\n");
	flock($fh,LOCK_UN);
	fclose($fh);
}