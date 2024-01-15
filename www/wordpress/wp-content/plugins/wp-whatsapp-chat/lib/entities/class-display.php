<?php
namespace QuadLayers\QLWAPP\Entities;

use QuadLayers\QLWAPP\Models\Display_Component;
use QuadLayers\WP_Orm\Entity\SingleEntity;

class Display extends SingleEntity {
	public $devices;
	public $entries;
	public $taxonomies;
	public $target;


	public function __construct() {
		$args = Display_Component::instance()->get_args();

		$this->devices    = $args['devices'];
		$this->entries    = $args['entries'];
		$this->taxonomies = $args['taxonomies'];
		$this->target     = $args['target'];
	}
}
