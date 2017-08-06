<!DOCTYPE html>
<html class="js" lang="<?php echo $Site->language() ?>">

	<head profile="http://gmpg.org/xfn/11">
		<?php include(THEME_DIR_PHP.'head.php') ?>
	</head>
	
	<?php
		if( $WHERE_AM_I=='home' )
		{
			echo '<body class="header-image fullwidth">';
		}
		else
		{
			echo '<body class="page page-template-default">';
		}
	?>

	
		<!-- Plugins Site Body Begin -->
		<?php Theme::plugins('siteBodyBegin') ?>
	
		<!-- <div class="navigation" >
			<div class="navigation-inner section-inner">
				<ul class="blog-menu">
					<?php
						/** $parents = $pagesParents[NO_PARENT_CHAR];
						foreach($parents as $Parent) {
							echo '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="'.$Parent->permalink().'">'.$Parent->title().'</a></li> ';
						} */
					?>
				 </ul>
				 <div class="clear"></div>
			</div> <!-- /navigation-inner -->
		<!-- </div> <!-- /navigation -->
	
		<div class="header section">
			<div class="header-inner section-inner">
				
				<a href="<?php echo $Site->url() ?>" rel="home" class="logo"><img src="<?php echo(HTML_PATH_UPLOADS_PROFILES.'/admin.png') ?>" alt="<?php echo $Site->title() ?>"></a>
			        				
				<h1 class="blog-title">
					<a href="<?php echo $Site->url() ?>" rel="home"><?php echo $Site->title() ?></a>
				</h1>
				
				<!-- <div class="nav-toggle">
					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>
					
					<div class="clear"></div>
				</div> -->
 				
				<div class="clear"></div>
			</div> <!-- /header section -->
		</div> <!-- /header-inner section-inner -->
		
		<?php
			if( $WHERE_AM_I=='home' )
			{
				include(THEME_DIR_PHP.'home.php');
			}
			else
			{
				include(THEME_DIR_PHP.'page.php');
			}
		?>
		
		<!-- Footer -->
		<?php include(THEME_DIR_PHP.'sidebar.php') ?>
		
		<div class="credits section">
			<div class="credits-inner section-inner">
		
				<p class="credits-left">
					<span><?php echo $Site->footer() ?></span>
				</p>
				
				<p class="credits-right">
					<span>Lingonberry by <a href="http://www.andersnoren.se">Anders Noren</a> — </span><span>Ported by <a href="http://www.iamnobuna.ga">Hakim Zulkufli</a> — </span><a class="tothetop">Up ↑</a>
				</p>

				<div class="clear"></div>
			</div> <!-- /credits-inner -->
		</div> <!-- /credits -->
		
		<!-- Plugins Site Body End -->
		<?php Theme::plugins('siteBodyEnd') ?>
		
		<!-- Javascript -->
		<?php Theme::javascript(array(
			'flexslider.min.js',
			'global.js'
		)); ?>
		
	</body>
</html>