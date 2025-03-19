<?php
/**
 * Template Name: Tools Page
 */

get_header(); 
?>

<main class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-6"><?php the_title(); ?></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $tools_query = new WP_Query([
            'post_type'      => 'tools',  // Change 'tools' to your custom post type
            'posts_per_page' => -1,
        ]);

        if ($tools_query->have_posts()) :
            while ($tools_query->have_posts()) : $tools_query->the_post(); 
                $tool_color = get_post_meta(get_the_ID(), 'tool_color', true) ?: 'blue-500';
        ?>
            <div class="p-6 bg-<?php echo esc_attr($tool_color); ?> text-white rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold"><?php the_title(); ?></h2>
                <p class="mt-2"><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="block mt-4 text-white underline">View Tool</a>
            </div>
        <?php 
            endwhile; 
            wp_reset_postdata();
        else :
            echo '<p class="text-center">No tools found.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
