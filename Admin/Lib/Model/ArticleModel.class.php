<?php

class ArticleModel extends RelationModel
{
	protected $_link = array(
				'pl' => array(
				'mapping_type' => HAS_MANY,
				'class_name' => 'pl',
				'mapping_name' => 'pl',
				'foreign_key' => 'aid',
				'mapping_fields' => 'id',
				'as_fields' => 'id',
				),
				'mood' => array(
				'mapping_type' => HAS_ONE,
				'class_name' => 'mood',
				'mapping_name' => 'mood',
				'foreign_key' => 'aid',
				'mapping_fields' => 'id',
				'as_fields' => 'id',
				),
	);
}
?>