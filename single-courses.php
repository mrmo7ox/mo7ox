<?php get_header(); ?>

<?php
$course_id = get_the_ID(); 
$course = get_post($course_id);

$linked_course_details = mo7ox_get_course_details($course_id);

?>
<div class="course-page w-full flex justify-center items-center my-8 h-[600px] flex-col bg-white">
    <?php
    $first_video_url = !empty($linked_course_details) ? get_post_meta($linked_course_details[0]->ID, '_mo7ox_course_video_url', true) : '';
    ?>

<iframe id="media_player" width="1361" height="771" src="<?php echo esc_url($first_video_url); ?>" 
        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
</iframe>
</div>
<div class="course-page w-full flex justify-center items-center my-8 h-[700px] flex-col">
    <div class=" gap-10 w-[90%] flex justify-center items-center h-full">
        <div class="scrool h-[700px]  block flex-col bg-white w-[50%] justify-center items-center rounded-md h-full overflow-y-auto"> <!-- Add overflow-y-auto here -->
            <?php
            if ($linked_course_details) {
                foreach ($linked_course_details as $detail) {
                    $video_url = get_post_meta($detail->ID, '_mo7ox_course_video_url', true);

                    echo '<div  onclick="next(this)" video="' . esc_html($video_url) .'" class="cursor-pointer  hover:scale-[0.99]  duraction-100 transition-all visited:text-white flex text-white Poppins justify-start px-4 items-center shadow-xl my-4 w-[99%] hover:bg-[#232329] bg-[#141418] h-[70px] rounded-full">
                    '. esc_html($detail->post_title) .'</div>'; 
                }
            } else {
                echo '<p>No linked course details found.</p>';
            }

            ?>
        </div>
        <div class="bg-[#232329] flex w-[50%] justify-center items-center rounded-md h-full gap-4">
            <div class="w-[90%] h-full flex justify-start items-start flex-col">
                <h3 class="h-[10%] flex justify-start items-center Poppins gap-2 text-[25px] text-[#FF9500]"><i class="fa-solid fa-note-sticky"></i>Notes</h3>
                <textarea name="" id="" class="w-full h-[80%] outline-none p-2 Poppins"></textarea>
            </div>
        </div>
    </div>
</div>
<script>
    function next(el)
    {
        const media_player = document.getElementById("media_player");
        if (media_player)
        {
        
           media_player.src = el.getAttribute('video');
            el.ClassName
        }
    }
</script>
<?php get_footer(); ?>
