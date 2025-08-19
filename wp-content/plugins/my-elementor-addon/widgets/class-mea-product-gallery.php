<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class MEA_Product_Gallery_Widget extends Widget_Base {

    public function get_name() {
        return 'mea-product-gallery';
    }

    public function get_title() {
        return esc_html__( 'Product Gallery (DummyJSON)', 'my-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_script_depends() {
        return [ 'mea-product-gallery' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'my-elementor-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__( 'Category (optional)', 'my-elementor-addon' ),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Comma separated categories (e.g. smartphones, laptops). Leave empty to show all.', 'my-elementor-addon' ),
                'default' => '',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'my-elementor-addon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 30,
                'step' => 1,
                'default' => 12,
            ]
        );

        $this->add_control(
            'columns_desktop',
            [
                'label' => esc_html__( 'Columns (desktop)', 'my-elementor-addon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'step' => 1,
                'default' => 4,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $limit = isset( $settings['limit'] ) ? intval( $settings['limit'] ) : 12;
        $columns = isset( $settings['columns_desktop'] ) ? intval( $settings['columns_desktop'] ) : 4;
        $category = isset( $settings['category'] ) ? sanitize_text_field( $settings['category'] ) : '';

        $container_attrs = sprintf(
            'data-limit="%d" data-columns="%d" data-category="%s"',
            $limit,
            $columns,
            esc_attr( $category )
        );

        echo '<div class="mea-widget">';
        echo '  <div class="mea-toolbar">';
        echo '      <label>' . esc_html__( 'Sort by', 'my-elementor-addon' ) . '</label> ';
        echo '      <select class="mea-sort-key"><option value="title">Title</option><option value="price">Price</option></select> ';
        echo '      <select class="mea-sort-dir"><option value="asc">ASC</option><option value="desc">DESC</option></select>';
        echo '  </div>';
        echo '  <div class="mea-product-gallery" ' . $container_attrs . '>';
        echo '      <div class="mea-loading">Loading...</div>';
        echo '  </div>';
        echo '</div>';
    }
}
