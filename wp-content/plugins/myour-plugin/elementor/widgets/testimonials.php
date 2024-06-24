<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour Testimonials Widget.
 *
 * @since 1.0
 */
class Myour_Testimonials_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'myour-plugin' );
	}

	public function get_icon() {
		return 'far fa-comments';
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
			'items_tab',
			[
				'label' => esc_html__( 'Items', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image', [
				'label' => esc_html__( 'Image', 'myour-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'name', [
				'label'       => esc_html__( 'Name', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter name', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter name', 'myour-plugin' ),
			]
		);

		$repeater->add_control(
			'subname', [
				'label'       => esc_html__( 'Subname', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter subname', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter subname', 'myour-plugin' ),
			]
		);

		$repeater->add_control(
			'desc', [
				'label'       => esc_html__( 'Description', 'myour-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter description', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter description', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Testimonials Items', 'myour-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
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
			'items_styling',
			[
				'label'     => esc_html__( 'Items', 'myour-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .reviews-item .name' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_name_typography',
				'label'     => esc_html__( 'Name Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .reviews-item .name',
			]
		);

		$this->add_control(
			'item_subname_color',
			[
				'label'     => esc_html__( 'Subname Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .reviews-item .company' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_subname_typography',
				'label'     => esc_html__( 'Subname Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .reviews-item .company',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .reviews-item .text' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .reviews-item .text',
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
		?>

		<!-- Section Testimonials -->
		<div class="section testimonials">
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

				<?php if ( $settings['items'] ) : ?>
				<!-- testimonials items -->
				<div class="content-carousel">
					<div class="owl-carousel" data-slidesView="2" data-slidesview_mobile="1">
						<?php foreach ( $settings['items'] as $index => $item ) : 
					    $item_name = $this->get_repeater_setting_key( 'name', 'items', $index );
					    $this->add_inline_editing_attributes( $item_name, 'basic' );

					    $item_subname = $this->get_repeater_setting_key( 'subname', 'items', $index );
					    $this->add_inline_editing_attributes( $item_subname, 'basic' );

					    $item_desc = $this->get_repeater_setting_key( 'desc', 'items', $index );
					    $this->add_inline_editing_attributes( $item_desc, 'advanced' );
					    ?>
						<div class="item">
							<div class="reviews-item">
								<?php if ( $item['image'] ) : $image = wp_get_attachment_image_url( $item['image']['id'], 'myour_140x140' ); ?>
								<div class="image">
									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>">
								</div>
								<?php endif; ?>
								<div class="info">
									<div class="name">
										<span <?php echo $this->get_render_attribute_string( $item_name ); ?>>
											<?php echo wp_kses_post( $item['name'] ); ?>
										</span>
									</div>
									<div class="company">
										<span <?php echo $this->get_render_attribute_string( $item_subname ); ?>>
											<?php echo wp_kses_post( $item['subname'] ); ?>
										</span>
									</div>
								</div>
								<div class="text">
									<div <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
										<?php echo wp_kses_post( $item['desc'] ); ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>

					<!-- navigation -->
					<div class="navs">
						<span class="prev fas fa-chevron-left"></span>
						<span class="next fas fa-chevron-right"></span>
					</div>

				</div>
				<?php endif; ?>
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
		#>

		<!-- Section Testimonials -->
		<div class="section testimonials">
			<div class="content">

				<# if ( settings.title || settings.subtitle ) { #>
				<!-- title -->
				<div class="titles">
					<# if ( settings.title ) { #>
					<{{{ settings.title_tag }}} class="title">
						<span {{{ view.getRenderAttributeString( 'title' ) }}}>
                    		{{{ settings.title }}}
                    	</span>
					</{{{ settings.title_tag }}}>
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

				<# if ( settings.items ) { #>
				<!-- testimonials items -->
				<div class="content-carousel">
					<div class="owl-carousel" data-slidesView="2" data-slidesview_mobile="1">
					    <# _.each( settings.items, function( item, index ) { 

					    var item_name = view.getRepeaterSettingKey( 'name', 'items', index );
					    view.addInlineEditingAttributes( item_name, 'basic' );

					    var item_subname = view.getRepeaterSettingKey( 'subname', 'items', index );
					    view.addInlineEditingAttributes( item_subname, 'basic' );

					    var item_desc = view.getRepeaterSettingKey( 'desc', 'items', index );
					    view.addInlineEditingAttributes( item_desc, 'advanced' );

					    #>
						<div class="item">
							<div class="reviews-item">
								<# if ( item.image ) { #>
								<div class="image">
									<img src="{{{ item.image.url }}}" alt="{{{ item.name }}}">
								</div>
								<# } #>
								<div class="info">
									<div class="name">
										<span {{{ view.getRenderAttributeString( item_name ) }}}>
											{{{ item.name }}}
										</span>
									</div>
									<div class="company">
										<span {{{ view.getRenderAttributeString( item_subname ) }}}>
											{{{ item.subname }}}
										</span>
									</div>
								</div>
								<div class="text">
									<div {{{ view.getRenderAttributeString( item_desc ) }}}>
										{{{ item.desc }}}
									</div>
								</div>
							</div>
						</div>
						<# }); #>
					</div>

					<!-- navigation -->
					<div class="navs">
						<span class="prev fas fa-chevron-left"></span>
						<span class="next fas fa-chevron-right"></span>
					</div>

				</div>
				<# } #>
			</div>
		</div>

		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_Testimonials_Widget() );