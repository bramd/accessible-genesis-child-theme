<?php
/**
 * Template Name: Sitemap
 * This file handles the sitemap fot the HVO theme.
 *
 * @category WPACC
 * @package  Templates
 * @author   Rian Rietveld
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.rrwd.nl
 */

/** Remove default loop **/
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'wpacc_sitemap' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function wpacc_sitemap() { ?>

	<div class="post hentry">

		<h1 class="entry-title"><?php the_title() ?></h1>
		<div class="entry-content">

			<div class="archive-page">

				<h2><?php _e( 'Pages:', 'genesis' ); ?></h2>
				<ul>
					<?php wp_list_pages( 'title_li=' ); ?>
				</ul>

				<h2><?php _e( 'Categories:', 'genesis' ); ?></h2>
				<ul>
					<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
				</ul>

			</div><!-- end .archive-page-->

			<div class="archive-page">

				<h2><?php _e( 'Authors:', 'genesis' ); ?></h2>
				<ul>
					<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
				</ul>

				<h2><?php _e( 'Monthly:', 'genesis' ); ?></h2>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>

				<h2><?php _e( 'Recent Posts:', 'genesis' ); ?></h2>
				<ul>
					<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
				</ul>

			</div><!-- end .archive-page-->

		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

genesis();
