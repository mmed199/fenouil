<?php

namespace wpautoterms\legal_pages;

class Page {
	/**
	 * @var string, page id, define template with the same id (file name) if page is not paid.
	 */
	public $id;
	public $group;
	public $title;
	public $description;
	public $is_paid;

	public function __construct( $id, Group $group, $title, $description, $is_paid ) {
		$this->id = $id;
		$this->group = $group;
		$this->title = $title;
		$this->description = $description;
		$this->is_paid = $is_paid;
	}
}
