<?php
/**
* @version $Id: content.searchbot.php,v 1.17 2004/09/12 18:01:09 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchContent' );

/**
* Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param integer The state to search for -1=archived, 0=unpublished, 1=published [default]
* @param string A prefix for the section label, eg, 'Archived '
*/
function botSearchContent( $text, $phrase='', $ordering='' ) {
	global $my, $database;
	global $mosConfig_abolute_path, $mosConfig_lang, $mosConfig_offset;
	$_SESSION['searchword'] = $text;
	
	$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$wheres2 = array();
			$wheres2[] = "LOWER(a.title) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.introtext) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.fulltext) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.metakey) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.metadesc) LIKE '%$text%'";
			$where = '(' . implode( ') OR (', $wheres2 ) . ')';
			break;
		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$wheres2 = array();
				$wheres2[] = "LOWER(a.title) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.introtext) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.fulltext) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.metakey) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.metadesc) LIKE '%$word%'";
				$wheres[] = implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}

	$morder = '';
	switch ($ordering) {
		case 'newest':
		default:
			$order = 'a.created DESC';
			break;
		case 'oldest':
			$order = 'a.created ASC';
			break;
		case 'popular':
			$order = 'a.hits DESC';
			break;
		case 'alpha':
			$order = 'a.title ASC';
			break;
		case 'category':
			$order = 'b.title ASC, a.title ASC';
			$morder = 'a.title ASC';
			break;
	}

	$database->setQuery( "SELECT a.title AS title,"
	. "\n a.created AS created,"
	. "\n a.introtext AS text,"
	. "\n CONCAT_WS( '/', u.title, b.title ) AS section,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.id ) AS href,"
	. "\n '2' AS browsernav"
	. "\n FROM #__content AS a"
	. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access <= '$my->gid'"
	. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
	. "\n WHERE ( $where )"
	. "\n AND a.state = '1' AND a.access <= '$my->gid'"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY $order"
	);

	$list = $database->loadObjectList();

	// search typed content
	$database->setQuery( "SELECT a.title AS title, a.created AS created,"
	. "\n a.introtext AS text,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.id, '&Itemid=', m.id ) AS href,"
	. "\n '2' as browsernav, 'Menu' AS section"
	. "\n FROM #__content AS a"
	. "\n LEFT JOIN #__menu AS m ON m.componentid = a.id"
	. "\n WHERE ($where)"
	. "\n AND a.state='1' AND a.access<='$my->gid' AND m.type='content_typed'"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY " . ($morder ? $morder : $order)
	);
	$list2 = $database->loadObjectList();

	// search archived content
	$database->setQuery( "SELECT a.title AS title,"
	. "\n a.created AS created,"
	. "\n a.introtext AS text,"
	. "\n CONCAT_WS( '/', 'Archived ', u.title, b.title ) AS section,"
	. "\n CONCAT('index.php?option=com_content&task=view&id=',a.id) AS href,"
	. "\n '2' AS browsernav"
	. "\n FROM #__content AS a"
	. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access <='$my->gid'"
	. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
	. "\n WHERE ( $where )"
	. "\n AND a.state = '-1' AND a.access <= '$my->gid'"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY $order"
	);
	$list3 = $database->loadObjectList();

	return array_merge( $list, $list2, $list3 );
}
?>