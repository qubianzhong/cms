<?php
/**
* @version $Id: wrapper.class.php,v 1.2 2004/09/17 08:47:56 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Wrapper class
* @package Mambo_4.5.1
*/
class wrapper_menu {

	function edit( &$uid, $menutype, $option ) {
		global $database, $my, $mainframe;
		global $mosConfig_absolute_path;

		$menu = new mosMenu( $database );
		$menu->load( $uid );

		// fail if checked out not by 'me'
		if ($menu->checked_out && $menu->checked_out <> $my->id) {
			echo "<script>alert('The module $menu->title is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</script>\n";
			exit(0);
		}

		if ( $uid ) {
			$menu->checkout( $my->id );
		} else {
			$menu->type = 'wrapper';
			$menu->menutype = $menutype;
			$menu->ordering = 9999;
			$menu->parent = intval( mosGetParam( $_POST, 'parent', 0 ) );
			$menu->published = 1;
			$menu->link = 'index.php?option=com_wrapper';
		}

		// build the html select list for ordering
		$lists['ordering'] 		= mosAdminMenus::Ordering( $menu, $uid );
		// build the html select list for the group access
		$lists['access'] 		= mosAdminMenus::Access( $menu );
		// build the html select list for paraent item
		$lists['parent'] 		= mosAdminMenus::Parent( $menu );
		// build published button option
		$lists['published'] 	= mosAdminMenus::Published( $menu );
		// build the url link output
		$lists['link'] 		= mosAdminMenus::Link( $menu, $uid );
		
		// get params definitions
		$params =& new mosParameters( $menu->params, $mainframe->getPath( 'menu_xml', $menu->type ), 'component' );
		if ( $uid ) {
			$menu->url = $params->def( 'url', '' );
		}

		wrapper_menu_html::edit( $menu, $lists, $params, $option );
	}


	function saveMenu( $option ) {
		global $database;
	
		$params = mosGetParam( $_POST, 'params', '' );
		$params[url] = mosGetParam( $_POST, 'url', '' );
		if (is_array( $params )) {
		    $txt = array();
		    foreach ($params as $k=>$v) {
			   $txt[] = "$k=$v";
			}
			$_POST['params'] = implode( "\n", $txt );
		}			

		$row = new mosMenu( $database );
	
		if (!$row->bind( $_POST )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->checkin();
		$row->updateOrder( "menutype='$row->menutype' AND parent='$row->parent'" );
		mosRedirect( "index2.php?option=$option&menutype=$row->menutype" );
	}
}


?>
