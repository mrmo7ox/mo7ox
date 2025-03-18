<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mo7ox
 */

?>

	<footer class=" flex justify-center  items-center bg-[#141418] w-full h-[250px]">
		<div class="w-[75%] grid grid-cols-3">
			<div class=" text-white flex gap-4 flex-col justify-between items-start Poppins h-[90%] ">
				<h1 class=""><i class="text-[#FF9500] fa-brands fa-web-awesome"></i> <?php echo esc_html(get_the_author_meta('login', 1));?></h1>
				<p class="text-[12px] w-[20ch]"><?php
					echo esc_html(get_the_author_meta('description', 1));
					?></p>
				</div>
				<div class="flex flex-col justify-between items-center">
					<span class=" Poppins text-white"><i class="fa-solid fa-link"></i> Links</span>
					<?php wp_nav_menu(array(
						'theme_location' => 'main-menu', 
						'container' => 'nav', 
						'menu_class' => 'visited:text-white links', 

					)); ?>

				</div>
				<div class="flex flex-col justify-center items-center">
						<div class="Poppins text-white">Follow me</div>
						<div><?php mo7ox_display_social_links(); ?></div>
					
				</div>
			</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
