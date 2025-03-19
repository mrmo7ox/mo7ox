<?php
/**
 * Template Name: Bcamps Page
 */

get_header(); 
?>

<div class="w-full mt-4 flex justify-center items-center">
    <span class="Poppins flex justify-center items-center w-[90%]">
        <h1 class="text-center text-white text-[25px]">
        <i class="fa-solid fa-compass"></i>  BOOT CAMPS
        </h1>
    </span>
</div>

<main class="w-full flex justify-center items-center my-4 flex-col">
    <div class="course-list grid  min-[2400px]:grid-cols-8  min-[1700px]:grid-cols-6 min-[1000px]:grid-cols-4 min-[800px]:grid-cols-3 grid-cols-2 w-[80%] gap-5">
        <?php
        // Get the current page number
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Create a new WP_Query with pagination
        $courses = new WP_Query(array(
            'post_type'      => 'Bcamps',
            'paged'          => $paged,
        ));

        if ($courses->have_posts()) :
            while ($courses->have_posts()) : $courses->the_post();
                $title = get_the_title();
                
                // Truncate title if it's too long
                if (strlen($title) >= 40) {
                    $title = substr($title, 0, 40) . '...';
                }
        ?>
                <div class="course-item">
                    <a id="ctf_holder" href="<?php the_permalink(); ?>" class=" h-[200px] h-full shadow-xl hover:scale-[0.97]  duration-200 transtion-all bg-[#222229] rounded-md w-full h-full justify-center items-center flex">
                    <?php the_post_thumbnail(); ?>                    
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
        wp_reset_postdata();
        ?>
    </div>
</main>

<?php get_footer(); ?>
