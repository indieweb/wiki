<?php

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

    <script src="/wiki/skins/indieweb/js/vendor/modernizr.js"></script>
    <script src="/wiki/skins/indieweb/js/vendor/jquery.js"></script>

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
                <a href="/"><img src="/wiki/skins/indieweb/indiewebcamp-logo-small.png" alt="IndieWebCamp"></a>
            </li>
        </ul>

        <section class="top-bar-section">
            <ul class="right">
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
           

            <ul class="left">
                <li class="has-dropdown">
                    <a href="#">Get Started</a>
                    <ul class="dropdown">
                        <li><a href="#">IRC</a></li>
                    </ul>
                </li>
                <li><a href="#">Principles</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Building Blocks</a></li>
                
                <li class="has-dropdown">
                    <a href="#">Wiki Tools</a>
                    <ul class="dropdown">
                        <!-- gnarly wiki things -->
                        <?php $lastkey = end(array_keys($this->data['content_actions'])) ?>
                        <?php foreach($this->data['content_actions'] as $key => $action) { ?>
                           <li id="ca-<?php echo Sanitizer::escapeId($key) ?>" <?php
                               if($action['class']) { ?>class="<?php echo htmlspecialchars($action['class']) ?>"<?php } ?>
                           ><a href="<?php 
                            echo htmlspecialchars($action['href']). '"';
                            $linker = new Linker();
                            if ( in_array( $action, array( 'edit', 'submit' ) ) && in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
                                echo $linker->tooltip( "ca-$key" );
                            } else {
                                echo $linker->tooltipAndAccesskey( "ca-$key" );
                            };
                            echo '>';
                            echo htmlspecialchars($action['text']); ?>
                            </a>
                            <?php
                               if($key != $lastkey) ?></li>
                        <?php }; ?>
                    </ul>
                </li>
            </ul>
        </section>
    </nav>

    <div class="row main-body">
	    <div class="large-9 columns">
	        <!-- NOTICE -->
	        <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
	    
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
	    
	    </div>
	    <div class="large-3 columns side">
            <h4>Events</h4>
            <script type="application/javascript" src="http://momentjs.com/downloads/moment.min.js"></script>

            <script type="application/javascript">
              $(function() {
                $.getJSON("http://indiewebcamp.com/wiki/api.php?action=parse&page=Events&format=json&callback=?", function(data) {
                  var rendered_html = data.parse.text['*'];
                  var upcoming_events = $(rendered_html).find('.h-event').filter(function(i, event) { return moment($(event).find('.dt-start').first().text()) > moment(); });
                  var next_event = upcoming_events.first();

                  var big_event_shown = false;
                  var small_event_shown = false;

                  $.each(upcoming_events, function(i, event) {
                    console.log(event);

                    event = $(event);
                    if(event.hasClass('big')) {
                      if(big_event_shown) return false;
                      big_event_shown = true;
                    } else {
                      if(small_event_shown) return false;
                      small_event_shown = true;
                    }

                    $('.upcoming_events ul').append($(event).closest('li'));
                  });
                });
              });
            </script> 

            <div class="upcoming_events">
              <ul>
              </ul>
            </div>

	    	<h4>What is Indie?</h4>
	    	<p>
		    	<a href="/File:icon_4611.png" class="image"><img alt="icon 4611.png" src="http://indiewebcamp.com/images/thumb/d/d7/icon_4611.png/48px-icon_4611.png" height="48" width="48"></a>
		    
				<b>Your content is yours</b><br>When you post something on the web, it should belong to you, not a corporation. Too many companies have gone out of business and <a href="/site-deaths" title="site-deaths">lost all of their users’ data</a>. By joining the IndieWeb, your content stays yours and in your control.
			</p>
			
			<p>
				<a href="/File:icon_31635.png" class="image"><img alt="icon 31635.png" src="http://indiewebcamp.com/images/thumb/1/1f/icon_31635.png/48px-icon_31635.png" height="48" width="48"></a>
		    
		    	<b>You are better connected</b><br>Your articles and status messages can <a href="/POSSE" title="POSSE">go to all services</a>, not just one, allowing you to engage with everyone. Even replies and likes on other services can <a href="/backfeed" title="backfeed">come back to your site</a> so they’re all in one place.
		    </p>
		    
		    <p>
		    	<a href="/File:icon_2003.png" class="image"><img alt="icon 2003.png" src="http://indiewebcamp.com/images/thumb/d/d9/icon_2003.png/48px-icon_2003.png" height="48" width="48"></a>
		    
		    	<b>You are in control</b><br>You can post anything you want, in any format you want, with no one monitoring you. In addition, you share simple readable links such as <i>example.com/ideas</i>. These links are <a href="/permalinks" title="permalinks">permanent</a> and will always work.
		    </p>
		    
	    </div>
    </div>



    <!-- BOTTOM -->
    <footer>

    <div class="row" id="bottomwiki">
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


    <!-- FOOTER -->
    <div class="row" id="bottomtools">
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
    </div>

    <div class="row" id="bottomlogin"
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
    </div>

            <!-- end of Login -->

    </div class="row" id="bottomscripts">
        <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
    </div>

    <?php include(dirname(__FILE__).'/sponsors.php'); ?>

    <?php $this->html('reporttime') ?>
    </footer>

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
