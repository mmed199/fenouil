<?php

namespace wpautoterms\box;

use wpautoterms\admin\Menu;
use wpautoterms\frontend\Links;
use wpautoterms\option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Links_Box extends Box {

	public function define_options( $page_id, $section_id ) {
		new option\Checkbox_Option( $this->id(), __( 'Enabled', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		new option\Color_Option( $this->id() . '_bg_color', __( 'Background color', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		$a = new option\Choices_Combo_Option( $this->id() . '_font', __( 'Font', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		$a->set_values( Menu::fonts() );
		$a = new option\Choices_Combo_Option( $this->id() . '_font_size', __( 'Font size', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		$a->set_values( Menu::font_sizes() );
		new option\Color_Option( $this->id() . '_text_color', __( 'Text color', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		$a = new option\Choices_Option( $this->id() . '_text_align', __( 'Text alignment', WPAUTOTERMS_SLUG ),
			'', $page_id, $section_id );
		$a->set_values( array(
			' ' => __( 'default', WPAUTOTERMS_SLUG ),
			'center' => __( 'center', WPAUTOTERMS_SLUG ),
			'right' => __( 'right', WPAUTOTERMS_SLUG ),
			'left' => __( 'left', WPAUTOTERMS_SLUG ),
		) );
		new option\Color_Option( $this->id() . '_links_color', __( 'Links color', WPAUTOTERMS_SLUG ), '', $page_id, $section_id );
		new option\Text_Option( $this->id() . '_separator', __( 'Links separator', WPAUTOTERMS_SLUG ), '',
			$page_id, $section_id );
		new option\Checkbox_Option( $this->id() . '_target_blank', __( 'Links to open in a new page', WPAUTOTERMS_SLUG ),
			'', $page_id, $section_id );
		$this->_custom_css_options( $page_id, $section_id );
	}

	public function defaults() {
		return array(
			$this->id() => true,
			$this->id() . '_bg_color' => '#ffffff',
			$this->id() . '_font' => 'Arial, sans-serif',
			$this->id() . '_font_size' => '14px',
			$this->id() . '_text_color' => '#cccccc',
			$this->id() . '_text_align' => 'center',
			$this->id() . '_links_color' => '#000000',
			$this->id() . '_separator' => '-',
			$this->id() . '_target_blank' => false,
		);
	}

	protected function _class_hints() {
		return array(
			__( 'Links bar class:', WPAUTOTERMS_SLUG ) => '.'.Links::FOOTER_CLASS,
			__( 'Separator class:', WPAUTOTERMS_SLUG ) => '.'.Links::FOOTER_CLASS . ' .' . Links::SEPARATOR_CLASS,
			__( 'Link class:', WPAUTOTERMS_SLUG ) => '.'.Links::FOOTER_CLASS . ' a',
		);
	}
}
