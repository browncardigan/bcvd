<?php

class Site {
	
	private $_attributes;
	private $_db;
	private $_items_query;
	var $queries;
	
	function __construct() {
		$this->_attributes = false;
		$this->_db = false;
		$this->_items_query = "SELECT i.*";
	}

	function itemsTest() {
		/*
		// add OLD BC VIDEOS
		$videos = $this->_executeQuery("select * from bc_source", false);
		foreach ($videos as $v) {
			$item_id = $this->_db->insert('item', array('item_type_id' => 1, 'item_status_id' => 1, 'item_date_added' => $v['date_added']));
			if ($item_id) {
				$data = array(
					'item_id' 					=> $item_id, 
					'item_attribute_type_id' 	=> 2,
					'item_attribute_value'		=> $v['youtube_id'],
					'item_attribute_date_added'	=> $v['date_added']
				);
				$this->_db->insert('item_attribute', $data);
				echo 'added for ' . $v['youtube_id'] . '<br />';
			}
		}
		exit;
		*/
	}
	
	function itemsHome() {
		$this->_itemsQuery();
	 	$this->_items_query .= " WHERE i.item_status_id!=0 GROUP BY i.item_id ORDER BY i.item_date_added DESC LIMIT 20";
		return $this->_executeQuery($this->_items_query);
	}
	
	function itemsAll() {
		$this->_itemsQuery();
	 	$this->_items_query .= " GROUP BY i.item_id ORDER BY i.item_date_added DESC";
		return $this->_executeQuery($this->_items_query);
	}
	
	function itemsPopular() {
		$this->_items_query .= ", (i.item_view_count*(i.item_vote_count+1)) as item_popularity";
		$this->_itemsQuery();
	 	$this->_items_query .= " WHERE i.item_status_id!=0 AND i.item_view_count > 0 AND i.item_vote_count > 0 GROUP BY i.item_id ORDER BY item_popularity DESC LIMIT 20";
		return $this->_executeQuery($this->_items_query);
	}
	
	function itemVote($item_id=0) {
		return $this->_db->singleQuery('update item set item_vote_count=item_vote_count+1 WHERE item_id=' . $item_id);
	}
	
	function itemById($id=false) {
		if ($id) {
			$this->_itemsQuery();
		 	$this->_items_query .= " WHERE i.item_status_id!=0 AND i.item_id=" . $id . " GROUP BY i.item_id ";
			$this->_items_query .= "ORDER BY i.item_date_added DESC LIMIT 1";
			$items = $this->_executeQuery($this->_items_query);
			if (isset($items[0])) { return $items[0]; }
		}
		return false;
	}
	
	function itemBySlug($slug=false) {
		if ($slug) {
			$this->_itemsQuery();
		 	$this->_items_query .= " WHERE i.item_status_id!=0 ";
			$this->_items_query .= " GROUP BY i.item_id";
			$this->_items_query .= " HAVING attribute_slug=\"" . $slug . "\"";
			$this->_items_query .= " ORDER BY i.item_date_added DESC LIMIT 1";
			$items = $this->_executeQuery($this->_items_query);
			if (isset($items[0])) { return $items[0]; }
		}
		return false;
	}
	
	function itemsByCategorySlug($category_slug=false) {
		if ($category_slug) {
			$this->_items_query .= ", c.*";
			$this->_itemsQuery();
			$this->_items_query .= " LEFT JOIN category_item ci ON ci.item_id=i.item_id";
			$this->_items_query .= " LEFT JOIN category c ON c.category_id=ci.category_id";
			$this->_items_query .= " WHERE c.category_slug LIKE '" . $category_slug . "'";
			$this->_items_query .= " GROUP BY i.item_id ";
			$this->_items_query .= " ORDER BY i.item_date_added DESC";
			return $this->_executeQuery($this->_items_query);
		}
		return false;
	}
	
	function categoriesAll() {
		$query = "SELECT * FROM category ORDER BY category_name";
		return $this->_executeQuery($query);
	}
	
	// PRIVATE METHODS
	
	private function _itemsQuery($from=false) {
		if (!$this->_attributes) {
			$this->_attributes = $this->_executeQuery("SELECT * FROM item_attribute_type ORDER BY item_attribute_type_id", true);
		}
		if ($this->_attributes) {
			foreach ($this->_attributes as $attribute_id => $r) {
				$this->_items_query .= ", MAX(CASE WHEN item_attribute.item_attribute_type_id=" . $attribute_id;
				$this->_items_query .=" then item_attribute.item_attribute_value ELSE NULL END) as attribute_" . $r['item_attribute_type_name'];
			}
			$this->_items_query .= " FROM item i LEFT JOIN item_attribute ON (item_attribute.item_id = i.item_id)";
		}
	}
	
	private function _executeQuery($query=false, $map_primary_keys=false) {
		if (!$query) {
			return false;
		}
		if (!$this->_db) {
			include(ROOT_PATH . 'classes/Db.php');
			$this->_db = new Db;
			$this->_db->connect();
		}
		$this->queries[] = $query;
		return $this->_db->results($query, $map_primary_keys);
	}
	
	// GENERIC
	
	function redirect($url=false) {
		if ($url) {
			header('location: ' . $url);
			exit;
		}
		exit;
	}
	
	
	function debug($a) {
		echo '<pre>';
		print_r($a);
		echo '</pre>';
	}
	
	
}
	
	
?>