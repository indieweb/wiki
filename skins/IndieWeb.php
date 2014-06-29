<?php
/*
 * ----------------------------------------------------------------------------
 * 'IndieWeb' style sheet for CSS2-capable browsers.
 *       Loosely based on the monobook style
 *
 * @Version 3.2.1
 * @Author Paul Y. Gu, <gu.paul@gmail.com>
 * @Copyright paulgu.com 2006 - http://www.paulgu.com/
 * @License: GPL (http://www.gnu.org/copyleft/gpl.html)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * ----------------------------------------------------------------------------
 */

if( !defined( 'MEDIAWIKI' ) )
    die( -1 );

/** */
require_once('includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinIndieWeb extends SkinTemplate {
    /** Using IndieWeb */
    function initPage( &$out ) {
        SkinTemplate::initPage( $out );
        $this->skinname  = 'IndieWeb';
        $this->stylename = 'indieweb';
        $this->template  = 'IndieWebTemplate';
    }
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class IndieWebTemplate extends QuickTemplate {
    /**
     * Template filter callback for IndieWeb skin.
     * Takes an associative array of data set from a SkinTemplate-based
     * class, and a wrapper for MediaWiki's localization database, and
     * outputs a formatted page.
     *
     * @access private
     */
    function execute() {
      global $wgPingback, $wgWebmention;
        // Suppress warnings to prevent notices about missing indexes in $this->data
        wfSuppressWarnings();

?><!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->text('pagetitle') ?></title>

    <meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
    <link rel="shortcut icon" href="/wiki/skins/indieweb/favicon.ico" />
    <link rel="icon" type="image/png" href="/wiki/skins/indieweb/favicon.png" />

    <?php $this->html('headlinks') ?>
    
    <!-- Stylesheets -->

    <link rel="stylesheet" href="/wiki/skins/indieweb/css/normalize.css">
    <link rel="stylesheet" href="/wiki/skins/indieweb/css/foundation.css">
    <link rel="stylesheet" href="/wiki/skins/indieweb/css/main.css">

	<meta property="og:title" content="<?php $this->text('pagetitle') ?>" />
	<meta property="og:image" content="https://indiewebcamp.com/wiki/skins/indieweb/indiewebcamp-logo-500px.png" />
	<meta property="og:site_name" content="IndieWebCamp" />
	<meta property="fb:admins" content="11500459,31600719,214611" />

    <script src="js/vendor/modernizr.js"></script>

    <script type="text/javascript" src="/wiki/skins/indieweb/fragmentions.js"></script>

    <?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

    <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
    <?php    if($this->data['jsvarurl'  ]) { ?>
        <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"></script>
    <?php    } ?>
    <?php    if($this->data['pagecss'   ]) { ?>
        <style type="text/css"><?php $this->html('pagecss'   ) ?></style>
    <?php    }
        if($this->data['usercss'   ]) { ?>
        <style type="text/css"><?php $this->html('usercss'   ) ?></style>
    <?php    }
        if($this->data['userjs'    ]) { ?>
        <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
    <?php    }
        if($this->data['userjsprev']) { ?>
        <script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
    <?php    }
    if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
    <?php if(isset($wgPingback)) { ?>
      <link rel="pingback" href="<?= $wgPingback ?>" />
    <?php } ?>
    <?php if(isset($wgWebmention)) { ?>
      <link href="<?= $wgWebmention ?>" rel="webmention" />
    <?php } ?>
    
    <!-- Head Scripts -->
    <?php $this->html('headscripts') ?>

</head>

<body <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload'    ]) { ?>onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki h-entry <?php $this->text('nsclass') ?> <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">

    <!-- TOP NAV -->
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <li class="name">
                <a href="/"><img src="/wiki/skins/indieweb/indiewebcamp-logo-500px.png" width="155" alt="IndieWebCamp"></a>
            </li>
        </ul>

        <section class="top-bar-section">
            <ul class="right">
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>

                <!-- LOGIN -->
                <?php $lastkey = end(array_keys($this->data['personal_urls'])) ?>
                <?php $item = $this->data['personal_urls'][$lastkey];
                ?><li id="gumax-pt-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
                echo htmlspecialchars($item['href']) ?>"<?php
                if(!empty($item['class'])) { ?> class="<?php
                echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
                echo htmlspecialchars($item['text']) ?></a></li>


                <!-- SEARCH -->
                <li class="has-form">
                    <form action="<?php $this->text('searchaction') ?>" id="searchform">
                        <div class="large-8 small-6 columns">
                            <input id="searchInput" name="search" type="text" <?php
                                if($this->haveMsg('accesskey-search')) {
                                ?>accesskey="<?php $this->msg('accesskey-search') ?>"<?php }
                                if( isset( $this->data['search'] ) ) {
                                ?> value="<?php $this->text('search') ?>"<?php } ?> />
                        </div>
                        <div class="large-4 small-3 columns">
                            <input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
                        </div>
                    </form>
                </li>


            </ul>
        </section>
    </nav>

    

    <!-- NOTICE -->
    <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>

    <!-- LOGO -->
    

    <!-- SIDE NAV -->
	<?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
	<div id='p-<?php echo Sanitizer::escapeId($bar) ?>'>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
			<ul>
                <?php foreach($cont as $key => $val) { ?>
                    <li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
                    if ( $val['active'] ) { ?> class="active" <?php }
                    ?>><a href="<?php echo htmlspecialchars($val['href']) ?>"><?php echo htmlspecialchars($val['text']) ?></a></li>
                <?php } ?>
			</ul>
	</div>
	<?php } ?>

    <!-- Main Content -->    
    <a id="top"></a>


    <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
    <h1 class="firstHeading p-name"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
    
    <div id="contentSub"><?php if( $this->data['title'] != 'Home' ) { $this->html('subtitle'); } ?></div>
    <?php if($this->data['undelete']) { ?><div id="contentSub2"><?php $this->html('undelete') ?></div><?php } ?>
    <?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
    <?php if(0 && $this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
    <!-- start content -->
    <?php $this->html('bodytext') ?>
    <?php if($this->data['catlinks']) { ?><div id="catlinks"><?php $this->html('catlinks') ?></div><?php } ?>
    <!-- end content -->


    <!-- BOTTOM -->
        <ul>
            <?php $lastkey = end(array_keys($this->data['content_actions'])) ?>
            <?php foreach($this->data['content_actions'] as $key => $action) { ?>
               <li id="ca-<?php echo Sanitizer::escapeId($key) ?>" <?php
                   if($action['class']) { ?>class="<?php echo htmlspecialchars($action['class']) ?>"<?php } ?>
               ><a href="<?php echo htmlspecialchars($action['href']). '"';
                                        # We don't want to give the watch tab an accesskey if the
                                        # page is being edited, because that conflicts with the
                                        # accesskey on the watch checkbox.  We also don't want to
                                        # give the edit tab an accesskey, because that's fairly su-
                                        # perfluous and conflicts with an accesskey (Ctrl-E) often
                                        # used for editing in Safari.
					$linker = new Linker();
                                        if( in_array( $action, array( 'edit', 'submit' ) )
                                        && in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
                                                echo $linker->tooltip( "ca-$key" );
                                        } else {
                                                echo $linker->tooltipAndAccesskey( "ca-$key" );
                                        }
				echo '>';
                   echo htmlspecialchars($action['text']) ?></a> <?php
                   	// echo '<!-- '; echo var_dump($this->skin); echo ' -->';
                   if($key != $lastkey) //echo "&#8226;" ?></li>
            <?php } ?>

            <!-- show back to top link only if the body is longer than the window height -->
            <!--
            <script type="text/javascript">
                var winheight = parseInt(document.documentElement.clientHeight)
                var boheight = parseInt(document.body.clientHeight)
                if(winheight <= boheight) {
                    document.write('<li><a href="#" onclick="window.scrollTo(0,0);return false;" title="Back to the top of the page">Back to top</a></li>');
                }
            </script>
            -->
            <!-- end of show back to top link only -->

        </ul>


    <!-- FOOTER -->
    <ul>
        <?php if($this->data['notspecialpage']) { foreach( array( 'whatlinkshere', 'recentchangeslinked' ) as $special ) { ?>
		 <li id="t-<?php echo $special?>"><a href="<?php
                echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
                ?>"><?php echo $this->msg($special) ?></a> | </li>
              <?php } } ?><?php if($this->data['feeds']) { ?>
                  <li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
                  ?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
                  echo htmlspecialchars($feed['href']) ?>"><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span><?php } ?> | </li> <?php } ?>
              <?php foreach( array('contributions', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) { ?> <?php
                  if($this->data['nav_urls'][$special]) {?><li id="t-<?php echo $special ?>"><a href="<?php
                  echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
                  ?>"><?php $this->msg($special) ?></a> <?php
                      if($special != 'specialpages') echo "|" ?> </li>
                <?php } ?>
              <?php }

                if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
                        <li id="t-permalink"> | <a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
                        ?>"><?php $this->msg('permalink') ?></a></li><?php
                } elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
                        <li id="t-ispermalink"> | <?php $this->msg('permalink') ?></li><?php
                }

                wfRunHooks( 'IndieWebTemplateToolboxEnd', array( &$this ) ); ?>

            </ul>


            <!-- Login -->
                <ul>
                  <?php $lastkey = end(array_keys($this->data['personal_urls'])) ?>
                  <?php foreach($this->data['personal_urls'] as $key => $item) {
	                  ?><li id="gumax-pt-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
	                   echo htmlspecialchars($item['href']) ?>"<?php
	                  if(!empty($item['class'])) { ?> class="<?php
	                   echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
	                   echo htmlspecialchars($item['text']) ?></a>
	                   <?php if($key != $lastkey) echo "|" ?></li>
                 <?php } ?>
                </ul>

            <!-- end of Login -->

        <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>

<?php
include(dirname(__FILE__).'/sponsors.php');
?>

<?php $this->html('reporttime') ?>

<script src="/wiki/skins/indieweb/js/vendor/jquery.js"></script>
<script src="/wiki/skins/indieweb/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16359758-21']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method
} // end of class
?>
