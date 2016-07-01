<?php

class SiteRender extends Site {
	
	var $_url;
	var $_url_orig;
	var $_method;
	var $html;
	
	function init() {
		$this->_url = false;
		$this->_method = $default_method = 'render404';
		$this->_parseURL();
		$this->_routesCheck();
		$this->_createMethod();
		$this->_render();
	}
	
	function render404() {
		echo '4040404';
	}
	
	function renderHome() {
		$res = $this->itemsTest();
		$this->debug($res);
	}
	
	function renderAll() {
		$res = $this->itemsAll();
		$this->debug($res);
	}
	
	function renderPopular() {
		$res = $this->itemsPopular();
		$this->debug($res);
	}
	
	function renderVideoPost() {
		if (isset($this->_url_orig[1])) {
			$item = $this->itemBySlug($this->_url_orig[1]);
			$this->debug($item);
		}
	}
	
	// private URLs
	
	// temp / todo: change to templates
	function _render() {
		ob_start();
		echo 'method: ' . $this->_method . '<br /><br />';
		if (method_exists($this, $this->_method)) {
			$m = $this->_method;
			$this->$m();
		}
		else {
			@$this->$default_method();
		}
		$this->html = ob_get_contents();
		ob_end_clean();
	}
	
	function _parseURL($set=true, $url=false) {
		if (!$url) {
			$url = isset($_GET['url']) ? $_GET['url'] : '';
		}
		$url = explode("/", $url);
		foreach ($url as $ukey => $u) {
			if ($u == '') { unset($url[$ukey]); }
		}
		if (count($url) == 0) {
			$url = array('home');
		}
		$url = array_values($url);
		if ($set) {
			$this->_url = $this->_url_orig = array_values($url);
		}
		else {
			return $url;
		}
	}
	
	function _routesCheck() {
		foreach ($GLOBALS['routes'] as $rkey => $r) {
			$rkey_array = $this->_parseURL(false, $rkey);
			$matched = 0;
			foreach ($rkey_array as $rkey2 => $r2) {
				if ($r2 != $this->_url[$rkey2] && $r2 != '*') {
					break;
				}
				else {
					$matched++;
				}
			}
			if ($matched == count($this->_url)) {
				$this->_url_orig = $this->_url;
				$this->_url = $r;
				break;
			}
		}
	}
	
	function _createMethod() {
		if ($this->_url) {
			$this->_method = 'render';
			foreach($this->_url as $u) {
				$this->_method .= ucwords($u);
			}
		}
	}
	
}

?>