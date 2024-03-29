<?php
/* SVN FILE: $Id: Page.php 250 2009-11-28 01:47:43Z david@ramaboo.com $ */
/**
 * @brief Page class.
 * 
 * This class is used to create and manipulate pages.
 * 
 * @class		Boo_Page
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.8.4
 */

class Boo_Page {
	/**
	 * @brief Boo_Browser object.
	 * 
	 * This object is automatically initialized by the constructor
	 * if \c BOO_BROWSER is set to TRUE, otherwise \c $browser will be false.
	 */
	public $browser;
	
	/**
	 * @brief Boo_Dialog_MessageBox object.
	 * 
	 * This object is automatically initialized by the constructor. Message box will contain any success messages generated by the page.
	 */
	public $msgSuccess;
	
	/**
	 * @brief Boo_Dialog_MessageBox object.
	 * 
	 * This object is automatically initialized by the constructor. Message box will contain any error messages generated by the page.
	 */
	public $msgError;
	
	/**
	 * @brief Boo_Dialog_MessageBox object.
	 * 
	 * This object is automatically initialized by the constructor. Message box will contain any warning messages generated by the page.
	 */
	public $msgWarning;
	
	/**
	 * @brief Boo_Dialog_MessageBox object.
	 * 
	 * This object is automatically initialized by the constructor. Message box will contain any global messages generated by the page.
	 */
	public $msgGlobal;
	
	/**
	 * @brief Boo_User object.
	 * 
	 * This object is automatically initialized by the constructor. User represents the current user accessing the page.
	 */
	public $user;
	
	/**
	 * @brief Page template.
	 */
	protected $template = 'default';
	
	/**
	 * @brief Page specific CSS files.
	 */
	protected $pageJs = array();
	
	/**
	 * @brief Page specific JavaScript files.
	 */
	protected $pageCss = array();
	
	/**
	 * @breif Default constructor.
	 * 
	 * If the user is set a call to Boo_Page::setUser() is made with the supplied $user.
	 * 
	 * @param object $user[optional] The user. 
	 * @return void This function does not set a return value.
	 * 
	 */
	public function __construct($user = false) {
		// start session
		session_start();
		
		if (BOO_BROWSER) {
			if (class_exists('Browser', false) && BOO_CLASS) {
				$this->browser = new Browser;
			} else {
				$this->browser = new Boo_Browser;
			}
			
		} else {
			$this->browser = false;
		}
		
		if ($user) {
			// set user if it is passed in the constructor
			$this->setUser($user);
		} else {
			// setup default user
			if (class_exists('User', false) && BOO_CLASS) {
				$this->user = new User;
			} else {
				$this->user = new Boo_User;
			}
		}
		
		if (class_exists('Dialog_MessageBox', false) && BOO_CLASS) {
			$this->msgError = new Dialog_MessageBox;
			$this->msgWarning = new Dialog_MessageBox;
			$this->msgSuccess = new Dialog_MessageBox;
			$this->msgGlobal = new Dialog_MessageBox;
		} else {
			$this->msgError = new Boo_Dialog_MessageBox;
			$this->msgWarning = new Boo_Dialog_MessageBox;
			$this->msgSuccess = new Boo_Dialog_MessageBox;
			$this->msgGlobal = new Boo_Dialog_MessageBox;
		}
		
		$this->msgError->addClass('error');
		$this->msgError->setAttr('id', 'messagebox-error');
		$this->msgError->icon->setAttr('src', BOO_IMAGE_DIR_HTML . '/icons/messagebox-error.png');
		$this->msgError->icon->setAttr('alt', 'Message Box Error');
		$this->msgError->openSession();
		
		$this->msgWarning->addClass('warning');
		$this->msgWarning->setAttr('id', 'messagebox-warning');
		$this->msgWarning->icon->setAttr('src', BOO_IMAGE_DIR_HTML . '/icons/messagebox-warning.png');
		$this->msgWarning->icon->setAttr('alt', 'Message Box Warning');
		$this->msgWarning->openSession();
		
		$this->msgSuccess->addClass('success');
		$this->msgSuccess->setAttr('id', 'messagebox-success');
		$this->msgSuccess->icon->setAttr('src', BOO_IMAGE_DIR_HTML . '/icons/messagebox-success.png');
		$this->msgSuccess->icon->setAttr('alt', 'Message Box Success');
		$this->msgSuccess->openSession();
		
		$this->msgGlobal->addClass('global');
		$this->msgGlobal->setAttr('id', 'messagebox-global');
		$this->msgGlobal->icon->setAttr('src', BOO_IMAGE_DIR_HTML . '/icons/messagebox-global.png');
		$this->msgGlobal->icon->setAttr('alt', 'Message Box Global');
		$this->msgGlobal->openSession();
		
		// set user ID
		$userId = ((isset($_SESSION['boo_user_id'])) ? $_SESSION['boo_user_id'] : false);
		
		if ($userId) {
			// open user if possible
			$this->user->open($userId);
		}
	}
	
