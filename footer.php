<?php
/**
 * @package Serene
 * @since Serene 1.0
 * Child Theme: So There's That
 */
?>
		<footer id="main-footer">
			<?php get_sidebar( 'footer' ); ?>
			<p id="footer-info">
				<small><a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress. </a>
				<?php printf( __( 'Theme "%1$s" based on Serene by %2$s. Site design by <a href="http://www.davidkissinger.com">David Kissinger</a>.', 'Serene' ), 'So There\'s That', '<a href="http://www.elegantthemes.com/" rel="designer">Elegant Themes</a>' ); ?></small>
				<br/><small>&copy; 2014-15 by Charla Avery and David Kissinger. All rights reserved.</small>
			</p>
		</footer> <!-- #main-footer -->
	</div> <!-- #container -->

	<?php wp_footer(); ?>
</body>
</html>