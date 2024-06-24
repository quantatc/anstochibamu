<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Myour Portfolio Widget.
 *
 * @since 1.0
 */
class Myour_Portfolio_Widget extends Widget_Base {

	public function get_name() {
		return 'myour-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'myour-plugin' );
	}

	public function get_icon() {
		return 'fas fa-suitcase';
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
			'filters_tab',
			[
				'label' => esc_html__( 'Filters', 'myour-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'filters',
			[
				'label' => esc_html__( 'Show Filters', 'myour-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'myour-plugin' ),
				'label_off' => __( 'Hide', 'myour-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
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

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'  => __( 'All', 'myour-plugin' ),
					'categories' => __( 'Categories', 'myour-plugin' ),
				],
			]
		);

		$this->add_control(
			'source_categories',
			[
				'label'       => esc_html__( 'Source', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_portfolio_categories(),
				'condition' => [
		            'source' => 'categories'
		        ],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'       => esc_html__( 'Number of Items', 'myour-plugin' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => 8,
				'default'     => 8,
			]
		);

		$this->add_control(
			'sort',
			[
				'label'       => esc_html__( 'Sorting By', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'menu_order',
				'options' => [
					'date'  => __( 'Date', 'myour-plugin' ),
					'title' => __( 'Title', 'myour-plugin' ),
					'rand' => __( 'Random', 'myour-plugin' ),
					'menu_order' => __( 'Order', 'myour-plugin' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Order', 'myour-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => [
					'asc'  => __( 'ASC', 'myour-plugin' ),
					'desc' => __( 'DESC', 'myour-plugin' ),
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
			'item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .service-item .icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .service-item .name' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .service-item .name',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Title Color', 'myour-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .service-item .single-post-text' => 'color: {{VALUE}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'myour-plugin' ),
				'selector' => '{{WRAPPER}} .service-item .single-post-text',
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Render Categories List.
	 *
	 * @since 1.0
	 */
	protected function get_portfolio_categories() {
		$categories = [];

		$args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'portfolio_categories',
			'pad_counts'	=> false 
		);

		$portfolio_categories = get_categories( $args );

		foreach ( $portfolio_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
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

		if ( $settings['source'] == 'all' ) {
			$cat_ids = '';
		} else {
			$cat_ids = $settings['source_categories'];
		}

		$cat_args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'portfolio_categories',
			'pad_counts'	=> false,
			'include'		=> $cat_ids
		);

		$pf_categories = get_categories( $cat_args );

		$args = array(
			'post_type'			=> 'portfolio',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit']
		);

		if( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'portfolio_categories',
					'field'    => 'id',
					'terms'    => $cat_ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}

		$q = new \WP_Query( $args );

		?>

		<!-- Works -->
		<div class="section works">
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

				<?php if ( $settings['filters'] && $pf_categories ) : ?>
				<!-- filter -->
				<div class="filter-menu">
					<div class="filters">
						<div class="btn-group">
							<label data-text="<?php echo esc_attr__( 'All', 'myour-plugin' ); ?>" class="glitch-effect">
								<input type="radio" name="fl_radio" value=".box-col" /><?php echo esc_html__( 'All', 'myour-plugin' ); ?>
							</label>
						</div>

						<?php foreach ( $pf_categories as $category ) : ?>
						<div class="btn-group">
							<label data-text="Video">
								<input type="radio" name="fl_radio" value=".f-<?php echo esc_attr( $category->slug ); ?>" /><?php echo esc_html( $category->name ); ?>
							</label>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( $q->have_posts() ) : ?>
				<!-- portfolio items -->
				<div class="box-items">	
					<?php while ( $q->have_posts() ) : $q->the_post(); 
						
						/* post content */
						$current_categories = get_the_terms( get_the_ID(), 'portfolio_categories' );
						$category = '';
						$category_slug = '';
						if ( $current_categories && ! is_wp_error( $current_categories ) ) {
							$arr_keys = array_keys( $current_categories );
							$last_key = end( $arr_keys );
							foreach ( $current_categories as $key => $value ) {
								if ( $key == $last_key ) {
									$category .= $value->name . ' ';
								} else {
									$category .= $value->name . ', ';
								}
								$category_slug .= 'f-' . $value->slug . ' ';
							}
						}
						$id = get_the_ID();
						$image = get_the_post_thumbnail_url( $id, 'myour_680x680' );
						$title = get_the_title();
						$href = get_the_permalink();

						/*get portfolio type*/
						$type = get_field( 'portfolio_type', $id );
						$popup_url = get_the_post_thumbnail_url( $id, 'full' );
						$popup_class = 'has-popup-image';
						$preview_icon = 'fas fa-image';
						$images = false;
						$popup_link_target = false;

						if ( $type == 2 ) {
							$popup_url = get_field( 'music_url', $id );
							$popup_class = 'has-popup-music';
							$preview_icon = 'fas fa-music';
						} elseif ( $type == 3 ) {
							$popup_url = get_field( 'video_url', $id );
							$popup_class = 'has-popup-video';
							$preview_icon = 'fas fa-video';
						} elseif ( $type == 4 ) {
							$popup_url = '#popup-' . $id;
							$popup_class = 'has-popup-media';
							$preview_icon = 'fas fa-plus';
							$btn_text = get_field( 'button_text', $id );
							if(empty($btn_text)){
								$btn_text = esc_html__( 'View Project', 'myour-plugin' );
							}
							$btn_url = get_field( 'button_url', $id );
						} elseif ( $type == 5 ) {
							$popup_url = '#gallery-' . $id;
							$popup_class = 'has-popup-gallery';
							$preview_icon = 'fas fa-images';
							$images = get_field( 'gallery', $id );
						} elseif ( $type == 6 ) {
							$popup_url = get_field( 'link_url', $id );
							$popup_link_target = true;
							$popup_class = 'has-popup-link';
							$preview_icon = 'fas fa-link';
						} else { }

					?>
					<div class="box-col <?php echo esc_attr( $category_slug ); ?>">
						<div class="box-item">
							<div class="image">
								<?php if ( $image ) : ?>
								<a href="<?php echo esc_url( $popup_url ); ?>" class="<?php echo esc_attr( $popup_class ); ?>"<?php if ( $popup_link_target ) : ?> target="_blank"<?php endif; ?>>
									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
									<span class="info">
										<span class="centrize full-width">
											<span class="vertical-center">
												<i class="icon <?php echo esc_attr( $preview_icon ); ?>"></i>
											</span>
										</span>
									</span>
								</a>
								<?php endif; ?>
								<?php if( $images ) : ?>
								<div id="gallery-<?php echo esc_attr( $id ); ?>" class="mfp-hide">
									<?php foreach( $images as $image ) : $gallery_img_src = wp_get_attachment_image_src( $image['ID'], 'full' ); ?>
									<a href="<?php echo esc_url( $gallery_img_src[0] ); ?>"></a>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
							</div>
							<div class="desc">
								<?php if ( $category ) : ?>
								<div class="category"><?php echo esc_html( $category ); ?></div>
								<?php endif; ?>
								<a href="<?php echo esc_url( $popup_url ); ?>" class="name <?php echo esc_attr( $popup_class ); ?>"<?php if ( $popup_link_target ) : ?> target="_blank"<?php endif; ?>><?php echo esc_html( $title ); ?></a>
							</div>

							<?php if ( $type == 4 ) : ?>
							<div id="popup-<?php echo esc_attr( $id ); ?>" class="popup-box mfp-fade mfp-hide">
								<div class="content">
									<div class="preloader-popup">
										<div class="box-1">
											<div class="centrize full-width">
												<div class="vertical-center">
													<div class="spinner">
														<div class="lines"></div>
													</div>
												</div>
											</div>
										</div>
										<div class="box-2"></div>
									</div>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endwhile; wp_reset_postdata(); ?>

				</div>
				<?php endif; ?>

				<div class="clear"></div>
			</div>
		</div>

		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Myour_Portfolio_Widget() );