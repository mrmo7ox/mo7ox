<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mo7ox
 */

 get_header();
?>


<div class="w-full flex justify-center items-center mt-8 mb-12 h-[300px]">
  <?php
$args_posts = array(
    'post_type'      => 'post',
    'posts_per_page' => 4,  
    'orderby'        => 'date', 
    'order'          => 'DESC' 
);

$posts_query = new WP_Query($args_posts);

if ($posts_query->have_posts()) {
    $posts = array();
    $count = 0;

    while ($posts_query->have_posts()) {
        $posts_query->the_post();
         $title = get_the_title(); 
              if (strlen($title) >= 40) {
                  $title = substr($title, 0, 40) . '...';
              } 
        $posts[$count] = array(
            'title' => $title,
            'img'   => get_the_post_thumbnail(),
            'link'  => get_the_permalink(), 
        );
        $count++;
    }
?>
<div class="grid grid-cols-3 grid-rows-2 gap-4 w-[90%] h-full">
    <a href="<?php echo $posts[0]['link']; ?>" id="post_fire" class="vissted:text-white row-span-2 relative">
        <?php echo $posts[0]['img']; ?>
        <div class="absolute w-full h-full top-0 flex flex-col justify-center items-center" >
          <div class="w-[90%] h-[80%] text-start">
          </div>
          <div class="w-[90%] h-[20%] text-start text-white Poppins">
            <?php echo $posts[0]['title']; ?>
          </div>
        </div>
    </a>
    <a href="<?php echo $posts[1]['link']; ?>" id="post_fire" class="vissted:text-white row-span-2 relative">
        <?php echo $posts[1]['img']; ?>
        <div class="absolute w-full h-full top-0 flex flex-col justify-center items-center" >
          <div class="w-[90%] h-[80%] text-start">
          </div>
          <div class="w-[90%] h-[20%] text-start text-white Poppins">
            <?php echo $posts[1]['title']; ?>
          </div>
        </div>
    </a>
    <a href="<?php echo $posts[2]['link']; ?>" id="post_fire" class="vissted:text-white relative">
        <?php echo $posts[2]['img']; ?>
        <div class="absolute w-full h-full top-0 flex flex-col justify-center items-center" >
          <div class="w-[90%] h-[80%] text-start">
          </div>
          <div class="w-[90%] h-[20%] text-start text-white Poppins">
            <?php echo $posts[2]['title']; ?>
          </div>
        </div>
    </a>
    <a href="<?php echo $posts[3]['link']; ?>" id="post_fire" class="vissted:text-white col-start-3 relative">
        <?php echo $posts[3]['img']; ?>
        <div class="absolute w-full h-full top-0 flex flex-col justify-center items-center" >
          <div class="w-[90%] h-[80%] text-start">
          </div>
          <div class="w-[90%] h-[20%] text-start text-white Poppins">
            <?php echo $posts[3]['title']; ?>
          </div>
        </div>
    </a>
   
</div>

<?php 
} else {
    echo 'No posts found.';
}

wp_reset_postdata();
?>

</div>

<div class="w-full mt-4 flex justify-center items-center">
  <span class="Poppins flex justify-start items-center w-[90%]">
    <h1 class="text-white text-[25px]"> <i class="fa-solid fa-compact-disc"></i> Courses</h1>
  </span>
