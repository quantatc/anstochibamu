<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour Contacts Widget.
 *
 * @since 1.0
 */

class Myour_Contacts_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-contacts';
	}

	public function get_title() {
		return esc_html__( 'Contacts', 'myour-plugin' );
	}

	public function get_icon() {
		return 'fas fa-headset';
	}

	public function get_categories() {
		return [ 'myour-category' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'heading_tab',
			[
				'label' => esc_html__( 'Title & Subtitle', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'myour-plugin' ),
				'default'     => esc_html__( 'Title', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Title Tag', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => __( 'H1', 'myour-plugin' ),
					'h2' => __( 'H2', 'myour-plugin' ),
					'div' => __( 'DIV', 'myour-plugin' ),
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter subtitle', 'myour-plugin' ),
				'default'     => esc_html__( 'Subtitle', 'myour-plugin' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'contact_form_tab',
			[
				'label' => esc_html__( 'Contact Form', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'contact_form',
			[
				'label' => esc_html__( 'Select CF7 Form', 'myour-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 1,
				'options' => $this->contact_form_list(),
			]
		); 

		$this->end_controls_section();

		$this->start_controls_section(
			'contact_info_tab',
			[
				'label' => esc_html__( 'Contact Information', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'contact_name',
			[
				'label'       => esc_html__( 'Name', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Name', 'myour-plugin' ),
				'default'     => esc_html__( 'Joe Wilson', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'contact_position',
			[
				'label'       => esc_html__( 'Position', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Position', 'myour-plugin' ),
				'default'     => esc_html__( 'Consultant & Mentor', 'myour-plugin' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label', [
				'label'       => esc_html__( 'Label', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter label', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter label', 'myour-plugin' ),
			]
		);

		$repeater->add_control(
			'value', [
				'label'       => esc_html__( 'Value', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter value', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter value', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'contact_info',
			[
				'label' => esc_html__( 'Items', 'myour-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
			]
		);

		$this->add_control(
			'contact_signature',
			[
				'label'       => esc_html__( 'Signature', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Signature', 'myour-plugin' ),
				'default'     => esc_html__( 'Joe Wilson', 'myour-plugin' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_styling',
			[
				'label'     => esc_html__( 'Title', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .section .titles .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .section .titles .title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_styling',
			[
				'label'     => esc_html__( 'Subtitle', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .section .titles .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .section .titles .subtitle',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'name_styling',
			[
				'label'     => esc_html__( 'Name', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .contact-info .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .contact-info .name',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'position_styling',
			[
				'label'     => esc_html__( 'Position', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'position_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .contact-info .subname' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'position_typography',
				'selector' => '{{WRAPPER}} .contact-info .subname',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'list_styling',
			[
				'label'     => esc_html__( 'List', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .contact-info .info-list ul li strong' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_value_color',
			[
				'label'     => esc_html__( 'Value Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .contact-info .info-list ul li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_typography',
				'selector' => '{{WRAPPER}} .contact-info .info-list ul li',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'signature_styling',
			[
				'label'     => esc_html__( 'Signature', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'signature_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .contact-info .author' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'signature_typography',
				'selector' => '{{WRAPPER}} .contact-info .author',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Contact Form List.
	 *
	 * @since 1.0
	 */
	protected function contact_form_list() {
		$cf7_posts = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$cf7_forms = array();
		
		if ( $cf7_posts ) {
			foreach ( $cf7_posts as $cf7_form ) {
				$cf7_forms[ $cf7_form->ID ] = $cf7_form->post_title;
			}
		} else {
			$cf7_forms[ esc_html__( 'No contact forms found', 'myour-plugin' ) ] = 0;
		}

		return $cf7_forms;
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() { 
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );

		$this->add_inline_editing_attributes( 'contact_name', 'basic' );
		$this->add_inline_editing_attributes( 'contact_position', 'basic' );
		$this->add_inline_editing_attributes( 'contact_signature', 'basic' );

		?>

		<!-- Section Contacts Info -->
		<div class="section contacts">
			<div class="content">

				<?php if ( $settings['title'] || $settings['subtitle'] ) : ?>
				<!-- title -->
				<div class="titles">
					<?php if ( $settings['title'] ) : ?>
					<<?php echo esc_attr( $settings['title_tag'] ); ?> class="title">
						<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                    		<?php echo wp_kses_post( $settings['title'] ); ?>
                    	</span>
					</<?php echo esc_attr( $settings['title_tag'] ); ?>>
					<?php endif; ?>
					<?php if ( $settings['subtitle'] ) : ?>
					<div class="subtitle">
						<span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>>
                    		<?php echo wp_kses_post( $settings['subtitle'] ); ?>
                    	</span>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $settings['contact_form'] ) : ?>
					<!-- contact form -->
					<div class="contact-form">
						<?php echo do_shortcode( '[contact-form-7 id="'. $settings['contact_form'] .'"]' ); ?>
					</div>
				<?php endif; ?>

				<!-- contact info -->
				<div class="contact-info">
					<?php if ( $settings['contact_name'] ) : ?>
					<div class="name"><?php echo esc_html( $settings['contact_name'] ); ?></div>
					<?php endif; ?>
					<?php if ( $settings['contact_position'] ) : ?>
					<div class="subname"><?php echo esc_html( $settings['contact_position'] ); ?></div>
					<?php endif; ?>
					<?php if ( $settings['contact_info'] ) : ?>
					<div class="info-list">
						<ul>
							<?php foreach ( $settings['contact_info'] as $index => $item ) : 
							$item_label = $this->get_repeater_setting_key( 'label', 'contact_info', $index );
						    $this->add_inline_editing_attributes( $item_label, 'none' );

						    $item_value = $this->get_repeater_setting_key( 'value', 'contact_info', $index );
						    $this->add_inline_editing_attributes( $item_value, 'none' );
							?>
							<li>
								<strong>
									<span <?php echo $this->get_render_attribute_string( $item_label ); ?>>
										<?php echo esc_html( $item['label'] ); ?>
									</span>
								</strong>
								<span <?php echo $this->get_render_attribute_string( $item_value ); ?>>
									<?php echo esc_html( $item['value'] ); ?>
								</span>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
					<?php if ( $settings['contact_signature'] ) : ?>
					<div class="author"><?php echo esc_html( $settings['contact_signature'] ); ?></div>
					<?php endif; ?>
				</div>

				<div class="clear"></div>
			</div>
		</div>

		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_Contacts_Widget() );