<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour About Me Widget.
 *
 * @since 1.0
 */
class Myour_About_Me_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-about-me';
	}

	public function get_title() {
		return esc_html__( 'About Me', 'myour-plugin' );
	}

	public function get_icon() {
		return 'far fa-user-circle';
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
			'title_tab',
			[
				'label' => esc_html__( 'Title', 'myour-plugin' ),
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

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitles_tab',
			[
				'label' => esc_html__( 'Subtitle', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'description_tab',
			[
				'label' => esc_html__( 'Description', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'list_tab',
			[
				'label' => esc_html__( 'Info List', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'list',
			[
				'label' => esc_html__( 'List', 'myour-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
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
			'description_styling',
			[
				'label'     => esc_html__( 'Description', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .single-post-text' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .single-post-text',
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
			'list_color',
			[
				'label'     => esc_html__( 'Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .info-list ul li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_color2',
			[
				'label'     => esc_html__( 'Label Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .info-list ul li strong' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_typography',
				'selector' => '{{WRAPPER}} .info-list ul li',
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
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'advanced' );
		
		?>

		<!-- Section About -->
		<div class="section about">
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

				<?php if ( $settings['description'] ) : ?>
				<!-- text -->
				<div class="single-post-text">
					<div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
			    		<?php echo wp_kses_post( $settings['description'] ); ?>		
			    	</div>
				</div>
				<?php endif; ?>

				<?php if ( $settings['list'] ) : ?>
				<!-- info list -->
				<div class="info-list">
					<ul>
						<?php foreach ( $settings['list'] as $index => $item ) : 
					    
					    $item_label = $this->get_repeater_setting_key( 'label', 'list', $index );
					    $this->add_inline_editing_attributes( $item_label, 'none' );

					    $item_value = $this->get_repeater_setting_key( 'value', 'list', $index );
					    $this->add_inline_editing_attributes( $item_value, 'none' );

					    ?>
						<li>
							<?php if ( $item['label'] ) : ?>
							<strong>
								<span <?php echo $this->get_render_attribute_string( $item_label ); ?>>
									<?php echo esc_html( $item['label'] ); ?>
								</span>
							</strong> 
							<?php endif; ?>
							<?php if ( $item['value'] ) : ?>
							<span <?php echo $this->get_render_attribute_string( $item_value ); ?>>
								<?php echo esc_html( $item['value'] ); ?>
							</span>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<div class="clear"></div>
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
		view.addInlineEditingAttributes( 'subtitle', 'basic' );
		view.addInlineEditingAttributes( 'description', 'advanced' );
		#>

		<!-- Section About -->
		<div class="section about">
			<div class="content">

				<# if ( settings.title || settings.subtitle ) { #>
				<!-- title -->
				<div class="titles">
					<# if ( settings.title ) { #>
					<div class="title">
						<span {{{ view.getRenderAttributeString( 'title' ) }}}>
							{{{ settings.title }}}
						</span>
					</div>
					<# } #>
					<# if ( settings.subtitle ) { #>
					<div class="subtitle">
						<span {{{ view.getRenderAttributeString( 'subtitle' ) }}}>
							{{{ settings.subtitle }}}
						</span>
					</div>
					<# } #>
				</div>
				<# } #>

				<# if ( settings.description ) { #>
				<!-- text -->
				<div class="single-post-text">
					<div {{{ view.getRenderAttributeString( 'description' ) }}}>
			    		{{{ settings.description }}}
			    	</div>
				</div>
				<# } #>

				<# if ( settings.list ) { #>
				<!-- info list -->
				<div class="info-list">
					<ul>
						<# _.each( settings.list, function( item, index ) { 
					    
					    var item_label = view.getRepeaterSettingKey( 'label', 'list', index );
					    view.addInlineEditingAttributes( item_label, 'none' );

					    var item_value = view.getRepeaterSettingKey( 'value', 'list', index );
					    view.addInlineEditingAttributes( item_value, 'none' );

					    #>
						<li>
							<# if ( item.label ) { #>
							<strong>
								<span {{{ view.getRenderAttributeString( item_label ) }}}>
									{{{ item.label }}}
								</span>
							</strong> 
							<# } #>
							<# if ( item.value ) { #>
							<span {{{ view.getRenderAttributeString( item_value ) }}}>
								{{{ item.value }}}
							</span>
							<# } #>
						</li>
						<# }); #>
					</ul>
				</div>
				<# } #>

				<div class="clear"></div>
			</div>
		</div>

		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_About_Me_Widget() );