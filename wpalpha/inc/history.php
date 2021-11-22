<?php
/**
 * History of theme
 *
 * Here, you can add or remove whats new content and change log.
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

if ( empty( $history_type ) ) {
	return;
}

// What's New Section
if ( 'whatsnew' == $history_type ) {
	?>
	<div class="alpha-whatsnew-item">
		<h3 class="alpha-item-title"><?php printf( esc_html__( 'Step into WordPress %1$s5.7.1%2$s', 'alpha' ), '<span class="text-primary">', '</span>' ); ?></h3>
		<p class="alpha-item-desc">
		<?php
		echo esc_html__(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore ctetur adipis
magna aliqua. Venenatis tellus in metus vulputate eu scelerisque felis. Vel pretium lectus quam id leo in vitae us in metus vulpu
turpis massa. Nunc id cursus metus aliquam. Libero id faucibus nisl tincidunt eget. Aliquam id diam maecenas ero id fauci
ultricies mi eget mauris.',
			'alpha'
		);
		?>
		</p>
	</div>
	<div class="alpha-whatsnew-item">
		<h4 class="alpha-item-title"><?php echo esc_html__( 'Maintenance and Security Releases', 'alpha' ); ?></h4>
		<p class="alpha-item-desc">
		<?php
		printf(
			esc_html__(
				'Version 5.7.1 addressed some security issues and fixed 26 bugs. For more information, see %1$sthe release notes%2$s.',
				'alpha'
			),
			'<a href="#">',
			'</a>'
		);
		?>
		</p>
	</div>
	<div class="alpha-whatsnew-item">
		<h4 class="alpha-item-title"><?php echo esc_html__( 'Maintenance and Security Releases', 'alpha' ); ?></h4>
		<p class="alpha-item-desc">
		<?php
		printf(
			esc_html__(
				'Version 5.7.1 addressed some security issues and fixed 26 bugs. For more information, see %1$sthe release notes%2$s.',
				'alpha'
			),
			'<a href="#">',
			'</a>'
		);
		?>
		</p>
	</div>
	<?php
} elseif ( 'changelog' == $history_type ) {
	?>
	<div class="alpha-changelog" id="log2">
		<h4 class="alpha-release-version"><?php echo esc_html__( 'Version 2.0 (14th November 2020)', 'alpha' ); ?></h4>
		<h5 class="alpha-log-title"><i class="fas fa-star"></i><?php echo esc_html__( 'New Features', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-undo-alt"></i><?php echo esc_html__( 'Changes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-bug"></i><?php echo esc_html__( 'Bugfixes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et aliqua dolore magna dolore magna.</li>
		</ul>
	</div>
	<div class="alpha-changelog" id="log1_2">
		<h4 class="alpha-release-version"><?php echo esc_html__( 'Version 1.2 (14th November 2020)', 'alpha' ); ?></h4>
		<h5 class="alpha-log-title"><i class="fas fa-star"></i><?php echo esc_html__( 'New Features', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-undo-alt"></i><?php echo esc_html__( 'Changes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-bug"></i><?php echo esc_html__( 'Bugfixes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et aliqua dolore magna dolore magna.</li>
		</ul>
	</div>
	<div class="alpha-changelog" id="log1_1">
		<h4 class="alpha-release-version"><?php echo esc_html__( 'Version 1.1 (14th November 2020)', 'alpha' ); ?></h4>
		<h5 class="alpha-log-title"><i class="fas fa-star"></i><?php echo esc_html__( 'New Features', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-undo-alt"></i><?php echo esc_html__( 'Changes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-bug"></i><?php echo esc_html__( 'Bugfixes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor et dolore magna aliqua.</li>
		</ul>
	</div>
	<div class="alpha-changelog" id="log1">
		<h4 class="alpha-release-version"><?php echo esc_html__( 'Version 1.0 (14th November 2020)', 'alpha' ); ?></h4>
		<h5 class="alpha-log-title"><i class="fas fa-star"></i><?php echo esc_html__( 'New Features', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-undo-alt"></i><?php echo esc_html__( 'Changes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
		</ul>
		<h5 class="alpha-log-title"><i class="fas fa-bug"></i><?php echo esc_html__( 'Bugfixes', 'alpha' ); ?></h5>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et aliqua dolore magna dolore magna.</li>
		</ul>
	</div>
	<?php
} elseif ( 'changelog_menu' == $history_type ) {
	?>
	<ul class="alpha-log-versions">
		<li class="alpha-log-version active"><a href="#log2">Version 2.0</a></li>
		<li class="alpha-log-version"><a href="#log1_2">Version 1.2</a></li>
		<li class="alpha-log-version"><a href="#log1_1">Version 1.1</a></li>
		<li class="alpha-log-version"><a href="#log1">Version 1.0</a></li>
	</ul>
	<?php
}
