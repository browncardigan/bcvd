<?php

class SiteRender extends Site {
	
	var $_url;
	var $_url_orig;
	var $_method;
	var $html;
	var $data;
	
	function init() {
		$this->_url = false;
		$this->_method = 'render404';
		$this->_parseURL();
		$this->_routesCheck();
		$this->_createMethod();
		$this->_render();
	}

	function renderHome() {
		$this->data['videos'] = $this->itemsHome();
	}
	
	function renderAll() {
		$this->data['videos'] = $this->itemsAll();
	}
	
	function renderPopular() {
		$this->data['videos'] = $this->itemsPopular();
	}
	
	function renderVideoPost() {
		if (isset($this->_url_orig[1])) {
			if (strstr($this->_url_orig[1], 'item-id-')) {
				$this->data['video'] = $this->itemById(str_replace('item-id-', '', $this->_url_orig[1]));
			}
			else {
				$this->data['video'] = $this->itemBySlug($this->_url_orig[1]);
			}
			$this->data['video']['title'] = $this->_videoTitle($this->data['video']);
			$this->data['video']['permalink'] = $this->_videoPermalink($this->data['video']);
			$this->data['video']['video_file'] = $this->_videoFile($this->data['video']);
			$this->data['video']['video_image'] = $this->_videoImage($this->data['video']);
		}
		else {
			// 404 // todo
		}
	}
	
	function renderVideoVote() {
		$this->renderVideoPost();
		$this->itemVote($this->data['video']['item_id']);
		$this->redirect($this->data['video']['permalink']);
	}
	
	function renderChannels() {
		$this->data['channels'] = $this->categoriesAll();
	}
	
	function renderChannel() {
		if (isset($this->_url_orig[1])) {
			$videos = $this->itemsByCategorySlug($this->_url_orig[1]);
			if ($videos) {
				$this->data['videos'] = $videos;
				$first_video = current($videos);
				$this->data['category_name'] = $first_video['category_name'];
			}
		}
		else {
			$this->redirect(WWW_PATH . 'channels/');
		}
	}
	
	// ------------------------------------------------------------------------------------------------
	// renderElements
	
	function renderElement($element=false, $data=false) {
		$method = 'renderElement' . str_replace(' ', '', ucwords(str_replace('_', ' ', $element)));
		if (method_exists($this, $method)) {
			$data = $this->$method($data);
		}
		@include(TEMPLATE_PATH . 'elements/' . $element . '.php');
	}
	
	function renderElementVideoList($data=false) {
		$data['title'] = $this->_videoTitle($data);
		$data['permalink'] = $this->_videoPermalink($data);
		$data['video_image'] = $this->_videoImage($data);
		return $data;
	}
	
	// ------------------------------------------------------------------------------------------------
	// PRIVATE URLS
	
	// re-used formatters
	
	function _videoTitle($data=false) {
		$title = isset($data['attribute_title']) && $data['attribute_title'] != '' ? $data['attribute_title'] : 'Untitled Video #' . $data['item_id'];
		return $title;
	}
	
	function _videoPermalink($data=false) {
		$permalink = WWW_PATH . 'video/';
		$permalink .= (isset($data['attribute_slug']) && $data['attribute_slug'] != '' ? $data['attribute_slug'] : 'item-id-' . $data['item_id']) . '/';
		return $permalink;
	}
	
	function _videoFile($data=false) {
		$video_file = false;
		if ($data['attribute_video_file'] != '') {
			$video_file = VIDEO_PATH . $data['attribute_video_file'];
		}
		else if ($data['attribute_youtube_id'] != '') {
			$video_file = '//www.youtube.com/watch?v=' . $data['attribute_youtube_id'];
		}
		return $video_file;
	}
	
	function _videoImage($data=false) {
		$video_image = false;
		if ($data['attribute_image'] == '') {
			if ($data['attribute_youtube_id'] != '') {
				$video_image = WWW_PATH . 'assets/farm/youtube/' . $data['attribute_youtube_id'] . '-thumb.jpg';  
			}
		}
		else {
			$video_image = IMAGE_PATH . str_replace(".", "-thumb.", $data['attribute_image']);
		}
		return $video_image;
	}
	
	// ------------------------------------------------------------------------------------------------
	// controls
	
	function _render() {
		ob_start();
		if (method_exists($this, $this->_method)) {
			$m = $this->_method;
			$this->$m();
		}
		else {
			$this->_url = array('404');
		}
		
		$template = TEMPLATE_PATH . implode('_', $this->_url) . '.php';
		if (file_exists($template)) {
			$data = $this->data;
			include($template);
		}
		else {
			@include($template);
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