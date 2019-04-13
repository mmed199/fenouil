<?php
/**
 * Multiple Select Customizer Control.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

/**
 * Multiple select customize control class.
 */
class ShopIsle_Customize_Control_Multiple_Select extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @var string
	 */

	public $type = 'multiple-select';

	/**
	 * Displays the multiple select on the customize screen.
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span
					class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
				foreach ( $this->choices as $value => $label ) {
					$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
					echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
				}
				?>
			</select>
		</label>
		<?php
	}
}
