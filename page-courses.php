<?php get_header(); ?>

<main class="container">
    <h1>All fff</h1>
    <div class="course-list">
        <?php
        // Get the current page number
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Create a new WP_Query with pagination
        $courses = new WP_Query(array(
            'post_type'      => 'Courses',
            'posts_per_page' => 1, // Change this to the number of posts you want per page
            'paged'          => $paged
        ));

        if ($courses->have_posts()) :
            while ($courses->have_posts()) : $courses->the_post();
        ?>
                <div class="course-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>
                        <h2><?php the_title(); ?></h2>
                    </a>
                </div>
        <?php
            endwhile;

            // Pagination
            $big = 999999999; // an unlikely integer
            $pagination_args = array(
                'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'             => '?paged=%#%',
                'current'            => max(1, get_query_var('paged')),
                'total'              => $courses->max_num_pages,
                'prev_text'          => __('« Previous'),
                'next_text'          => __('Next »'),
                'type'               => 'plain',
            );
            echo paginate_links($pagination_args);

            wp_reset_postdata();
        else :
            echo '<p>No courses found.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
