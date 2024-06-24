<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour About Heading Widget.
 *
 * @since 1.0
 */
class Myour_About_Headings_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-about-headings';
	}

	public function get_title() {
		return esc_html__( 'Section Heading', 'myour-plugin' );
	}

	public function get_icon() {
		return ' fas fa-heading';
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
			'heading_content',
			[
				'label' => esc_html__( 'Headings', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'myour-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter subtitle', 'myour-plugin' ),
				'default'     => esc_html__( 'Subtitle', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your title', 'myour-plugin' ),
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
					'h3' => __( 'H3', 'myour-plugin' ),
					'div' => __( 'DIV', 'myour-plugin' ),
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'myour-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your description', 'myour-plugin' ),
				'default'     => esc_html__( 'Type your description here', 'myour-plugin' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'about_heading_styling',
			[
				'label'     => esc_html__( 'About Heading', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'myour-plugin' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'myour-plugin' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'myour-plugin' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'myour-plugin' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'elementor-align%s-',
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
					'{{WRAPPER}} .section-about .text-rotate' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .section-about .text-rotate',
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
			'title_size',
			[
				'label'       => esc_html__( 'Title Size', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1'  => __( 'Big', 'myour-plugin' ),
					'h2' => __( 'Medium', 'myour-plugin' ),
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .section-about .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .section-about .title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_styling',
			[
				'label'     => esc_html__( 'Description', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_two_cols',
			[
				'label'     => esc_html__( 'Display Text in Two Columns?', 'myour-plugin' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'	=> 'no',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .section-about .description' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .section-about .description',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'heading_spacing_styling',
			[
				'label'     => esc_html__( 'Spacing', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'myour-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .section-about' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->add_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Margin', 'myour-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .section-about' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'subtitle', 'none' );
		$this->add_inline_editing_attributes( 'description', 'advanced' );

		?>

        <!-- Heading -->
		<div class="container section-about">
			<?php if ( $settings['subtitle'] ) : ?>
		    <span class="text-rotate">
		    	<span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $settings['subtitle'] ); ?></span>
		    </span>
			<?php endif; ?>
			<div class="row">
				<div class="col-12">
			    	<?php if ( $settings['title'] ) : ?>
				    <<?php echo esc_attr( $settings['title_tag'] ); ?> class="title title--<?php echo esc_attr( $settings['title_size'] ); ?> js-lines">
				    	<span <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></span>
				    </<?php echo esc_attr( $settings['title_tag'] ); ?>>
				    <?php endif; ?>
				    <?php if ( $settings['description'] ) : ?>
				    <div class="description<?php if ( $settings['description_two_cols'] == 'yes' ) : ?> description-column<?php endif; ?> js-scroll-show">
					    <div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $settings['description'] ); ?></div>
				    </div>
				    <?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes( 'title', 'basic' );
		view.addInlineEditingAttributes( 'subtitle', 'none' );
		view.addInlineEditingAttributes( 'description', 'advanced' );
		#>
        <!-- Heading -->
		<div class="container section-about">
			<# if ( settings.subtitle ) { #>
		    <span class="text-rotate">
		    	<span {{{ view.getRenderAttributeString( 'subtitle' ) }}}>{{{ settings.subtitle }}}</span>
		    </span>
			<# } #>
			<div class="row">
			    <div class="row__col">
			    	<# if ( settings.title ) { #>
				    <{{{ settings.title_tag }}} class="title title--{{{ settings.title_size }}} js-lines">
				    	<span {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</span>
				    </{{{ settings.title_tag }}}>
				    <# } #>
				    <# if ( settings.description ) { #>
				    <div class="description<# if ( settings.description_two_cols == 'yes' ) { #> description-column<# } #> js-scroll-show">
					    <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
				    </div>
				    <# } #>
				</div>
			</div>
		</div>
		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_About_Headings_Widget() );