</div>
<div class="flex justify-center items-center h-[500px]">
  <?php
  $args_courses = array(
      'post_type'      => 'courses',
      'posts_per_page' => 10,  
      'orderby'        => 'date', 
      'order'          => 'DESC' 
  );
  $courses_query = new WP_Query($args_courses);

  if ($courses_query->have_posts()) :
  ?>
      <div class="swiper mySwiper flex h-full w-[90%]">
        <div class="swiper-wrapper">
          <?php while ($courses_query->have_posts()) : $courses_query->the_post(); ?>
          <?php  $color = get_post_meta(get_the_ID(), '_mo7ox_course_color', true) ?: 'orange-100'; ?>
          <?php  
              $title = get_the_title(); 
              if (strlen($title) >= 40) {
                  $title = substr($title, 0, 40) . '...';
              } 
              ?>
            <div class="swiper-slide h-full">
              <?php if (has_post_thumbnail()) : ?>
                <a href="<?php echo the_permalink(); ?>" class="hover:scale-[0.97] duration-200 transtion-all course-thumbnail h-[80%] shadow-xl relative">
                  <?php the_post_thumbnail(); ?>
                  <div id="img_slider" class="absolute inset-0 bg-gradient-to-t from-[<?php echo esc_attr($color); ?>] to-transparent"></div>
                  <div id="slider_title" class="justify-center items-center top-0 Poppins w-full h-full  text-white absolute flex flex-col">
                     <div class="h-[80%]"></div>
                     <div class="h-[20%] flex w-[95%] text-start"><?php echo $title; ?></div>
                    </div>
                  
                  </a>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
  <?php
      wp_reset_postdata();
  else :
      echo '<p>' . esc_html__('No courses found.', 'mo7ox') . '</p>';
  endif;
  ?>

 <!-- Swiper -->



<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
   var swiper = new Swiper(".mySwiper", {
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 15,
        },
        768: {
          slidesPerView: 4,
          spaceBetween: 15,
        },
        1024: {
          slidesPerView: 6,
          spaceBetween: 15,
        },
      },
    });
</script>
    
</div>

<div class="w-full flex justify-center items-center">
  <span class="Poppins flex justify-start items-center w-[75%]">
    <h1 class="text-white text-[25px]"> <i class="fa-solid fa-gamepad"></i> CTF's</h1>
  </span>
</div>
<!-- // ctfs -->
<div class="w-full flex justify-center items-center h-[200px] my-6">
  <div class="w-[75%] h-full grid grid-cols-5 gap-5">
    <?php
    $args_courses = array(
        'post_type'      => 'Ctfs',
        'posts_per_page' => 5,  
        'orderby'        => 'date', 
        'order'          => 'DESC' 
    );
    $courses_query = new WP_Query($args_courses);
    if ($courses_query->have_posts()) :
    ?>
            <?php while ($courses_query->have_posts()) : $courses_query->the_post(); ?>      
              <div class="h-[200px]">
                <?php if (has_post_thumbnail()) : ?>
                  <a id="ctf_holder" href="<?php the_permalink(); ?>" class="h-[200px] h-full shadow-xl hover:scale-[0.97]  duration-200 transtion-all bg-[#222229] rounded-md w-full h-full justify-center items-center flex">
                    <?php the_post_thumbnail(); ?>                    
                  </a>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          </div>
    <?php
        wp_reset_postdata();
    else :
        echo '<p>' . esc_html__('No courses found.', 'mo7ox') . '</p>';
    endif;
    ?>
  </div>
</div>

<div class="w-full flex justify-center items-center">
  <span class="Poppins flex justify-start items-center w-[75%]">
    <h1 class="text-white text-[25px]"> <i class="fa-solid fa-screwdriver-wrench"></i> Tools</h1>
  </span>
</div>

<!-- tools -->
<div class="w-full flex justify-center items-center  my-6">
  <div class="w-[75%] h-full grid grid-cols-5 gap-5">
    <?php
    $args_courses = array(
        'post_type'      => 'Tools',
        'posts_per_page' => 15,  
        'orderby'        => 'date', 
        'order'          => 'DESC' 
    );
    $courses_query = new WP_Query($args_courses);
  
    if ($courses_query->have_posts()) :
    ?>
            <?php while ($courses_query->have_posts()) : $courses_query->the_post(); ?>      
              <div class="h-full">
                <?php if (has_post_thumbnail()) : ?>
                  <a id="tool_holder" href="<?php the_permalink(); ?>" class="h-full shadow-xl hover:scale-[0.97]  duration-200 transtion-all bg-[#222229] rounded-md w-full h-full justify-center items-center flex">
                    <?php the_post_thumbnail(); ?>                    
                  </a>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          </div>
    <?php
        wp_reset_postdata();
    else :
        echo '<p>' . esc_html__('No courses found.', 'mo7ox') . '</p>';
    endif;
    ?>
  </div>
</div>

<?php get_footer(); ?>
