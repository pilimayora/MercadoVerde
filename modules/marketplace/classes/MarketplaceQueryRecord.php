<?php
	class MarketplaceQueryRecord extends ObjectModel {
		public $id;
		public $from;
		public $to;
		public $description;
		public $id_query;
		
		public static $definition = array(
			'table' => 'query_records',
			'primary' => 'id',
			'fields' => array(
				'from' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'to' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'description' => array('type' => self::TYPE_STRING),
				'id_query' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			),
		);
		
	}
?>