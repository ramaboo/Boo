<?php
/* SVN FILE: $Id: Error.php 224 2009-04-14 22:50:37Z david@ramaboo.com $ */
/**
 * @brief Error class.
 * 
 * Used to handle PHP errors.
 * 
 * Error constant values:
 * \li \c E_ERROR = 1
 * \li \c E_WARNING = 2
 * \li \c E_PARSE = 4
 * \li \c E_NOTICE = 8
 * \li \c E_CORE_ERROR = 16
 * \li \c E_CORE_WARNING = 32
 * \li \c E_COMPILE_ERROR = 64
 * \li \c E_COMPILE_WARNING = 128
 * \li \c E_USER_ERROR = 256
 * \li \c E_USER_WARNING = 512
 * \li \c E_USER_NOTICE = 1024
 * \li \c E_ALL = 32767 in PHP 6, 30719 in PHP 5.3.x, 6143 in PHP 5.2.x
 * \li \c E_STRICT = 2048
 * \li \c E_RECOVERABLE_ERROR = 4096
 * \li \c E_DEPRECATED = 8192 since PHP 5.3.0
 * \li \c E_USER_DEPRECATED = 16384 since PHP 5.3.0
 * 
 * @class		Boo_Error
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.8.1
 */

class Boo_Error {
	/**
	 * @brief Domain name.
	 */
	protected $domain = BOO_DOMAIN;
	
	/**
	 * @brief Error number.
	 */
	protected $error = 0;
	
	/**
	 * @brief Error string.
	 */
	protected $errorString = '';
	
	/**
	 * @brief Filename.
	 */
	protected $filename = '';
	
	/**
	 * @brief Line number.
	 */
	protected $line = 0;
	
	/**
	 * @brief Symbols table as serialized data.
	 */
	protected $symbols = '';
	
	/**
	 * @brief Local copies of PHP superglobals as serialized data.
	 */
	protected $globals = '', $server = '', $get = '', $post = '', $files = '', $request = '', $session = '', $env = '', $cookie = '';
	
	/**
	 * @brief User agent.
	 */
	protected $userAgent = '';
	
	/**
	 * @brief IP Address.
	 */
	protected $ip = '';
	
	/**
	 * @brief Timestamp of error.
	 */
	protected $created = 0;
	
	/**
	 * @brief Error UUID.
	 */
	protected $uuid = '';
	
	/**
	 * @brief Default constructor.
	 * 
	 * Copies superglobals to the class instance and serializes them.
	 * 
	 * @see http://us3.php.net/reserved.variables
	 * @return void.
	 */
	public function __construct() {
		
		// keeps PDO happy
		try {
			if (isset($GLOBALS)) {
				$globals = serialize($GLOBALS);
				$this->globals = $globals;
			} else {
				$this->globals = '';
			}
		} catch (Exception $e) {
			$this->globals = '';
		}
		
		if (isset($_SERVER)) {
			$server = serialize($_SERVER);
			$this->server = $server;
		} else {
			$this->server = '';
		}
		
		if (isset($_GET)) {
			$get = serialize($_GET);
			$this->get = $get;
		} else {
			$this->get = '';
		}
		
		if (isset($_POST)) {
			$post = serialize($_POST);
			$this->post = $post;
		} else {
			$this->post = '';
		}
		
		if (isset($_FILES)) {
			$files = serialize($_FILES);
			$this->files = $files;
		} else {
			$this->files = '';
		}
		
		if (isset($_REQUEST)) {
			$request = serialize($_REQUEST);
			$this->request = $request;
		} else {
			$this->request = '';
		}
		
		if (isset($_SESSION)) {
			$session = serialize($_SESSION);
			$this->session = $session;
		} else {
			$this->session = '';
		}
		
		if (isset($_ENV)) {
			$env = serialize($_ENV);
			$this->env = $env;
		} else {
			$this->env = '';
		}
		
		if (isset($_COOKIE)) {
			$cookie = serialize($_COOKIE);
			$this->cookie = $cookie;
		} else {
			$this->cookie = '';
		}
		
		$this->created = time();
		
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$this->userAgent = '';
		}
		
