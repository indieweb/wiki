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
    <?php $this->html('headlinks') ?>
    
    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/foundation.css">

	<meta property="og:title" content="<?php $this->text('pagetitle') ?>" />
	<meta property="og:image" content="https://indiewebcamp.com/wiki/skins/indieweb/indiewebcamp-logo-500px.png" />
	<meta property="og:site_name" content="IndieWebCamp" />
	<meta property="fb:admins" content="11500459,31600719,214611" />

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/irc/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/irc/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/irc/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/irc/apple-touch-icon-144x144-precomposed.png">

    <script type="text/javascript" src="/wiki/skins/indieweb/fragmentions.js"></script>

    <?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

    <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
    <?php    if($this->data['jsvarurl'  ]) { ?>
        <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
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

<div class="gumax-center" align="center">

    <!-- ===== Header ===== -->
    <div id="gumax-header">
    	<div id="header-text">IndieWebCamp is a 2-day creator camp focused on growing the independent web</div>
        <a id="topHeader"></a>

    </div> <!-- end of header DIV -->
    <!-- ===== end of Header ===== -->


    <!-- ===== gumax-page-actions ===== -->
    <div id="gumax-page-actions">
      <div id="gumax-content-actions" style="text-align: left">
        <div class="middle-content">
        <ul style="margin-left: 40px;">
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
					if( $action['text'] == 'Page') { echo ' class="u-url"'; }
				echo '>';
                   echo htmlspecialchars($action['text']) ?></a> <?php
                   	// echo '<!-- '; echo var_dump($this->skin); echo ' -->';
                   if($key != $lastkey) //echo "&#8226;" ?></li>
            <?php } ?>

			<!-- Login link in header bar -->
	         <?php $lastkey = end(array_keys($this->data['personal_urls'])) ?>
	         <?php $item = $this->data['personal_urls'][$lastkey];
	              ?><li id="gumax-pt-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
	               echo htmlspecialchars($item['href']) ?>"<?php
	              if(!empty($item['class'])) { ?> class="<?php
	               echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
	               echo htmlspecialchars($item['text']) ?></a></li>


        <!-- Search -->
                <form action="<?php $this->text('searchaction') ?>" id="searchform" style="display: inline-block; float: right;">
                    <input id="searchInput" name="search" type="text" <?php
                        if($this->haveMsg('accesskey-search')) {
                            ?>accesskey="<?php $this->msg('accesskey-search') ?>"<?php }
                        if( isset( $this->data['search'] ) ) {
                            ?> value="<?php $this->text('search') ?>"<?php } ?> />
                    <input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
                </form>
        <!-- end of Search -->

        </ul>
        </div>

      </div>
    </div>
    <!-- ===== end of gumax-page-actions ===== -->
    

<div id="gumax-rbox" class="middle-content" align="left">
<div class="gumax-rbcontentwrap"><div class="gumax-rbcontent">

    <!-- =================== gumax-page =================== -->
    <div id="gumax-page">
    <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>

    <!-- ===== Content body ===== -->
    <div id="gumax-content-body">
    
    <table id="gumax-content-body-table"><tr><td class="gumax-content-left">
    <!-- Navigation Menu -->
    <div id="gumax-p-navigation-wrapper">

    <div id="main-logo-wrapper">
      <a href="/" id="main-logo"><img src="https://indiewebcamp.com/wiki/skins/indieweb/indiewebcamp-logo-500px.png" width="155" alt="IndieWebCamp"></a>
    </div>

	<?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
	<div class='gumax-portlet' id='p-<?php echo Sanitizer::escapeId($bar) ?>'>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
		<div class="gumax-p-navigation">
			<ul>
                <?php foreach($cont as $key => $val) { ?>
                    <li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
                    if ( $val['active'] ) { ?> class="active" <?php }
                    ?>><a href="<?php echo htmlspecialchars($val['href']) ?>"><?php echo htmlspecialchars($val['text']) ?></a></li>
                <?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>

    </div>
    <!-- end of Navigation Menu -->

    </td><td class="gumax-content-right"> <!-- Main Content TD -->

    <!-- Main Content -->
    <div id="content">
    
        <a name="top" id="top"></a>
        <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
        <h1 class="firstHeading p-name"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
        <div id= "bodyContent" class="gumax-bodyContent e-content">
            <?php /* <h3 id="siteSub"><?php $this->msg('tagline') ?></h3> */ ?>
            <div id="contentSub"><?php if( $this->data['title'] != 'Home' ) { $this->html('subtitle'); } ?></div>
            <?php if($this->data['undelete']) { ?><div id="contentSub2"><?php $this->html('undelete') ?></div><?php } ?>
            <?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
            <?php if(0 && $this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
            <!-- start content -->
            <?php $this->html('bodytext') ?>
            <?php if($this->data['catlinks']) { ?><div id="catlinks"><?php $this->html('catlinks') ?></div><?php } ?>
            <!-- end content -->
            <div class="visualClear"></div>
        </div>
    </div>
    <!-- end of Main Content -->
    </td></tr></table>
    </div>
    <!-- ===== end of Content body ===== -->

    </div> <!-- end of gumax-page DIV -->
    <!-- =================== end of gumax-page =================== -->
</div></div>
<div class="gumax-rbbot"><div><div></div></div></div></div>
</div>
</div>


  <div class="bottom">
    <!-- ===== gumax-page-actions ===== -->
    <div id="gumax-page-actions">
      <div id="gumax-content-actions">
        <div class="middle-content">
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
        </div>
      </div>
    </div>
    <!-- ===== end of gumax-page-actions ===== -->

    <!-- =================== gumax-page-footer =================== -->
    <div id="gumax-page-footer">

      <div class="middle-content">
        <!-- personal tools  -->
        <div id="gumax-personal-tools">
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
            <div id="gumax-footer-login">
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
            </div>
            <!-- end of Login -->

        </div> <!-- end of personal-tools DIV -->
        <!-- end of personal tools  -->

        <!-- gumax-footer -->
        <div id="gumax-footer">
            <div id="gumax-f-message">
                <?php if($this->data['lastmod']) { ?><span id="f-lastmod"><?php    $this->html('lastmod')    ?></span>
                <?php } ?><?php if($this->data['viewcount' ]) { ?><span id="f-viewcount"><?php  $this->html('viewcount')  ?> </span>
                <?php } ?>
            </div>
                <?php
			/*
            <ul id="gumax-f-list">
                        $footerlinks = array(
                            'numberofwatchingusers', 'credits',
                            'privacy', 'about', 'disclaimer', 'tagline',
                        );
                        foreach( $footerlinks as $aLink ) {
                            if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
                ?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?> | </li>
                <?php 		}
                        }
        		<li>Design by Aaron Parecki | </li>
                <li id="f-designby"><a href="http://paulgu.com">Skin by Paul Gu</a></li>
            </ul>
			*/
                ?>
        </div>
        <!-- end of gumax-footer -->
        <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
      </div>
        
    </div>
    <!-- =================== end of gumax-page-footer =================== -->
  </div>

<?php
include(dirname(__FILE__).'/sponsors.php');
?>

    <?php $this->html('reporttime') ?>
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