	/**
	 * @breif Sets the pages user.
	 * 
	 * This function is used to set the page user. The object should be of a type derived from Boo_User.
	 * It will overide the existing user. This is usefull if you want to extend the Boo_User object while retaning 
	 * the functionality of the Boo_Page object. This method is called by the constructor.
	 * 
	 * @see Boo_User::__construct()
	 * @param object $user The user. 
	 * @return bool Function always returns TURE.
	 * 
	 */
	private function setUser($user) { 
		$this->user = $user;
		return true;
	}
	
	/**
	 * @brief Returns the current user.
	 * @return object The user.
	 */
	public function getUser() { return $this->user; }
	
	/**
	 * @brief Redirects user to given URL.
	 * 
	 * @param string $url[optional] The URL to redirect to.
	 * 
	 * @return void This function will always exit after redirect.
	 */
	public function redirect($url = '/') {
		$url = urldecode($url);
		
		$parts = parse_url($url);
		if (isset($parts['scheme'])) {
			// absolute URL, don't mess with it
			$location = $url;
		} else {
			// relative URL
			if (substr($parts['path'], 0, 1) == '/') {
				// relative URL starting with a forward slash
				$location = BOO_SCHEME . '://' . BOO_DOMAIN . $parts['path'];
			} else {
				// relative URL without a forward slash
				// remove the trailing slash if present
				$dirname = rtrim(dirname($_SERVER['REQUEST_URI']), '/');
				
				// fix ../
				while (substr($parts['path'], 0, 3) == '../') {
					$dirname = dirname($dirname);
					$parts['path'] = substr($parts['path'], 3);
				}
				$dirname = rtrim($dirname, '/');
				
				$location = BOO_SCHEME . '://' . BOO_DOMAIN . $dirname . '/' . $parts['path'];
			}
			
			// add query
			if (isset($parts['query'])) {
				$location .= '?' . $parts['query'];
			}
			
			// add fragment
			if (isset($parts['fragment'])) {
				$location .= '#' . $parts['fragment'];
			}
			
		}
		
		session_write_close(); // close session
		
		//echo $location; // useful for debugging
		//pre_r($parts); // useful for debugging
		
		header('Location: ' . $location); // don't encode url
		exit(); // exit normaly
	}
	
	/**
	 * @brief Determins if page is a postback.
	 * @return bool Returns TRUE if page is a postback, FALSE otherwise.
	 */
	public function isPostback() { return !empty($_POST); }
	
