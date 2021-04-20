<?php 
function the_conference_ed_wp_link(){
        return;
        /* translators: 1: span tag, 2: WordPress link */
        printf( esc_html__( '%1$s Powered by %2$s%3$s', 'the-conference' ), '<span class="wp-link">', '<a href="'. esc_url( __( 'https://wordpress.org/', 'the-conference' ) ) .'" target="_blank">WordPress</a>.', '</span>' );
}

function the_conference_ed_author_link(){    
    return;
    echo '<span class="author-link">' . esc_html__( 'The Conference | Developed by ', 'the-conference' ) . '<a href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Theme', 'the-conference' ) . '</a></span>';
}