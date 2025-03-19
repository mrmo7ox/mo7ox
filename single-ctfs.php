
<?php get_header(); ?>
<main class="container w-full flex justify-center items-center my-4 flex-col">
    <div class="course-list grid grid-cols-6 w-[80%] gap-5">
<?php
$course_id = get_the_ID(); 
$course = get_post($course_id);

// Fetch linked courses
$linked_course_details = mo7ox_get_ctf_details($course_id);

if ($linked_course_details) {
    foreach ($linked_course_details as $detail) {
        if (is_numeric($detail)) {
            $detail = get_post($detail);
        }
        setup_postdata($detail);
        ?>
        <div class="course-item">
            <a id="tool_holder" href="<?php echo get_permalink($detail); ?>" class="h-full shadow-xl hover:scale-[0.97] duration-200 transition-all bg-[#222229] rounded-md w-full h-full justify-center items-center flex">
                <?php echo get_the_post_thumbnail($detail, 'full'); ?>                  
            </a>
        </div>
        <?php
    }
    wp_reset_postdata(); // Reset post data
} else {
    echo '<p>No linked course details found.</p>';
}
?>        
    </div>
</main>

<script>
    function next(el) {
        const media_player = document.getElementById("media_player");
        if (media_player) {
            media_player.src = el.getAttribute('video');
        }
    }
</script>

<?php get_footer(); ?>
