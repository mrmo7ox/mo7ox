<?php get_header(); ?>
<?php
$args_posts = array(
    'post_type'      => 'ctf_details',
    'posts_per_page' => 5,  
    'orderby'        => 'date', 
    'order'          => 'DESC' 
);

$posts_query = new WP_Query($args_posts);


?>
<main class="w-full flex justify-center items-center my-8">
    <div class="w-[90%]  flex md:flex-row flex-col-reverse justify-start items-start gap-8">
        <div class="md:w-[30%] w-[100%] flex flex-col">
            <div class="flex justify-start items-center p-4  h-[110px]">
                <div class="shadow-2xl flex justify-center items-center text-center bg-red-500 Poppins w-full rounded-full  gap-1 text-white p-4">
                    <span class=" w-full  rounded-xl"> <i class="fa-solid fa-fire"></i> NEW!!</span>
                </div>
            </div>
        
            <div class="flex justify-start items-start p-4 ">
                <div class="gap-4 flex-col shadow-xl flex justify-start items-start text-center bg-[#141418] Poppins w-full rounded-xl  gap-1 text-white p-4">
                <?php 
                    if ($posts_query->have_posts()) {
                        while ($posts_query->have_posts()) {
                            $posts_query->the_post();
                            $title = get_the_title(); 
                                if (strlen($title) >= 20) 
                                {
                                    $title = substr($title, 0, 40) . '...';
                                }
                            ?>
                            <a id="a_bcamp_details" href="<?php echo get_the_permalink() ?>" class="hover:scale-[0.97] duration-100 transtion-all h-[100px] justify-start items-center w-full flex visited:text-white bg-[#2b2b33] w-full  rounded-xl">
                                <div id="fire_bcamp_details" class="w-[40%] h-full" >
                                    <?php echo get_the_post_thumbnail() ?>
                                </div>
                                <h1 class="w-[60%]">
                                    <?php echo $title ?>
                                </h1>
                            </a>
                        <?
                        }
                    }
                    wp_reset_postdata();

                ?>
                </div>
            </div>
        
        </div>
        <div class="md:w-[70%] w-[100%] ">  
             <!-- title -->
            <div class="shadow-xl p-4 bg-[#141418] Poppins w-full rounded-xl flex gap-4 h-[110px]">
                <div id="bcamp_details" class="w-[110px] h-full"><?php the_post_thumbnail(); ?></div>
                <div class="w-[30%] flex flex-col justify-around items-start">
    
                    <h1 class="text-[#ff5885] mr-2">
                        <i class="fa-solid fa-thumbtack mr-1"></i> <?php echo get_the_title(); ?>
                    </h1>
                    <h1 class="text-[#ff5885] mr-2">
                        <i class="fa-solid fa-user mr-1"></i> <?php echo get_the_author() ?: "mo7ox"; ?>
                    </h1>
                    <h1 class="text-[#ff5885] mr-2">
                        <i class="fa-solid fa-calendar-days mr-1"></i> <?php echo get_the_date() ?: "Today"; ?>
                    </h1>
                </div>
                
            </div>
            <!-- description -->
            <div id="description_bcamp" class="shadow-xl my-4  bg-[#141418] p-8 rounded-2xl">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
