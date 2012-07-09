<?php

namespace Dingo;

/**
 * Response Class
 * @author Evan Byrne
 */
class Response {

	/**
	 * View
	 * @param View to load
	 * @param Associated array of data to pass to view
	 * @param HTTP status code
	 * @return HTTP Response object
	 */
	public static function view($view, $data = null, $code = null) {

		return new Response(View::render($view, $data), $code);

	}
	
	
	
	protected $content;
	protected $code;
	
	/**
	 * Constructor
	 * @param Response content
	 * @param HTTP status code
	 */
	public function __construct($content = '', $code = null) {
	
		$this->content = $content;
		$this->code = ($code === null) ? (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200) : $code;
	
	}
	
	/**
	 * Content
	 * @return Response content
	 */
	public function content() {
	
		return $this->content;
	
	}
	
	/**
	 * Code
	 * @return HTTP status code
	 */
	public function code() {
	
		return $this->code;
	
	}
	
	/**
	 * Header
	 * @return HTTP header string
	 */
	public function header() {

		switch($this->code) {
			
			case 100: $text = 'Continue'; break;
			case 101: $text = 'Switching Protocols'; break;
			case 200: $text = 'OK'; break;
			case 201: $text = 'Created'; break;
			case 202: $text = 'Accepted'; break;
			case 203: $text = 'Non-Authoritative Information'; break;
			case 204: $text = 'No Content'; break;
			case 205: $text = 'Reset Content'; break;
			case 206: $text = 'Partial Content'; break;
			case 300: $text = 'Multiple Choices'; break;
			case 301: $text = 'Moved Permanently'; break;
			case 302: $text = 'Moved Temporarily'; break;
			case 303: $text = 'See Other'; break;
			case 304: $text = 'Not Modified'; break;
			case 305: $text = 'Use Proxy'; break;
			case 400: $text = 'Bad Request'; break;
			case 401: $text = 'Unauthorized'; break;
			case 402: $text = 'Payment Required'; break;
			case 403: $text = 'Forbidden'; break;
			case 404: $text = 'Not Found'; break;
			case 405: $text = 'Method Not Allowed'; break;
			case 406: $text = 'Not Acceptable'; break;
			case 407: $text = 'Proxy Authentication Required'; break;
			case 408: $text = 'Request Time-out'; break;
			case 409: $text = 'Conflict'; break;
			case 410: $text = 'Gone'; break;
			case 411: $text = 'Length Required'; break;
			case 412: $text = 'Precondition Failed'; break;
			case 413: $text = 'Request Entity Too Large'; break;
			case 414: $text = 'Request-URI Too Large'; break;
			case 415: $text = 'Unsupported Media Type'; break;
			case 500: $text = 'Internal Server Error'; break;
			case 501: $text = 'Not Implemented'; break;
			case 502: $text = 'Bad Gateway'; break;
			case 503: $text = 'Service Unavailable'; break;
			case 504: $text = 'Gateway Time-out'; break;
			case 505: $text = 'HTTP Version not supported'; break;
			default: exit("Unknown HTTP status code: $code"); break;
		
		}

		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
		$GLOBALS['http_response_code'] = $this->code;
		return $protocol . ' ' . $this->code . ' ' . $text;

	}

}

/**
 * JSON Response Class
 * @author Evan Byrne
 */
class JsonResponse extends Response {

	/**
	 * Constructor
	 * @param Response content
	 * @param HTTP status code
	 */
	public function __construct($content = '', $code = null) {
	
		parent::__construct($content, $code);
		$this->content = json_encode($content);
		
	}

}