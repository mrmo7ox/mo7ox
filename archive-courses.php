<?php get_header(); ?>

<div class="w-full mt-4 flex justify-center items-center">
    <span class="Poppins flex justify-center items-center w-[90%]">
        <h1 class="text-center text-white text-[25px]">
            <i class="fa-solid fa-compact-disc"></i> Courses
        </h1>
    </span>
</div>

<main class="container w-full flex justify-center items-center my-4 flex-col">
    <div class="course-list grid grid-cols-4 w-[80%] gap-5">
        <?php
        // Get the current page number
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Create a new WP_Query with pagination
        $courses = new WP_Query(array(
            'post_type'      => 'Courses',
            'paged'          => $paged,
        ));

        if ($courses->have_posts()) :
            while ($courses->have_posts()) : $courses->the_post();
                $color = get_post_meta(get_the_ID(), '_mo7ox_course_color', true) ?: 'orange-100';
                $title = get_the_title();
                
                // Truncate title if it's too long
                if (strlen($title) >= 40) {
                    $title = substr($title, 0, 40) . '...';
                }
        ?>
                <div class="course-item">
                    <a href="<?php the_permalink(); ?>" class="hover:scale-[0.97] duration-200 transition-all course-thumbnail h-[80%] shadow-xl relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>
                        <div id="img_slider" class="absolute inset-0 bg-gradient-to-t from-[<?php echo esc_attr($color); ?>] to-transparent"></div>
                        <div id="slider_title" class="justify-center items-center top-0 Poppins w-full h-full text-white absolute flex flex-col">
                            <div class="h-[80%]"></div>
                            <div class="h-[20%] flex w-[95%] text-start"><?php echo esc_html($title); ?></div>
                        </div>
                    </a>
                </div>
        <?php
            endwhile; // End of the while loop
        else : // Check if there are no posts
            echo '<p>No courses found.</p>';
        endif; // End of the if condition
        ?>
    </div>

    <div id="pag" class="flex justify-center items-center gap-2 mt-4">
        <?php
        // Pagination
        if ($courses->max_num_pages > 1) { 
            $big = 999999999; 
            $pagination_args = array(
                'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'             => '?paged=%#%',
                'current'            => max(1, get_query_var('paged')), 
                'total'              => $courses->max_num_pages,
                'type'               => 'plain',
                'mid_size'           => 1,
                'end_size'           => 1, 
                'show_all'           => false,
                'add_args'           => false, 
            );

            // Generate the pagination links
            echo paginate_links($pagination_args);
        }
        wp_reset_postdata(); // Reset post data after the loop
        ?>
    </div>
</main>

<?php get_footer(); ?>
