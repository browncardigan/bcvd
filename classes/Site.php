<?php

/*
SELECT  p.ID,   
        p.post_title, 
        MAX(CASE WHEN item_attribute.item_attribute_type_id = 'first_field' then item_attribute.item_attribute_value ELSE NULL END) as first_field,
        MAX(CASE WHEN item_attribute.item_attribute_type_id = 'second_field' then item_attribute.item_attribute_value ELSE NULL END) as second_field,
        MAX(CASE WHEN item_attribute.item_attribute_type_id = 'third_field' then item_attribute.item_attribute_value ELSE NULL END) as third_field,

 FROM    wp_posts p LEFT JOIN wp_postmeta pm1 ON ( pm1.post_id = p.ID)                      
GROUP BY
   wp_posts.ID,wp_posts.post_title

*/
	

class Site {
	
	private $_db;
	private $_items_query;
	
	function __construct() {
		$this->_db = false;
		$this->_items_query = "SELECT i.*";
	}

	
	function itemsTest() {
		$this->_itemsQuery();
	 	$this->_items_query .= " FROM item i LEFT JOIN item_attribute ON (item_attribute.item_id = i.item_id) GROUP BY i.item_id ORDER BY i.item_date_added DESC";
		return $this->_executeQuery($this->_items_query);
	}
	
	function itemsPopular() {
		
	}
	
	
	
	
	// PRIVATE METHODS
	
	private function _itemsQuery() {
		$res = $this->_executeQuery("SELECT * FROM item_attribute_type ORDER BY item_attribute_type_id", true);
		foreach ($res as $attribute_id => $r) {
			$this->_items_query .= ", MAX(CASE WHEN item_attribute.item_attribute_type_id=" . $attribute_id;
			$this->_items_query .=" then item_attribute.item_attribute_value ELSE NULL END) as " . $r['item_attribute_type_name'];
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
		echo $query;
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