		$this->ip = Boo_Page::getIp();
		$this->uuid = Boo_Helper::getUuid();
	}
	
	public function setError($error, $errorString, $filename, $line, $symbols) {
		$this->error = (int) $error;
		$this->errorString = trim($errorString);
		$this->filename = trim($filename);
		$this->line = trim($line);
		
		// fixes errors serializing stack traces
		try {
			$this->symbols = serialize($symbols);
		} catch (Exception $e) {
			$this->symbols = serialize($e->getTraceAsString());
			
		}
		
		// as of php 5.2.0 return FALSE to populate $phpErrormsg
		return !BOO_DEBUG;;
	}
	
	public function getDomain() { return $this->domain; }
	
	public function getError() { return $this->error; }
	
	public function getErrorString() { return $this->errorString; }
	
	public function getFilename() { return $this->filename; }
	
	public function getLine() { return $this->line; }
	
	public function getSymbols() { return $this->symbols; }
	
	public function getGlobals() { return $this->globals; }
	
	public function getServer() { return $this->server; }
	
	public function getGet() { return $this->get; }
	
	public function getPost() { return $this->post; }
	
	public function getFiles() { return $this->files; }
	
	public function getCookie() { return $this->cookie; }
	
	public function getSession() { return $this->session; }
	
	public function getRequest() { return $this->request; }
	
	public function getEnv() { return $this->env; }
	
	public function getUserAgent() { return $this->userAgent; }
	
	public function getIp() { return $this->ip; }
	
	public function getCreated() { return $this->created; }
	
	public function getUuid() { return $this->uuid; }
	
	public static function getErrorName($error) {
		$error = (int) $error;
		switch ($error) {
			case E_ERROR:
				$errorName = 'E_ERROR';
				break;
				
			case E_WARNING:
				$errorName = 'E_WARNING';
				break;
				
			case E_PARSE:
				$errorName = 'E_PARSE';
				break;
				
			case E_NOTICE:
				$errorName = 'E_NOTICE';
				break;
				
			case E_CORE_ERROR:
				$errorName = 'E_CORE_ERROR';
				break;
				
			case E_CORE_WARNING:
				$errorName = 'E_CORE_WARNING';
				break;
				
			case E_COMPILE_ERROR:
				$errorName = 'E_COMPILE_ERROR';
				break;
				
			case E_COMPILE_WARNING:
				$errorName = 'E_COMPILE_WARNING';
				break;
				
			case E_USER_ERROR:
				$errorName = 'E_USER_ERROR';
				break;
				
			case E_USER_WARNING:
				$errorName = 'E_USER_WARNING';
				break;
				
			case E_USER_NOTICE:
				$errorName = 'E_USER_NOTICE';
				break;
				
			case E_ALL:
				$errorName = 'E_ALL';
				break;
				
			case E_STRICT:
				$errorName = 'E_STRICT';
				break;
				
			case E_RECOVERABLE_ERROR:
				$errorName = 'E_RECOVERABLE_ERROR';
				break;
				
			case E_DEPRECATED:
				$errorName = 'E_DEPRECATED';
				break;
				
			case E_USER_DEPRECATED:
				$errorName = 'E_USER_DEPRECATED';
				break;
				
			default: // unknown error
				$errorName = 'UNKNOWN_' . $error;
		}
		return $errorName;
	}
	
	public function dbError(array $ignore = array(), $tableName = 'boo_errors', $primaryKey = 'error_id') {
		if (!empty($ignore) && in_array($this->error, $ignore)) {
			return true; // ignoring
		}
		
		$io = new Boo_Io($tableName, $primaryKey);
		
		$io->setField('created', $this->created);
		$io->setField('modified', time());
		$io->setField('domain', $this->domain);
		$io->setField('uuid', $this->uuid);
		$io->setField('ip', $this->ip);
		$io->setField('error', $this->error);
		$io->setField('error_string', $this->errorString);
		$io->setField('filename', $this->filename);
		$io->setField('line', $this->line);
		$io->setField('symbols', $this->symbols);
		$io->setField('globals', $this->globals);
		$io->setField('server', $this->server);
		$io->setField('get', $this->get);
		$io->setField('post', $this->post);
		$io->setField('files', $this->files);
		$io->setField('cookie', $this->cookie);
		$io->setField('request', $this->request);
		$io->setField('session', $this->session);
		$io->setField('env', $this->env);
		
		$io->save();
		return true;
	}
	
	public function logError(array $ignore = array(), $filename = BOO_ERROR_LOG_FILE) {
		if (!empty($ignore) && in_array($this->error, $ignore)) {
			return true; // ignoring
		}
		
		if (file_exists($filename)) {
			$time = date('c', $this->created);
			$errorName = self::getErrorName($this->error);
			
			$content = "{$time}|"
				. "{$this->domain}|"
				. "{$this->uuid}|"
				. "{$this->ip}|"
				. "{$errorName}|"
				. "{$this->errorString}|"
				. "{$this->filename}|"
				. "{$this->line}|"
				. "{$this->symbols}|"
				. "{$this->globals}|"
				. "{$this->server}|"
				. "{$this->get}|"
				. "{$this->post}|"
				. "{$this->files}|"
				. "{$this->cookie}|"
				. "{$this->session}|"
				. "{$this->request}|"
				. "{$this->env}";
			
			return Boo_Log::write($content, $filename);
		} else {
			trigger_error("File {$filename} does not exist", E_USER_ERROR);
			return false;
		}
	}
	
	public function emailError(array $ignore = array()) {
		if (!empty($ignore) && in_array($this->error, $ignore)) {
			return true; // ignoring
		}
		
		$errorName = self::getErrorName($this->error);
		$time = date('c', $this->created);
		
		$body = "Time: {$time}\n"
			. "Domain: {$this->domain}\n"
			. "Error UUID: {$this->uuid}\n"
			. "IP Address: {$this->ip}\n"
			. "Error: {$errorName}\n"
			. "Error String: {$this->errorString}\n"
			. "Filename: {$this->filename}\n"
			. "Line: {$this->line}\n"
			. "Symbols: {$this->symbols}\n"
			. "\$GLOBALS: {$this->globals}\n"
			. "\$_SERVER: {$this->server}\n"
			. "\$_GET: {$this->get}\n"
			. "\$_POST: {$this->post}\n"
			. "\$_FILES: {$this->files}\n"
			. "\$_COOKIE: {$this->cookie}\n"
			. "\$_SESSION: {$this->session}\n"
			. "\$_REQUEST: {$this->request}\n"
			. "\$_ENV: {$this->env}\n";
		
		$send = false;
		try {
			$smtp = new Swift_Connection_SMTP(BOO_SMTP_SERVER, BOO_SMTP_PORT, BOO_SMTP_ENC);
			$smtp->setUsername(BOO_SMTP_USERNAME);
			$smtp->setPassword(BOO_SMTP_PASSWORD);
			
			// start swift 
			$swift = new Swift($smtp);
			
			$swiftMessage = new Swift_Message("{$errorName}: {$this->errorString} in {$this->filename} on line {$this->line}", $body);
			
			$recipients = new Swift_RecipientList();
			$recipients->addTo(BOO_ERROR_EMAIL);
			
			$send = $swift->send($swiftMessage, $recipients, BOO_FROM_EMAIL);
			
			$swift->disconnect();
		} catch (Exception $e) {
			echo $e->getMessage();
			// do nothing
			return false;
		}
		return $send;
	}
	
	public function smsError(array $ignore = array()) {
		if (!empty($ignore) && in_array($this->error, $ignore)) {
			return true; // ignoring
		}
		
		$errorName = self::getErrorName($this->error);
		
		$sms = new Boo_SMS;
		$sms->setPhoneNumber(BOO_SMS_PHONE_NUMBER);
		$sms->setCarrierId(BOO_SMS_CARRIER_ID);
		$sms->setSubject($errorName);
		
		$body = substr($this->filename, -20) // last 20 characters of file name
			. " {$this->line} " // add line number
			. substr($this->errorString, 0, 80); // first 80 characters of error message
		
		$sms->setBody($body);
		$sms->send();
		
		return true;
	}
	
	public function htmlErrorDiv(array $attrs = array()) {
		$tmp = '';
		$errorName = self::getErrorName($this->error);
		$time = date('c', $this->created);
		
		if (BOO_DEBUG) {
			$tmp .= "<p><b>Time</b>: {$time}</p>\n"
				. "<p><b>Domain</b>: {$this->domain}</p>\n"
				. "<p><b>Error UUID</b>: {$this->uuid}</p>\n"
				. "<p><b>IP Address</b>: {$this->ip}</p>\n";
		}
		
		$tmp .= "<p><b>Error</b>: {$errorName}</p>\n"
			. "<p><b>Error String</b>: {$this->errorString}</p>\n"
			. "<p><b>Filename</b>: {$this->filename}</p>\n"
			. "<p><b>Line</b>: {$this->line}</p>\n";
		
		if (BOO_DEBUG) {
			$tmp .= '<p><b>Symbols</b>: (<a href="#" id="boo-error-symbols">show</a>)'
				. '<pre id="boo-error-symbols-code" style="display: none;">' . print_r(@unserialize($this->symbols), true) . "</pre></p>\n"
				
				. '<p><b>$GLOBALS</b>: (<a href="#" id="boo-error-globals">show</a>)'
				. '<pre id="boo-error-globals-code" style="display: none;">' . print_r(@unserialize($this->globals), true) . "</pre></p>\n"
				
				. '<p><b>$_SERVER</b>: (<a href="#" id="boo-error-server">show</a>)'
				. '<pre id="boo-error-server-code" style="display: none;">' . print_r(@unserialize($this->server), true) . "</pre></p>\n"
				
				. '<p><b>$_GET</b>: (<a href="#" id="boo-error-get">show</a>)'
				. '<pre id="boo-error-get-code" style="display: none;">' . print_r(@unserialize($this->get), true) . "</pre></p>\n"
				
				. '<p><b>$_POST</b>: (<a href="#" id="boo-error-post">show</a>)'
				. '<pre id="boo-error-post-code" style="display: none;">' . print_r(@unserialize($this->post), true) . "</pre></p>\n"
				
				. '<p><b>$_FILES</b>: (<a href="#" id="boo-error-files">show</a>)'
				. '<pre id="boo-error-files-code" style="display: none;">' . print_r(@unserialize($this->files), true) . "</pre></p>\n"
				
				. '<p><b>$_COOKIE</b>: (<a href="#" id="boo-error-cookie">show</a>)'
				. '<pre id="boo-error-cookie-code" style="display: none;">' . print_r(@unserialize($this->cookie), true) . "</pre></p>\n"
				
				. '<p><b>$_SESSION</b>: (<a href="#" id="boo-error-session">show</a>)'
				. '<pre id="boo-error-session-code" style="display: none;">' . print_r(@unserialize($this->session), true) . "</pre></p>\n"
				
				. '<p><b>$_REQUEST</b>: (<a href="#" id="boo-error-request">show</a>)'
				. '<pre id="boo-error-request-code" style="display: none;">' . print_r(@unserialize($this->request), true) . "</pre></p>\n"
				
				. '<p><b>$_ENV</b>: (<a href="#" id="boo-error-env">show</a>)'
				. '<pre id="boo-error-env-code" style="display: none;">' . print_r(@unserialize($this->env), true) . "</pre></p>\n"
				
				// add JavaScript file that handles show/hide
				. "<script type=\"text/javascript\">\n"
				. file_get_contents(BOO_JS_DIR . '/error-html.js')
				. "\n</script>\n";
		}
		
		$div = new Boo_Html('div');
		$div->applyAttrs($attrs);
		$div->setClass('error');
		$div->setContent($tmp);
		
		return $div;
	}
