<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour About Heading Widget.
 *
 * @since 1.0
 */
class Myour_Started_Section_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-started-section';
	}

	public function get_title() {
		return esc_html__( 'Started Section', 'myour-plugin' );
	}

	public function get_icon() {
		return 'fab fa-stripe-s';
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
				'default' => 'h1',
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'subtitle', [
				'label'       => esc_html__( 'Subtitle', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter subtitle', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter subtitle', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'subtitles',
			[
				'label' => esc_html__( 'Subtitle Strings', 'myour-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ subtitle }}}',
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
			'button_tab',
			[
				'label' => esc_html__( 'Button', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'URL', 'myour-plugin' ),
				'type' => Controls_Manager::URL,
				'show_external' => true,
			]
		);

		$this->add_control(
			'button',
			[
				'label' => esc_html__( 'Title', 'myour-plugin' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Button Title', 'myour-plugin' ),
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
					'{{WRAPPER}} .section.started .h-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .section.started .h-title',
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
					'{{WRAPPER}} .section.started .started-content .h-text' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .section.started .started-content .h-text',
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
					'{{WRAPPER}} .section.started .started-content .h-subtitles' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .section.started .started-content .h-subtitles',
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
		$this->add_inline_editing_attributes( 'description', 'advanced' );
		$this->add_inline_editing_attributes( 'button', 'none' );
		?>

		<!-- Section Started -->
		<div class="section started">
			<div class="centrize full-width">
				<div class="vertical-center">

					<?php if ( $settings['title'] ) : ?>
					<!-- title -->
					<<?php echo esc_attr( $settings['title_tag'] ); ?> class="h-title">
						<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                    		<?php echo wp_kses_post( $settings['title'] ); ?>
                    	</span>
					</<?php echo esc_attr( $settings['title_tag'] ); ?>>
					<?php endif; ?>

					<!-- content started -->
					<div class="started-content">
						<?php if ( $settings['subtitles'] ) : ?>
						<!-- subtitle -->
						<div class="h-subtitles">
							<div class="h-subtitle typing-subtitle">
								<?php foreach ( $settings['subtitles'] as $index => $subtitle ) : 
							    $subtitle_text = $this->get_repeater_setting_key( 'subtitle', 'subtitles', $index );
							    $this->add_inline_editing_attributes( $subtitle_text, 'none' );
							    ?>
								<p>
									<span <?php echo $this->get_render_attribute_string( $subtitle_text ); ?>>
										<?php echo esc_html( $subtitle['subtitle'] ); ?>
									</span>
								</p>
								<?php endforeach; ?>
							</div>
							<span class="typed-subtitle"></span>
						</div>
						<?php endif; ?>

						<?php if ( $settings['description'] ) : ?>
						<!-- text -->
						<div class="h-text">
							<div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
					    		<?php echo wp_kses_post( $settings['description'] ); ?>		
					    	</div>
						</div>
						<?php endif; ?>

						<?php if ( $settings['button'] ) : ?>
						<!-- button -->
						<a<?php if ( $settings['link'] ) : if ( $settings['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $settings['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $settings['link']['url'] ); ?>"<?php endif; ?> class="btn">
							<span class="animated-button"><span <?php echo $this->get_render_attribute_string( 'button' ); ?>><?php echo esc_html( $settings['button'] ); ?></span></span>
							<i class="icon fas fa-chevron-right"></i>
						</a>
						<?php endif; ?>

						<!-- mosue button -->
						<a href="#" class="btn mouse-btn" style="display: none;">
							<i class="icon fas fa-chevron-down"></i>
						</a>

					</div>

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
		view.addInlineEditingAttributes( 'description', 'advanced' );
		view.addInlineEditingAttributes( 'button', 'none' );
		#>

		<!-- Section Started -->
		<div class="section started">
			<div class="centrize full-width">
				<div class="vertical-center">

					<# if ( settings.title ) { #>
					<!-- title -->
					<{{{ settings.title_tag }}} class="h-title">
						<span {{{ view.getRenderAttributeString( 'title' ) }}}>
                    		{{{ settings.title }}}
                    	</span>
					</{{{ settings.title_tag }}}>
					<# } #>

					<!-- content started -->
					<div class="started-content">
						<# if ( settings.subtitles ) { #>
						<!-- subtitle -->
						<div class="h-subtitles">
							<div class="h-subtitle typing-subtitle">
							    <# _.each( settings.subtitles, function( subtitle, index ) { 

							    var subtitle = view.getRepeaterSettingKey( 'subtitle', 'subtitles', index );

							    view.addInlineEditingAttributes( subtitle, 'none' );

							    #>
								<p>
									<span {{{ view.getRenderAttributeString( subtitle ) }}}>
										{{{ subtitle.subtitle }}}
									</span>
								</p>
								<# }); #>
							</div>
							<span class="typed-subtitle"></span>
						</div>
						<# } #>

						<# if ( settings.description ) { #>
						<!-- text -->
						<div class="h-text">
							<div {{{ view.getRenderAttributeString( 'description' ) }}}>
					    		{{{ settings.description }}}
					    	</div>
						</div>
						<# } #>

						<# if ( settings.button ) { #>
						<!-- button -->
						<a<# if ( settings.link ) { #><# if ( settings.link.is_external ) { #> target="_blank"<# } #><# if ( settings.link.nofollow ) { #> rel="nofollow"<# } #> href="{{{ settings.link.url }}}"<# } #> class="btn">
							<span class="animated-button"><span {{{ view.getRenderAttributeString( 'button' ) }}}>{{{ settings.button }}}</span></span>
							<i class="icon fas fa-chevron-right"></i>
						</a>
						<# } #>

						<!-- mosue button -->
						<a href="#" class="btn mouse-btn" style="display: none;">
							<i class="icon fas fa-chevron-down"></i>
						</a>

					</div>

				</div>
			</div>
		</div>

		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_Started_Section_Widget() );