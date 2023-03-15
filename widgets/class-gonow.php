<?php
/**
 * Go_now class.
 *
 * @category   Class
 * @package    GoNowCard
 * @subpackage WordPress
 * @author     Ricky Song
 * @since      1.0.0
 * php version 7.3.9
 */

namespace GoNow\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * Go now widget class.
 *
 * @since 1.0.0
 */
class GoNow extends Widget_Base
{
    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        wp_register_style('go-now-card', plugins_url('/assets/css/gonow.css', GONOW), array(), '1.0.0');
        wp_enqueue_style('go-now-card');
    }

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_name()
    {
        return 'gonow';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_title()
    {
        return __('Gonow', 'elementor-gonow');
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_icon()
    {
        return 'fa fa-pencil';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_categories()
    {
        return array('general');
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends()
    {
        return array('awesomesauce');
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __('GoNow Card', 'elementor-gonow'),
            )
        );
        $this->add_control('link_target',
            [
                'label' => __( 'Link Target', 'go-now' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'blank' => 'blank',
                    'self' => 'self',
                ],
                'default' => 'blank',
            ]);
        $this->add_control('link_rel',
            [
                'label' => __( 'Link Rel', 'go-now' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'nofllow' => 'nofllow',
                    'external' => 'external',
                    'nofllow external' => 'both',
                ],
                'default' => '',
            ]);

        $menu_items = [];

        $menu_items[] = ['item_title' => 'Home', 'item_url' => '/', 'item_icon' => ''];
        $menu_items[] = ['item_title' => 'About', 'item_url' => '/about',];
        $menu_items[] = ['item_title' => 'Contact', 'item_url' => '/contact',];

        $this->add_control('menu_items',
            [
                'label' => __('Menu Items', 'go-now'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'item_title',
                        'label' => __('Title', 'go-now'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_description',
                        'label' => __('Description', 'go-now'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_icon',
                        'label' => __('Icon', 'go-now'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => 'https://cdn-icons-png.flaticon.com/512/174/174855.png'
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_url',
                        'label' => __('Default URL', 'go-now'),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_android_url',
                        'label' => __('Android URL', 'go-now'),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_iphone_url',
                        'label' => __('iPhone URL', 'go-now'),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'item_weixin_url',
                        'label' => __('Weixin URL', 'go-now'),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                        ],
                        'label_block' => true,
                    ],
                ],
                'default' => $menu_items,
                'title_field' => '{{{ item_title }}}',
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
//        print_r($settings['menu_items']);
//        $this->add_inline_editing_attributes('item_title', 'none');
//        $this->add_inline_editing_attributes('item_description', 'basic');
//        $this->add_inline_editing_attributes('item_icon', 'advanced');
//        ?>
<!--        <h2 --><?php //echo $this->get_render_attribute_string('item_title'); ?><!--<?php //echo wp_kses($settings['item_title'], array()); ?></h2>-->
<!--        <div --><?php //echo $this->get_render_attribute_string('item_description'); ?><!--<?php //echo wp_kses($settings['item_description'], array()); ?></div>-->
<!--        <div --><?php //echo $this->get_render_attribute_string('item_icon'); ?><!--<?php //echo wp_kses($settings['item_icon'], array()); ?></div>-->
<!--        --><?php
        echo "<div class='row go-now-card'>";
        foreach($settings['menu_items'] as $menu) {
            $title = wp_kses($menu['item_title'], array());
            echo <<<HTML
            <div class="col-sm-4 col-md-3 go-now-card-item">
            <a href="{$this->format_urls_to_shortcode($menu)}" target="_{$settings['link_target']}" rel="{$settings['link_rel']}">
                <div class="go-now-card-imgbox">
                    <img src="{$menu['item_icon']['url']}"/>
                </div>
                <div class="go-now-card-comment">
                    <div class="go-now-card-comment-name go-now-card-clip-words">
                        <strong>$title</strong>
                    </div>
                    <p class="go-now-card-comment-describ go-now-card-clip-words">{$menu['item_description']}</p>
                </div>
            </a>
            </div>
HTML;
        }
        echo "</div>";
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template()
    {
        ?>
<!--        <#-->
<!--        view.addInlineEditingAttributes( 'title', 'none' );-->
<!--        view.addInlineEditingAttributes( 'description', 'basic' );-->
<!--        view.addInlineEditingAttributes( 'content', 'advanced' );-->
<!--        #>-->
<!--        <h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>-->
<!--        <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>-->
<!--        <div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div>-->
        <?php
    }

    /**
     * Format different url links to shortcode.
     * @return string
     */
    protected function format_urls_to_shortcode($menu) {
        return do_shortcode("[go_now_card default='{$menu['item_url']['url']}' android='{$menu['item_android_url']['url']}' iphone='{$menu['item_iphone_url']['url']}' weixin='{$menu['item_weixin_url']['url']}']");
    }
}