/*	
	public function htmlBugReportForm() {
		$tmp = '';
		$tmp .= "<fieldset class=\"clearfix\">";
		$tmp .= "<input type=\"hidden\" name=\"uuid\" id=\"uuid\" value=\"{$this->uuid}\"/>";
		$tmp .= "<ol class=\"clearfix\">";
		$tmp .= "<li><label>Name <em class=\"required\">*</em></label><input id=\"name\" name=\"name\" type=\"text\"/></li>";
		$tmp .= "<li><label>Email Address <em class=\"required\">*</em> <span>Your email is safe, we <a href=\"/spam/\">hate spam</a>!</span></label><input id=\"email\" name=\"email\" type=\"text\"/></li>";
		$tmp .= "<li><label>Description <em class=\"required\">*</em> <span>Please tell us what went wrong.</span></lable><textarea id=\"description\" name=\"description\" rows=\"10\" cols=\"50\"></textarea></li>";
		$tmp .= "<li><span class=\"label\">Unique Id <span>Your report reference number.</span></span><p>{$this->uuid}</p></li>";
		$tmp .= "<li><label><input id=\"notify\" name=\"notify\" type=\"checkbox\" value=\"yes\"/>Notify me when a resolution is available.</lable></li>";
		$tmp .= "<li><input type=\"submit\" class=\"button-submit button\" value=\"Submit\"/></li>";
		$tmp .= "<li><p>You can also email bug reports to <a class=\"email\" href=\"mailto:" . BOO_BUGREPORT_EMAIL . "?subject=Bug Report {$this->uuid}\">" . BOO_BUGREPORT_EMAIL . "</a>.</p></li>";
		$tmp .= "</ol></fieldset>";
		
		$form = new Boo_Html_Form;
		$form->setAttr('id', 'bugreport');
		$form->setContent($tmp);
		
		return $form;
	}
	
	public function handleBugReportForm() {
		$name = _post('name');
		$email = _post('email');
		
		$uuid = _post('uuid');
		$description = _post('description');
		$notify = (isset($_POST['notify'])) ? 'yes' : 'no';
		$time = date('c', $this->created);
		
		$body = '';
		$body .= "Time: {$time}\n";
		$body .= "Domain: {$this->domain}\n";
		$body .= "Report UUID: {$uuid}\n";
		$body .= "IP Address: {$this->ip}\n";
		$body .= "Name: {$name}\n";
		$body .= "Email: {$email}\n";
		$body .= "Descriptoin: {$description}\n";
		$body .= "Notify: {$notify}\n";
		$body .= "User Agent: {$this->userAgent}\n";
		
		try {
			$smtp = new Swift_Connection_SMTP(BOO_SMTP_SERVER, BOO_SMTP_PORT, BOO_SMTP_ENC);
			$smtp->setUsername(BOO_SMTP_USERNAME);
			$smtp->setPassword(BOO_SMTP_PASSWORD);
			
			// start swift 
			$swift = new Swift($smtp);
			$swiftMessage = new Swift_Message("Bug Report for {$this->domain} {$this->uuid}", $body);
			
			$recipients = new Swift_RecipientList();
			$recipients->addTo(BOO_BUGREPORT_EMAIL);
			
			$send = $swift->send($swiftMessage, $recipients, BOO_FROM_EMAIL);
			
			$swift->disconnect();
		} catch (Exception $e) {
			// do nothing
			return false;
		}
		
		return true;
	}
	*/
	
	/**
	 * @brief Determins if an error is critical.
	 * 
	 * Errors that are \b not considered critical:
	 * \li E_NOTICE
	 * \li E_USER_NOTICE
	 * \li E_USER_WARNING
	 * \li E_DEPRECATED
	 * \li E_USER_DEPRECATED
	 * \li E_ALL
	 * 
	 * Errors that are considered critical:
	 * \li E_ERROR
	 * \li E_WARNING
	 * \li E_PARSE
	 * \li E_CORE_ERROR
	 * \li E_CORE_WARNING
	 * \li E_COMPILE_WARNING
	 * \li E_COMPILE_ERROR
	 * \li E_USER_ERROR
	 * \li E_STRICT
	 * \li E_RECOVERABLE_ERROR
	 * 
	 * @param int $error The error code.
	 * @return bool Returns TRUE if error is critical, FALSE othereise.
	 */
	public static function isCritical($error) {
		$error = (int) $error;
		switch ($error) {
			// not critical
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_USER_WARNING:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
			case E_ALL:
				return false;
				break;
			// critical
			case E_ERROR:
			case E_WARNING:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_CORE_WARNING:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
			case E_USER_ERROR:
			case E_STRICT:
			case E_RECOVERABLE_ERROR:
			default: // unknown error
				return true;
		}
		// function can never reach this point
	}
	
	public function handleError($error, $errorString, $filename, $line, $symbols) {
		$result = $this->setError($error, $errorString, $filename, $line, $symbols);
		
		if (BOO_PRODUCTION) {
			if (self::isCritical($this->error)) {
				if (BOO_SMS_PHONE_NUMBER && BOO_SMS_CARRIER_ID && BOO_SMS_ERROR) {
					$this->smsError();
				}
				$this->emailError();
			}
			
			$this->dbError();
		} else {
			echo $this->htmlErrorDiv();
		}
		
		return $result;
	}
	
	/**
	 * @brief Automaticly setup error handing to default settings.
	 * 
	 * @return string Returns the result of \c set_error_handler().
	 * @see http://us.php.net/set_error_handler
	 * @param int $errorTypes[optional] Can be used to mask the triggering of Boo_Error::errorHandlerCallback().
	 */
	public static function start($errorTypes = false) {
		if ($errorTypes === false) {
			$errorTypes = ini_get('error_reporting');
		}

		return set_error_handler(array('Boo_Error', 'errorHandlerCallback'), $errorTypes);
	}
	
	/**
	 * @brief Error handler callback method.
	 * 
	 * @param int $error Error level.
	 * @param string $errorString Error message.
	 * @param string $filename Filename that caused the error.
	 * @param string $line The line number
	 * @param array $symbols The active symbols table.
	 * @return bool Function always returns FALSE.
	 */
	public static function errorHandlerCallback($error, $errorString, $filename, $line, $symbols) {
		$booError = new Boo_Error();
		$booError->handleError($error, $errorString, $filename, $line, $symbols);

		// as of php 5.2.0 return FALSE to populate $phpErrormsg
		return !BOO_DEBUG;
	}
}