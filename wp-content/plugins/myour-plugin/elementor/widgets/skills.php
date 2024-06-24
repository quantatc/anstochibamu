<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour Skills Widget.
 *
 * @since 1.0
 */
class Myour_Skills_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-skills';
	}

	public function get_title() {
		return esc_html__( 'Skills', 'myour-plugin' );
	}

	public function get_icon() {
		return 'fas fa-dumbbell';
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
			'name', [
				'label'       => esc_html__( 'Title', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'myour-plugin' ),
				'default'	=> esc_html__( 'Enter title', 'myour-plugin' ),
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

		$repeater->add_control(
			'progress_label', [
				'label'       => esc_html__( 'Progress Label', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '90%', 'myour-plugin' ),
				'default'	=> esc_html__( '90%', 'myour-plugin' ),
			]
		);

		$repeater->add_control(
			'progress_value', [
				'label'       => esc_html__( 'Progress Value (%)', 'myour-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '90', 'myour-plugin' ),
				'default'	=> esc_html__( '90', 'myour-plugin' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Skills Items', 'myour-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'progress_type_tab',
			[
				'label' => esc_html__( 'Progress Settings', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'progress_type',
			[
				'label'       => esc_html__( 'Progress Type', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'percent',
				'options' => [
					'percent'  => __( 'Percent', 'myour-plugin' ),
					'dotted' => __( 'Dotted', 'myour-plugin' ),
					'circles' => __( 'Circles', 'myour-plugin' ),
				],
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
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .skills .name' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .skills .name',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Title Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .skills .single-post-text' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .skills .single-post-text',
			]
		);

		$this->add_control(
			'item_progress_label_color',
			[
				'label'     => esc_html__( 'Progress Label Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .skills .progress .percentage .percent, {{WRAPPER}} .skills.circles .progress span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_progress_label_typography',
				'label'     => esc_html__( 'Progress Label Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .skills .progress .percentage .percent, {{WRAPPER}} .skills.circles .progress span',
			]
		);

		$this->add_control(
			'item_progress_line_color',
			[
				'label'     => esc_html__( 'Progress Line Background', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .skills .progress .percentage' => 'background: {{VALUE}};',
					'{{WRAPPER}} .skills.dotted .progress .da span' => 'background: {{VALUE}};',
					'{{WRAPPER}} .skills.circles .progress .bar, {{WRAPPER}} .skills.circles .progress .fill' => 'border-color: {{VALUE}};',
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
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		?>

		<!-- Section Skills -->
		<div class="section skills">
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
				<!-- skills items -->
				<div class="skills <?php echo esc_attr( $settings['progress_type'] ); ?>">
					<ul>
						<?php foreach ( $settings['items'] as $index => $item ) : 
					    $item_name = $this->get_repeater_setting_key( 'name', 'items', $index );
					    $this->add_inline_editing_attributes( $item_name, 'basic' );

					    $item_desc = $this->get_repeater_setting_key( 'desc', 'items', $index );
					    $this->add_inline_editing_attributes( $item_desc, 'advanced' );

					    $progress_label = $this->get_repeater_setting_key( 'progress_label', 'items', $index );
					    $this->add_inline_editing_attributes( $progress_label, 'none' );
					    ?>
						<li>
							<?php if ( $settings['progress_type'] == 'circles' ) : ?>
							<div class="progress p<?php echo esc_attr( $item['progress_value'] ); ?>">
								<div class="percentage"></div>
								<span <?php echo $this->get_render_attribute_string( $progress_label ); ?>>
									<?php echo esc_html( $item['progress_label'] ); ?>
								</span>
							</div>
							<?php endif; ?>
							<div class="name">
								<span <?php echo $this->get_render_attribute_string( $item_name ); ?>>
									<?php echo wp_kses_post( $item['name'] ); ?>
								</span>
							</div>
							<div class="single-post-text">
								<div <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
									<?php echo wp_kses_post( $item['desc'] ); ?>
								</div>
							</div>
							<?php if ( $settings['progress_type'] != 'circles' ) : ?>
							<div class="progress">
								<div class="percentage" style="width: <?php echo esc_attr( $item['progress_value'] ); ?>%;">
									<span class="percent">
										<span <?php echo $this->get_render_attribute_string( $progress_label ); ?>>
											<?php echo esc_html( $item['progress_label'] ); ?>
										</span>
									</span>
								</div>
							</div>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
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

		<!-- Section Skills -->
		<div class="section skills">
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
				<!-- skills items -->
				<div class="skills {{{ settings.progress_type }}}">
					<ul>
					    <# _.each( settings.items, function( item, index ) { 

					    var item_name = view.getRepeaterSettingKey( 'name', 'items', index );
					    view.addInlineEditingAttributes( item_name, 'basic' );

					    var item_desc = view.getRepeaterSettingKey( 'desc', 'items', index );
					    view.addInlineEditingAttributes( item_desc, 'advanced' );

					    var item_progress_label = view.getRepeaterSettingKey( 'progress_label', 'items', index );
					    view.addInlineEditingAttributes( item_progress_label, 'none' );

					    #>
						<li>
							<# if ( settings.progress_type == 'circles' ) { #>
							<div class="progress p{{{ item.progress_value }}}">
								<div class="percentage"></div>
								<span {{{ view.getRenderAttributeString( item_progress_label ) }}}>
									{{{ item.progress_label }}}
								</span>
							</div>
							<# } #>
							<div class="name">
								<span {{{ view.getRenderAttributeString( item_name ) }}}>
									{{{ item.name }}}
								</span>
							</div>
							<div class="single-post-text">
								<div {{{ view.getRenderAttributeString( item_desc ) }}}>
									{{{ item.desc }}}
								</div>
							</div>
							<# if ( settings.progress_type != 'circles' ) { #>
							<div class="progress">
								<div class="percentage" style="width: {{{ item.progress_value }}}%;">
									<span class="percent">
										<span {{{ view.getRenderAttributeString( item_progress_label ) }}}>
											{{{ item.progress_label }}}
										</span>
									</span>
								</div>
							</div>
							<# } #>
						</li>
						<# }); #>
					</ul>
				</div>
				<# } #>
			</div>
		</div>

		<?php 
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_Skills_Widget() );