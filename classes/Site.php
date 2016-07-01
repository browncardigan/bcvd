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
		$this->_itemsQuery();
	 	$this->_items_query .= " WHERE i.item_status_id!=0 GROUP BY i.item_id ORDER BY i.item_date_added DESC";
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
	 	$this->_items_query .= " WHERE i.item_status_id!=0 GROUP BY i.item_id ORDER BY item_popularity DESC";
		return $this->_executeQuery($this->_items_query);
	}
	
	function itemBySlug($slug=false) {
		if ($slug) {
			$this->_itemsQuery();
		 	$this->_items_query .= " WHERE i.item_status_id!=0 ";
			$this->_items_query .= "GROUP BY i.item_id ";
			$this->_items_query .= "HAVING attribute_slug=\"" . $slug . "\" ";
			$this->_items_query .= "ORDER BY i.item_date_added DESC LIMIT 1";
			$items = $this->_executeQuery($this->_items_query);
			if (isset($items[0])) { return $items[0]; }
		}
		return false;
	}
	
	// PRIVATE METHODS
	
	private function _itemsQuery() {
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
	
	function debug($a) {
		echo '<pre>';
		print_r($a);
		echo '</pre>';
	}
	
	
	
}
	
	
?>