	/**
	 * @brief Determins if the page is secured with SSL.
	 * @return bool Returns TRUE if page is secured with SSL, FALSE otherwise.
	 */
	public function isSsl() { return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'; }
	
	/**
	 * @brief Redirects users to the SSL version of the current page.
	 * 
	 * Function is ignored unless \c BOO_PRODUCTION is set to TRUE because SSL is rarely used 
	 * in development enviroments.
	 * 
	 * @return bool Returns TRUE if page is already secured with SSL.
	 */
	public function forceSsl() {
		if (BOO_PRODUCTION && BOO_SSL) {
			if (!$this->isSsl()) {
				$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$this->redirect($url);
			} else {
				return true;
			}
		} else {
			// only use SSL in production mode when BOO_SSL is enabled
			return true;
		}
	}
	
	public function setTemplate($template) {
		$template = trim($template);
		
		if (preg_match('/^[A-Za-z0-9-_\/]+$/', $template) && strlen($template) <= 255) { // allows forward slashes
			$this->template = $template;
		} else {
			trigger_error("Template {$template} is not valied", E_USER_ERROR);
			return false;
		}
		
	}
	
	public function getTemplate() { return $this->template; }
	
	/**
	 * @brief Checks if page is a given template
	 * 
	 * @param string $template The template to check.
	 * @return bool Returns TRUE if page is that template, FALSE otherwise.
	 * @todo Improve template support for child templates.
	 */
	public function isTemplate($template) {
		$template = trim($template);
		return $this->template == $template;
	}
	
	/**
	 * @brief Checks if page has a given template
	 * 
	 * @param string $template The template to check.
	 * @param int $position[optional] The required position of the template.
	 * @return bool Returns TRUE if page is that template, FALSE otherwise.
	 */
	public function hasTemplate($template, $position = false) {
		$template = trim($template);
		$templates = explode('/', $this->template);
		
		if ($position === false) {
			// no position
			foreach ($templates as $key => $value) {
				if ($value == $template) {
					return true;
				}
			}
		} else {
			if (isset($templates[$position]) && isset($templates[$position]) == $template) {
				return true;
			}
		}
		
		return false;
	}
	
	public function getTemplateJs() { return $this->template . '.js'; }
	
	public function htmlTemplateJs() {
		$tmp = "<!-- Begin Template JS -->\n"
			. "<script type=\"text/javascript\" charset=\"utf-8\" src=\"/js/common.js\"></script>\n";
		if ($this->template) {
			$templateJs =  $this->getTemplateJs();
			if (file_exists(BOO_WEBROOT_DIR . "/js/{$templateJs}")) {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"/js/{$templateJs}\"></script>\n";
			} // else do nothing
		}
		$tmp .= "<!-- End Template JS -->\n";
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	public function getTemplateCss() { return $this->template . '.css'; }
	
	public function htmlTemplateCss() {
		$tmp = "<!-- Begin Template CSS -->\n"
			. "<link rel=\"stylesheet\" href=\"/css/common.css\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" />\n";
			
		if ($this->template) {
			$templateCss =  $this->getTemplateCss();
			if (file_exists(BOO_WEBROOT_DIR . "/css/{$templateCss}")) {
				$tmp .= "<link rel=\"stylesheet\" href=\"/css/{$templateCss}\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" />\n";
			} // else do nothing
		}
		$tmp .= "<!-- End Template CSS -->\n";
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	/**
	 * @brief Creates conditional comments for IE.
	 * 
	 * Works with:
	 * \li IE 6 = /css/ie6.css
	 * \li IE 7 = /css/ie7.css
	 * \li IE 8 = /css/ie8.css
	 * 
	 * @return string Returns HTML conditional comments.
	 */
	public function htmlConditionalCss() {
			$tmp = "<!-- Begin Conditional CSS -->\n"
			. "<!--[if IE 6]><link rel=\"stylesheet\" href=\"/css/ie6.css\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" /><![endif]-->\n"
			. "<!--[if IE 7]><link rel=\"stylesheet\" href=\"/css/ie7.css\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" /><![endif]-->\n"
			. "<!--[if IE 8]><link rel=\"stylesheet\" href=\"/css/ie8.css\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" /><![endif]-->\n"
			. "<!-- End Conditional CSS -->\n";
			
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	public function htmlHeadAll() { 
		$tmp = '';
		$tmp .= $this->htmlBooJs();
		$tmp .= $this->htmlBooCss();
		$tmp .= $this->htmlPageJs();
		$tmp .= $this->htmlPageCss();
		$tmp .= $this->htmlTemplateJs();
		$tmp .= $this->htmlTemplateCss();
		$tmp .= $this->htmlConditionalCss();
		
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	
	/**
	 * @brief Adds a JavaScript file.
	 * 
	 * Added for API compatibility.
	 * 
	 * @since 2.0.0
	 * @see Boo_Page::addPageJs()
	 * @return bool Function always returns TRUE.
	 * @param string $src The source for the JavaScript file.
	 */
	public function addJs($src) { return $this->addPageJs($src); }
	
	/**
	 * @brief Adds a JavaScript file.
	 * 
	 * @since 2.0.0
	 * @return bool Function always returns TRUE.
	 * @param mixed $src The source for the JavaScript file or Boo_Html object.
	 */
	public function addPageJs($src) {
		
		if ($src instanceof Boo_Html) {
			$this->pageJs[] = $src;
		} else {
			$script = new Boo_Html_Script;
			$script->setAttr('src', $src);
			$this->pageJs[] = $script;
		}
		
		return true;
	}
	
	/**
	 * @brief Returns the page specific JavaScript tags.
	 * @return Boo_Html The page specific JavaScript tags.
	 */
	public function htmlPageJs() {
		if (empty($this->pageJs)) {
			return new Boo_Html_Empty;
		}
		$html = new Boo_Html(false);
		$html->appendContent("<!-- Begin Page JS -->\n");
		foreach ($this->pageJs as $key => $value) {
			$html->appendContent($value);
			$html->appendContent("\n");
		}
		$html->appendContent("<!-- End Page JS -->\n");
		
		return $html;
	}
	
	/**
	 * @brief Adds a CSS file.
	 * 
	 * Added for API compatibility.
	 * 
	 * @since 2.0.0
	 * @see Boo_Page::addPageCss()
	 * @return bool Function always returns TRUE.
	 * @param string $href The href for the CSS file.
	 * @param string $media[optional] The type of media for the CSS file.
	 */
	public function addCss($href, $media = 'screen') { return $this->addPageCss($href, $media); }
	
	/**
	 * @brief Adds a CSS file.
	 * 
	 * @since 2.0.0
	 * @return bool Function always returns TRUE.
	 * @param mixed $href The href for the CSS file or Boo_Html object.
	 * @param string $media[optional] The type of media for the CSS file.
	 */
	public function addPageCss($href, $media = false) {
		if ($href instanceof Boo_Html) {
			if ($media !== false) {
				$href->setAttr('media', $media);
			}
			$this->pageCss[] = $href;
			
		} else {
			$link = new Boo_Html_Link;
			if ($media !== false) {
				$link->setAttr('media', $media);
			}
			$link->setAttr('href', $href);
			$this->pageCss[] = $link;
		}
		return true;
	}
	
	/**
	 * @brief Returns the page specific CSS tags.
	 * @return Boo_Html The page specific CSS tags.
	 */
	public function htmlPageCss() {
		if (empty($this->pageCss)) {
			return new Boo_Html_Empty;
		}
		$html = new Boo_Html(false);
		$html->appendContent("<!-- Begin Page CSS -->\n");
		foreach ($this->pageCss as $key => $value) {
			$html->appendContent($value);
			$html->appendContent("\n");
		}
		$html->appendContent("<!-- End Page CSS -->\n");

		return $html;
	}
	
	public function htmlBooJs() {
		$tmp = "<!-- Begin Boo JS -->\n";
		if(BOO_PRODUCTION) {
			if (GOOGLE_AJAX) {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js\"></script>\n";
			} else {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/lib/jquery.min.js\"></script>\n";
			}
		} else {
			if (GOOGLE_AJAX) {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js\"></script>\n";
			} else {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/lib/jquery.js\"></script>\n";
			}
		}
		
		$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/functions.js\"></script>\n"
			. "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/jquery.boo.js\"></script>\n"
			. "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/jquery.fixIE6.js\"></script>\n"
			. "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/jquery.messageBox.js\"></script>\n"
			. "<script type=\"text/javascript\" charset=\"utf-8\" src=\"" . BOO_JS_DIR_HTML . "/jquery.xmlForm.js\"></script>\n";
		
		if (BOO_PI_DEBUGGER) {
			if (BOO_PRODUCTION) {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://pi-js.googlecode.com/files/pi.1.1.1.min.js\"></script>\n";
			} else {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://pi-js.googlecode.com/files/pi.1.1.1.js\"></script>\n";
			}
		}
		
		if (BOO_FIREBUG_LITE) {
			if (BOO_PRODUCTION) {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js\"></script>\n";
			} else {
				$tmp .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://getfirebug.com/releases/lite/1.2/firebug-lite.js\"></script>\n";
			}
		}
		
		$tmp .= "<!-- End Boo JS -->\n";
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	public function htmlBooCss() {
		$tmp = "<!-- Begin Boo CSS -->\n"
			. "<link rel=\"stylesheet\" href=\"" . BOO_CSS_DIR_HTML . "/boo.css.php\" charset=\"utf-8\" type=\"text/css\" media=\"screen\" />\n"
			. "<link rel=\"stylesheet\" href=\"" . BOO_CSS_DIR_HTML . "/print.css\" charset=\"utf-8\" type=\"text/css\" media=\"print\" />\n"
			. "<!-- End Boo CSS -->\n";
		$html = new Boo_Html(false);
		$html->setContent($tmp);
		return $html;
	}
	
	public function setTitle($title) {
		// no trim
		if ($title) {
			$this->title = $title;
			return true;
		} else {
			return false;
		}
	}
	
	public function getTitle() { return $this->title; }
	
	public function htmlTitle(array $attrs = array()) {
		$title = new Boo_Html_Title;
		$title->applyAttrs($attrs);
		$title->setContent($this->title);
		return $title;
	}
	
	/**
	 * @brief Returns IP address.
	 * 
	 * @return mixed Returns the current users IP address if available, FALSE otherwise.
	 */
	public static function getIp() {
		if (isset($_SERVER['HTTP_X_FORWARD_FOR']) && $_SERVER['HTTP_X_FORWARD_FOR']) {
			$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
		} else {
			$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
		}
		
		return $ip;
	}
	
	
	public function requireGroup($group) {
		if ($this->user->isInGroup("group")) {
			return true;
		} else {
			$this->msgSuccess->addMessage("You are not authorized to view this page.");
			$this->msgSuccess->saveSession();
			
			$url = $_SERVER['REQUEST_URI'];
			if ($url == '/') { $url = ''; } // remove slash 

			$this->redirect('/login/?url=' . urlencode($url));
			
			return false;
		}
	}
	
	/**
	 * @breif Sets the headers for no cache.
	 * 
	 * This is usefull when making AJAX requests.
	 * 
	 * @param string $contentLength The content length, defaults to not set. 
	 * @param string $contentType The content type, defaults to text/html.
	 * @param string $charset The charset, defaults to utf-8.
	 * @return bool Returns TURE if successful, FALSE otherwise.
	 * 
	 */
	public static function headerNoCache($contentLength = -1, $contentType = 'text/html', $charset = 'utf-8') {
		// check if content length is a positive integer or 0  
		if (ctype_digit((string) $contentLength)) {
			header('Content-Length: ' . $contentLength);
		} elseif ($contentLength == -1) {
			// default value used, do nothing
		} else {
			trigger_error("Content lenght {$contentLength} is not valid", E_USER_WARNING);
			return false;
		}
		
		Boo_Page::headerContentType($contentType, $charset);
		
		header('Expires: Mon, 26 Jul 1997 05:00:00');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
		header('Pragma: no-cache'); // HTTP/1.0
		return true;
	}
	
	/**
	 * @breif Sets the Content-Type header.
	 *
	 * This function is provided as a convenience.
	 * 
	 * @param string $contentType The content type, defaults to text/html.
	 * @param string $charset The charset, defaults to utf-8.  
	 * @return bool TURE if successful, FALSE otherwise.
	 * 
	 */
	public static function headerContentType($contentType = 'text/html', $charset = 'utf-8') {
		header("Content-Type: {$contentType}; charset={$charset}");
		return true;
	}
	
	/**
	 * @brief Logout user.
	 * 
	 * @param mixed $redirect[optional] Redirect user to default URL if TRUE or to the value of \a $redirect if not FALSE.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function logout($redirect = true) {
		if ($this->user->logout()) {
			$username = $this->user->getUsername();
			$this->msgSuccess->addMessage("Logout of user {$username} completed successfully.");
			$this->msgSuccess->saveSession();
			
			if ($redirect === true) {
				$url = '/login/';
			} else {
				$url = urldecode($redirect);
			}
			$this->redirect($url);
			return true;
		} else {
			if ($redirect !== true && $redirect) {
				$this->redirect(urldecode($redirect));
			}
			return false;
		}
	}
	
	/**
	 * @brief Login the user.
	 * 
	 * @param string $username[optional] The username. If it is not set then Boo_User::getUsername() will be used.
	 * @param string $password[optional] The password. If it is not set then Boo_User::getPassword() will be used.
	 * @param mixed $redirect[optional] Redirect user to default URL if TRUE or to the value of \a $redirect if not FALSE.
	 * 
	 * @return Returns TRUE if login was successful, FALSE otherwise.
	 */
	public function login($username = false, $password = false, $redirect = true) {
		if ($this->user->login($username, $password)) {
			if ($this->user->isStatusOK()) {
				$this->msgSuccess->addMessage("Login of user {$username} completed successfully.");
				$this->msgSuccess->saveSession();
				
				if ($redirect) {
					$url = "/user/{$username}/"; // default
					
					if (isset($_GET['url'])) {
						// redirect to the requested url
						$url = urldecode($_GET['url']);
					} elseif ($redirect !== true) {
						$url = urldecode($redirect);
					}
					$this->redirect($url);
				}
			
				return true;
			} else {
				switch ($this->user->getStatus()) {
					case BOO_STATUS_CLOSED:
						$this->msgError->addMessage('Your account is closed. You can not login.');
						$this->msgError->saveSession();
						break;
					case BOO_STATUS_SUSPENDED:
						$this->msgError->addMessage('Your account is suspended. If you believe this was in error please contact an administrator.');
						$this->msgError->saveSession();
						break;
					case BOO_STATUS_DISABLED:
						$this->msgError->addMessage('Your account is has been disabled by an administrator.');
						$this->msgError->saveSession();
						break;
					case BOO_STATUS_PENDING:
						$this->msgError->addMessage('Your account is currently pending review. You can not login until your account has be approved.');
						$this->msgError->saveSession();
						break;	
					case BOO_STATUS_UNKNOWN: default:
						$this->msgError->addMessage('Account status is unknown. Please contact an administrator.');
						$this->msgError->saveSession();
				}
				
				$this->user->logout();
				return false;
			}
		} else {
			// login failed
			$this->msgError->addMessage('Login failed, please try again.');
			$this->msgError->saveSession();
			
			
			if ($redirect !== true && $redirect) {
				$this->redirect(urldecode($redirect));
			}
			
			return false;
		}
	}
	/**
	 * @brief Require authorization.
	 * 
	 * @param mixed $redirect[optional] Redirect user to default URL if TRUE or to the value of \a $redirect if not FALSE.
	 * @return bool Returns TRUE if authorized, FALSE otherwise. If \a $redirect is FALSE and authorization fails program will exit.
	 */
	public function requireAuth($redirect = true) {
		// make sure the user is logged in
		if ($this->isAuth()) {
			if ($redirect !== true && $redirect) {
				$url = urldecode($redirect);
				$this->redirect($url);
			}
			return true;
		} else {
			$this->msgSuccess->addMessage('You are not authorized to view this page.');
			$this->msgSuccess->saveSession();
			
			if ($redirect) {
				if ($redirect === true) {
					// default
					$url = $_SERVER['REQUEST_URI'];
					if ($url == '/') { $url = ''; } // remove slash
					
					$url = '/login/?url=' . urlencode($url);
				} else {
					$url = urldecode($redirect);
				}
				
				//echo $url; // useful for debbugin
				$this->redirect($url);
				return false;
			} else {
				trigger_error('Authorization failed', E_USER_WARNING);
				exit('Authorization failed');
				return false;
			}
		}
	}
	
	
	/**
	 * @breif Determines if the user is authorized.
	 * 
	 * Provides a convenient API hook into the user object.
	 * 
	 * @return bool TURE if authorized, FALSE otherwise.
	 * 
	 */
	public function isAuth() { return $this->user->isAuth(); }
	

	public function allowGroup($groupId) {
		$groupId = (int) $groupId;
		if ($this->user->getGroupId() == $groupId) {
			// user is a member of the  group
			return true;
		} else {
			if ($this->user->isRoot()) {
				// root is always allowed
				return true;
			} else {
				$this->msgError->addMessage('You are not allowed to access this page.');
				$this->msgError->saveSession();
				$this->redirect();
				return false;
			}
		}
	}
	
	public function allowGroupEmpty() { return $this->allowGroup(BOO_GROUP_EMPTY); }
	
	public function allowGroupRoot() { return $this->allowGroup(BOO_GROUP_ROOT); }
	
	public function allowGroupAdmin() { return $this->allowGroup(BOO_GROUP_ADMIN); }
	
	public function allowGroupUser() { return $this->allowGroup(BOO_GROUP_USER); }
	
	public function allowGroupAnonymous() { return $this->allowGroup(BOO_GROUP_ANONYMOUS); }

	public function excludeGroup($groupId) {
		$groupId = (int) $groupId;
		if ($this->user->getGroupId() == $groupId) {
			if ($this->user->isRoot()) {
				// root is always allowed
				return true;
			} else {
				$this->msgError->addMessage('You are not allowed to access this page.');
				$this->msgError->saveSession();
				$this->redirect();
				return false;
			}
		} else {
			// user not a member of the group
			return true;
		}
	}
	
	public function excludeGroupEmpty() { return $this->excludeGroup(BOO_GROUP_EMPTY); }
	
	public function excludeGroupAdmin() { return $this->excludeGroup(BOO_GROUP_ADMIN); }
	
	public function excludeGroupUser() { return $this->excludeGroup(BOO_GROUP_USER); }
	
	public function excludeGroupAnonymous() { return $this->excludeGroup(BOO_GROUP_ANONYMOUS); }
	
	/**
	 * @brief Returns meta generator tag for Boo.
	 * @param array $attrs[optional] Array of attributes.
	 * @return Boo_Html_Meta The meta generator tag for Boo.
	 */
	public function htmlGeneratorMeta(array $attrs = array()) {
		$meta = new Boo_Html_Meta;
		$meta->applyAttrs($attrs);
		$meta->setAttr('name', 'generator');
		$meta->setAttr('content', 'Boo ' . BOO_VERSION);
		
		return $meta;
	}
}