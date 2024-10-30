<?php
/*
Plugin Name: JQuery Accessible Carousel
Plugin URI: http://wordpress.org/extend/plugins/jquery-accessible-carousel/
Description: WAI-ARIA Enabled Carousel Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'SimpleImage.php';

add_action("plugins_loaded", "JQueryAccessibleCarousel_init");
function JQueryAccessibleCarousel_init() {
    register_sidebar_widget(__('JQuery Accessible Carousel'), 'widget_JQueryAccessibleCarousel');
    register_widget_control(   'JQuery Accessible Carousel', 'JQueryAccessibleCarousel_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_JQueryAccessibleCarousel') ) {
        wp_register_style('jquery.ui.all', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jquery-ui/themes/base/jquery.ui.all.css'));
        wp_enqueue_style('jquery.ui.all');

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('jquery-1.6.4', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jquery-ui/jquery-1.6.4.js'));
        wp_enqueue_script('jquery-1.6.4');

        wp_register_script('jquery.ui.core.js', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jquery-ui/ui/jquery.ui.core.js'));
        wp_enqueue_script('jquery.ui.core.js');

        wp_register_script('jquery.ui.widget', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jquery-ui/ui/jquery.ui.widget.js'));
        wp_enqueue_script('jquery.ui.widget');

        wp_register_script('jquery.carousel', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jcarousel/lib/jquery.jcarousel.js'));
        wp_enqueue_script('jquery.carousel');

        wp_register_style('demos', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jquery-ui/demos.css'));
        wp_enqueue_style('demos');

        wp_register_script('JQueryAccessibleCarousel', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/JQueryAccessibleCarousel.js'));
        wp_enqueue_script('JQueryAccessibleCarousel');

        wp_register_style('tango', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-carousel/lib/jcarousel/skins/tango/skin.css'));
        wp_enqueue_style('tango');
    }
}

function widget_JQueryAccessibleCarousel($args) {
    extract($args);

    $options = get_option("widget_JQueryAccessibleCarousel");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Carousel'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    JQueryAccessibleCarouselContent();
    echo $after_widget;
}

function JQueryAccessibleCarouselContent() {
    $image = new SimpleImage();
    $dir = 'wp-content/plugins/jquery-accessible-carousel/lib/images/';
    $images = $image->getImages($dir);
    $imagesCount = count($images);
    for ($i = 0; $i <= $imagesCount; $i = $i + 1) {
        $imageName = $images[$i];
        if (!is_dir($imageName)) {
            $index = strpos(strtolower($imageName), ".jpg");
            $extension = '.jpg';
            if ($index === false) {
                $index = strpos(strtolower($imageName), ".png");
                $extension = '.png';
                if ($index === false) {
                    $index = strpos(strtolower($imageName), ".gif");
                    $extension = '.gif';
                }
            }
            if ($index === false) {

            } else {
                $index2 = strpos($imageName, "_150x150_JQueryAccessibleCarousel.");
                if ($index2 === false) {
                    $imageName2 = substr($imageName, 0, $index) . '_150x150_JQueryAccessibleCarousel' . $extension;
                    if (!file_exists($imageName2)) {
                        $alt = str_replace("_", " ", substr($imageName, 0, $index));
                        $image->load($dir . $imageName);
                        $image->resize(150, 150);
                        $image->save($dir . $imageName2);
                    }
                    if ($i == 0) {
                        echo '<div class="demo" role="application">
                            <div class="viewer" align="left">
                                <img id="viewerImgAccessible" alt="' . $alt . '" src="' . $dir . $imageName2 . '" width="250" height="250" />
                            </div>
                            <ul id="mycarouselAccessible" class="jcarousel-skin-tango">';
                    }
                    echo '<li>
                    <img src="' . $dir . $imageName2 . '" width="100" height="100" alt="' . $alt . '" />
                    </li>';
                }
            }
        }
    }

    echo '</ul>
          </div>';
}

function JQueryAccessibleCarousel_control() {
    $options = get_option("widget_JQueryAccessibleCarousel");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Carousel'
        );
    }

    if ($_POST['JQueryAccessibleCarousel-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['JQueryAccessibleCarousel-WidgetTitle']);
        update_option("widget_JQueryAccessibleCarousel", $options);
    }
    ?>
    <p>
        <label for="JQueryAccessibleCarousel-WidgetTitle">Widget Title: </label>
        <input type="text" id="JQueryAccessibleCarousel-WidgetTitle" name="JQueryAccessibleCarousel-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="JQueryAccessibleCarousel-SubmitTitle" name="JQueryAccessibleCarousel-SubmitTitle" value="1" />
    </p>
    
    <?php
}

?>
