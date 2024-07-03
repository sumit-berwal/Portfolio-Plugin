<?php
/*
Template Name: Custom Portfolio Template
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div>
            <?php
            $args = array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) { 
                    $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-item' ); ?>>
                        <header class="entry-header">
                            <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                    <?php
                }
                wp_reset_postdata();
            }else{
                echo '<p>No portfolios found.</p>';
            }
            ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>
