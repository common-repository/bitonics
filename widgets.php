<?php

/**
Copyright 2018 at Bitonics.net (email: info@bitonics.net)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function bitonics_register_widgets() {
    register_widget( 'Bitonics_Logo_Widget' );
    register_widget( 'Bitonics_CMC_Widget' );
}
add_action( 'widgets_init', 'bitonics_register_widgets' );

class Bitonics_Logo_Widget extends WP_Widget
{
    function Bitonics_Logo_Widget() {
        parent::__construct(
            'Bitonics_Logo_Widget',
            'Bitonics',
            array( 'description' => __( 'Widget for Bitonics logo.', 'bitonics' ) )
        );
    }

    function widget( $args, $instance ) {
        $filename = BITONICS_PLUGIN_DIR . '_inc/img/bitonics-logo.svg';
        if ( file_exists($filename) ) {
            $title = esc_attr( $instance['title'] );
            if ( strlen($title) === 0 ) {
                $title = BITONICS_WIDGET_TITLE;
            }
            $color = esc_attr( $instance['color'] );
            if ( strlen($color) === 0 ) {
                $color = BITONICS_WIDGET_LOGO_COLOR;
            }
            echo $args['before_widget'];
            echo '<h2 class="widget-title">' . $title . '</h2>';
            echo '<p>';
            echo '<a href="' . BITONICS_HOME . '" target="_blank">';
            echo str_replace( '#000', $color, file_get_contents(BITONICS_PLUGIN_URL . '_inc/img/bitonics-logo.svg') );
            echo '</a>';
            echo '</p>';
            echo $args['after_widget'];
        }
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['color'] = strip_tags( $new_instance['color'] );
        return $instance;
    }

    function form( $instance ) {
        $title = '';
        $color = '';

        if ( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Powered by Bitonics', 'bitonics' ) ) );
            $title = esc_attr( $instance['title'] );
            $color = esc_attr( $instance['color'] );
        }

        if ( strlen($title) === 0 ) {
            $title = BITONICS_WIDGET_TITLE;
        }
        if ( strlen($color) === 0 ) {
            $color = BITONICS_WIDGET_LOGO_COLOR;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bitonics' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Color:', 'bitonics' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo $color; ?>" />
        </p>

    <?php }
}

class Bitonics_CMC_Widget extends WP_Widget
{
    function Bitonics_CMC_Widget() {
        parent::__construct(
            'Bitonics_CMC_Widget',
            'Bitonics',
            array( 'description' => __( 'Widget for Bitonics CMC.', 'bitonics' ) )
        );
    }

    function widget( $args, $instance ) {
        if ( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Powered by Bitonics', 'bitonics' ) ) );
            $title = esc_attr( $instance['title'] );
            $code = esc_attr( $instance['code'] );
        }
        $title = esc_attr( $instance['title'] );
        if ( strlen($title) === 0 ) {
            $title = BITONICS_WIDGET_TITLE;
        }
        $code = esc_attr( $instance['code'] );
        if ( strlen($code) === 0 ) {
            $code = BITONICS_WIDGET_CMD_CODE;
        }
        $html = '<script type="text/javascript" src="https://bitonics.net/vendor/coinmarketcap/widget.js"></script><div class="coinmarketcap-currency-widget" data-currency="' . $code . '" data-base="USD" data-secondary="" data-ticker="true" data-rank="true" data-marketcap="true" data-volume="true" data-stats="USD" data-statsticker="false"></div>';
        echo $args['before_widget'];
        echo '<h2 class="widget-title">' . $title . '</h2>';
        echo '<p>';
        echo $html;
        echo '</p>';
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['code'] = strip_tags( $new_instance['code'] );
        return $instance;
    }

    function form( $instance ) {
        $title = '';
        $code = '';

        if ( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Powered by Bitonics', 'bitonics' ) ) );
            $title = esc_attr( $instance['title'] );
            $code = esc_attr( $instance['code'] );
        }

        if ( strlen($title) === 0 ) {
            $title = BITONICS_WIDGET_TITLE;
        }
        if ( strlen($code) === 0 ) {
            $code = BITONICS_WIDGET_CMD_CODE;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bitonics' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'code' ); ?>"><?php _e( 'Code:', 'bitonics' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'code' ); ?>" name="<?php echo $this->get_field_name( 'code' ); ?>" type="text" value="<?php echo $code; ?>" />
        </p>

    <?php }
}
