<?php
/**
* @version $Id: admin.content.html.php,v 1.5 2004/10/12 03:21:44 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo_4.5.1
*/
class HTML_content {

	/**
	* Writes a list of the content items
	* @param array An array of content objects
	*/
	function showContent( &$rows, $section, &$lists, $search, $pageNav, $option, $all=NULL, $redirect ) {
		global $my, $mosConfig_live_site, $adminLanguage;
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<?php
			if ( $all ) {
				?>
				<th class="edit">
				<?php echo $adminLanguage->A_COMP_CONTENT_ALL_ITEMS;?>
				</th>
				<?php
			} else {
				?>
				<th class="edit">
				<?php echo $section->title; ?>
<?php echo $adminLanguage->A_COMP_ITEMS;?>
				</th>
				<?php
			}
			?>
			<td>
			<?php echo $adminLanguage->A_COMP_FILTER;?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<?php
			if ( $all ) {
				?>
				<td width="right">
				<?php echo $lists['sectionid'];?>
				</td>
				<?php
			}
			?>
			<td width="right">
			<?php echo $lists['catid'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="5">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="30%">
			<?php echo $adminLanguage->A_COMP_TITLE;?>
			</th>
			<th width="5%">
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th nowrap="nowrap" width="5%">
			<?php echo $adminLanguage->A_COMP_FRONT_PAGE;?>
			</th>
			<th colspan="2" align="center" width="5%">
			<?php echo $adminLanguage->A_COMP_REORDER;?>
			</th>
			<th width="10%">
			<?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<th width="2%">
			<?php echo $adminLanguage->A_COMP_ID;?>
			</th>
			<?php
			if ( $all ) {
				?>
				<th align="left">
				<?php echo $adminLanguage->A_COMP_SECTION;?>
				</th>
				<?php
			}
			?>
			<th align="left">
			<?php echo $adminLanguage->A_COMP_CATEG;?>
			</th>
			<th nowrap="nowrap">
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
		  </tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			if ( !$row->access ) {
				$color_access = 'style="color: green;"';
				$task_access = 'accessregistered';
			} else if ( $row->access == 1 ) {
				$color_access = 'style="color: red;"';
				$task_access = 'accessspecial';
			} else {
				$color_access = 'style="color: black;"';
				$task_access = 'accesspublic';
			}
			$link = 'index2.php?option=com_content&sectionid='. $redirect .'&task=edit&id='. $row->id;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) ); ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					?>
<?php echo $row->title; ?> [ <i><?php echo $adminLanguage->A_COMP_CHECKED_OUT;?></i> ]
					<?php
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo $row->title; ?>
					</a>
					<?php
				}
				?>
				</td>
				<?php
				$now = date( "Y-m-d h:i:s" );
				if ( $now <= $row->publish_up && $row->state == "1" ) {
					$img = 'publish_y.png';
					$alt = $adminLanguage->A_COMP_PUBLISHED;
				} else if ( ( $now <= $row->publish_down || $row->publish_down == "0000-00-00 00:00:00" ) && $row->state == "1" ) {
					$img = 'publish_g.png';
					$alt = $adminLanguage->A_COMP_PUBLISHED;
				} else if ( $now > $row->publish_down && $row->state == "1" ) {
					$img = 'publish_r.png';
					$alt = $adminLanguage->A_COMP_EXPIRED;
				} elseif ( $row->state == "0" ) {
					$img = "publish_x.png";
					$alt = $adminLanguage->A_COMP_UNPUBLISHED;
				}
				$times = '';
				if (isset($row->publish_up)) {
					if ($row->publish_up == '0000-00-00 00:00:00') {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START_ALWAYS ."</td></tr>";
					} else {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START .": ". $row->publish_up ."</td></tr>";
					}
				}
				if (isset($row->publish_down)) {
					if ($row->publish_down == '0000-00-00 00:00:00') {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FIN_NOEXP ."</td></tr>";
					} else {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FINISH .": ". $row->publish_down ."</td></tr>";
					}
				}
				if ( $times ) {
					?>
					<td align="center">
					<a href="javascript: void(0);" onMouseOver="return overlib('<table><?php echo $times; ?></table>', CAPTION, '<?php echo $adminLanguage->A_COMP_CONTENT_PUBLISH_INFO;?>', BELOW, RIGHT);" onMouseOut="return nd();" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? "unpublish" : "publish";?>')">
					<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
					</a>
					</td>
					<?php
				}
				?>
				<td align="center">
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','toggle_frontpage')">
				<img src="images/<?php echo ( $row->frontpage ) ? 'tick.png' : 'publish_x.png';?>" width="12" height="12" border="0" alt="<?php echo ( $row->frontpage ) ? $adminLanguage->A_COMP_YES : $adminLanguage->A_COMP_NO;?>" />
				</a>
				</td>
				<td align="right">
				<?php echo $pageNav->orderUpIcon( $i, ($row->catid == @$rows[$i-1]->catid) ); ?>
				</td>
				<td align="left">
				<?php echo $pageNav->orderDownIcon( $i, $n, ($row->catid == @$rows[$i+1]->catid) ); ?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="left">
				<?php echo $row->id; ?>
				</td>
				<?php
				if ( $all ) {
					?>
					<td align="left">
					<?php echo $row->section_name; ?>
					</td>
					<?php
				}
				?>
				<td align="left">
				<?php echo $row->name; ?>
				</td>
				<td align="center">
				<?php echo $row->checked_out ? $row->editor : ""; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $section->id;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
		</form>
		<br />

		<?php
		mosCommonHTML::ContentLegend();
		?>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}


	/**
	* Writes a list of the content items
	* @param array An array of content objects
	*/
	function showArchive( &$rows, $section, &$lists, $search, $pageNav, $option, $all=NULL, $redirect ) {
		global $my, $adminLanguage;
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if (pressbutton == 'remove') {
				if (document.adminForm.boxchecked.value == 0) {
					alert("<?php echo $adminLanguage->A_COMP_CONTENT_TRASH;?>");
				} else if ( confirm("<?php echo $adminLanguage->A_COMP_CONTENT_TRASH_MESS;?>")) {
					submitform('remove');
				}
			} else {
				submitform(pressbutton);
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="edit">
			<?php echo $section->title; ?>
<?php echo $adminLanguage->A_COMP_CONTENT_ARCHIVE;?>
<?php
			if ( $all ) {
				echo $adminLanguage->A_COMP_CONTENT_MANAGER;
 			}
			?>
			</th>
			<td>
			<?php echo $adminLanguage->A_COMP_FILTER;?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="textarea" onChange="document.adminForm.submit();" />
			</td>
			<?php
			if ( $all ) {
				?>
				<td width="right">
				<?php echo $lists['sectionid'];?>
				</td>
				<?php
			}
			?>
			<td width="right">
			<?php echo $lists['catid'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="50%">
			<?php echo $adminLanguage->A_COMP_TITLE;?>
			</th>
			<th width="15%" align="left">
			<?php echo $adminLanguage->A_COMP_CATEG;?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td width="20">
				<?php echo mosHTML::idBox( $i, $row->id ); ?>
				</td>
				<td width="85%">
				<?php echo $row->title; ?>
				</td>
				<td width="15%">
				<?php echo $row->name; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $section->id;?>" />
		<input type="hidden" name="task" value="showarchive" />
		<input type="hidden" name="returntask" value="showarchive" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
		</form>
		<?php
	}


	/**
	* Writes the edit form for new and existing content item
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosContent The category object
	* @param string The html for the groups select list
	*/
	function editContent( &$row, $section, &$lists, &$sectioncategories, &$images, $myid, &$params, $option, $redirect, &$menus ) {
		global $mosConfig_live_site, $adminLanguage;

		$sec = $section; 	//used in metadata include

		mosMakeHtmlSafe( $row );

		$mod_date = null;
		$create_date = null;
		if (intval( $row->modified ) <> 0) {
			$mod_date = mosFormatDate( $row->modified );
		}
		if (intval( $row->created ) <> 0) {
			$create_date = mosFormatDate( $row->created );
		}

		$tabs = new mosTabs(0);

		// used to hide "Reset Hits" when hits = 0
		if ( !$row->hits ) {
			$visibility = "style='display: none; visbility: hidden;'";
		} else {
			$visibility = "";
		}
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<link rel="stylesheet" type="text/css" media="all" href="../includes/js/calendar/calendar-mos.css" title="green" />
		<!-- import the calendar script -->
		<script type="text/javascript" src="../includes/js/calendar/calendar.js"></script>
		<!-- import the language module -->
		<script type="text/javascript" src="../includes/js/calendar/lang/calendar-en.js"></script>
		<script language="javascript" type="text/javascript">

		var sectioncategories = new Array;
		<?php
		$i = 0;
		foreach ($sectioncategories as $k=>$items) {
			foreach ($items as $v) {
				echo "sectioncategories[".$i++."] = new Array( '$k','".addslashes( $v->value )."','".addslashes( $v->text )."' );\n\t\t";
			}
		}
		?>


		var folderimages = new Array;
		<?php
		$i = 0;
		foreach ($images as $k=>$items) {
			foreach ($items as $v) {
				echo "folderimages[".$i++."] = new Array( '$k','".addslashes( $v->value )."','".addslashes( $v->text )."' );\n\t\t";
			}
		}
		?>


		function submitbutton(pressbutton) {
			var form = document.adminForm;

			if (pressbutton =='resethits') {
				if (confirm("<?php echo $adminLanguage->A_COMP_CONTENT_ZERO;?>")){
					submitform( pressbutton );
					return;
				} else {
					return;
				}
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_SELECT_MENU;?>" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_ENTER_MENU_NAME;?>" );
					return;
				} else if ( confirm("<?php echo $adminLanguage->A_COMP_CREATE_MENU_LINK;?>") ){
					submitform( pressbutton );
				} else {
					return;
				}
			}

			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// assemble the images back into one field
			var temp = new Array;
			for (var i=0, n=form.imagelist.options.length; i < n; i++) {
				temp[i] = form.imagelist.options[i].value;
			}
			form.images.value = temp.join( '\n' );

			// do field validation
			if (form.title.value == ""){
				alert( "<?php echo $adminLanguage->A_COMP_CONTENT_MUST_TITLE;?>" );
			} else if (form.sectionid.value == "-1"){
				alert( "<?php echo $adminLanguage->A_COMP_CONTENT_MUST_SECTION;?>" );
			} else if (form.catid.value == "-1"){
				alert( "<?php echo $adminLanguage->A_COMP_CONTENT_MUST_CATEG;?>" );
			} else {
				<?php getEditorContents( 'editor1', 'introtext' ) ; ?>
<?php getEditorContents( 'editor2', 'fulltext' ) ; ?>
				submitform( pressbutton );
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<input type="hidden" name="images" value="" />
		<table class="adminheading">
		<tr>
			<th class="edit">
			<?php echo $row->id ? $adminLanguage->A_COMP_EDITING : $adminLanguage->A_COMP_ADDING;?> <?php echo $adminLanguage->A_COMP_CONTENT_IN;?> <?php echo $section;?> <?php echo $adminLanguage->A_COMP_SECTION;?>
			</th>
		</tr>
		</table>

		<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td width="60%" valign="top">
				<table width="100%" class="adminform">
				<tr>
					<td width="100%">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<th colspan="4">
							<?php echo $adminLanguage->A_COMP_CONTENT_ITEM_DETAILS;?>
							</th>
						<tr>
						<tr>
							<td>
							<?php echo $adminLanguage->A_COMP_TITLE;?>:
							</td>
							<td>
							<input class="text_area" type="text" name="title" size="30" maxlength="100" value="<?php echo $row->title; ?>" />
							</td>
							<td>
							<?php echo $adminLanguage->A_COMP_SECTION;?>:
							</td>
							<td>
							<?php echo $lists['sectionid']; ?>
							</td>
						</tr>
						<tr>
							<td>
							<?php echo $adminLanguage->A_COMP_CONTENT_TITLE_ALIAS;?>:
							</td>
							<td>
							<input name="title_alias" type="text" class="text_area" id="title_alias" value="<?php echo $row->title_alias; ?>" size="30" maxlength="100" />
							</td>
							<td>
							<?php echo $adminLanguage->A_COMP_CATEG;?>:
							</td>
							<td>
							<?php echo $lists['catid']; ?>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%">
					<?php echo $adminLanguage->A_COMP_CONTENT_INTRO;?>
					<br /><?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->introtext , 'introtext', 500, 200, '50', '15' ) ; ?>
					</td>
				</tr>
				<tr>
					<td width="100%">
					<?php echo $adminLanguage->A_COMP_CONTENT_MAIN;?>
					<br /><?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor2',  $row->fulltext , 'fulltext', 500, 350, '50', '15' ) ; ?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" width="40%">
				<table>
				<tr>
					<td>
					<?php
					$tabs->startPane("content-pane");
					$tabs->startTab($adminLanguage->A_COMP_CONTENT_PUBLISHING, "publish-page");
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_CONTENT_PUB_INFO;?>
						</th>
					<tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_FRONTPAGE;?>:
						</td>
						<td>
						<input type="checkbox" name="frontpage" value="1" <?php echo $row->frontpage ? 'checked="checked"' : ''; ?> />
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_PUBLISHED;?>:
						</td>
						<td>
						<input type="checkbox" name="published" value="1" <?php echo $row->state ? 'checked="checked"' : ''; ?> />
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:
						</td>
						<td>
						<?php echo $lists['access']; ?> </td>
						</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_AUTHOR;?>:
						</td>
						<td>
						<input type="text" name="created_by_alias" size="30" maxlength="100" value="<?php echo $row->created_by_alias; ?>" class="text_area" />
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_CREATOR;?>:
						</td>
						<td>
						<?php echo $lists['created_by']; ?> </td>
					</tr>
					<tr>
						<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_ORDERING;?>:</td>
						<td>
						<?php echo $lists['ordering']; ?> </td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_OVERRIDE;?>
						</td>
						<td>
						<input class="text_area" type="text" name="created" id="created" size="25" maxlength="19" value="<?php echo $row->created; ?>" />
						<input name="reset" type="reset" class="button" onClick="return showCalendar('created', 'y-mm-dd');" value="...">
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_START_PUB;?>:
						</td>
						<td>
						<input class="text_area" type="text" name="publish_up" id="publish_up" size="25" maxlength="19" value="<?php echo $row->publish_up; ?>" />
						<input type="reset" class="button" value="..." onClick="return showCalendar('publish_up', 'y-mm-dd');">
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<?php echo $adminLanguage->A_COMP_CONTENT_FINISH_PUB;?>:
						</td>
						<td>
						<input class="text_area" type="text" name="publish_down" id="publish_down" size="25" maxlength="19" value="<?php echo $row->publish_down; ?>" />
						<input type="reset" class="button" value="..." onClick="return showCalendar('publish_down', 'y-mm-dd');">
						</td>
					</tr>
					</table>
					<br />
					<table class="adminform">
					<tr>
						<td width="90px" valign="top" align="right">
						<strong><?php echo $adminLanguage->A_COMP_STATE;?>:</strong>
						</td>
						<td>
						<?php echo $row->state > 0 ? $adminLanguage->A_COMP_PUBLISHED : ($row->state < 0 ? $adminLanguage->A_COMP_ARCHIVED : $adminLanguage->A_COMP_CONTENT_DRAFT_UNPUB );?>
						</td>
					</tr>
					<tr >
						<td valign="top" align="right">
						<strong>
						<?php echo $adminLanguage->A_COMP_HITS;?>
						</strong>:
						</td>
						<td>
						<?php echo $row->hits;?>
						<div <?php echo $visibility; ?>>
						<input name="reset_hits" type="button" class="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_RESET_HIT;?>" onClick="submitbutton('resethits');">
						</div>
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<strong>
						<?php echo $adminLanguage->A_COMP_CONTENT_REVISED;?>
						</strong>:
						</td>
						<td>
						<?php echo $row->version;?>
<?php echo $adminLanguage->A_COMP_CONTENT_TIMES;?>
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<strong>
						<?php echo $adminLanguage->A_COMP_CONTENT_CREATED;?>
						</strong>
						</td>
						<td>
						<?php echo $row->created ? "$create_date</td></tr><tr><td valign='top' align='right'><strong>". $adminLanguage->A_COMP_CONTENT_BY ."</strong></td><td>$row->creator" : $adminLanguage->A_COMP_CONTENT_NEW_DOC; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">
						<strong>
						<?php echo $adminLanguage->A_COMP_CONTENT_LAST_MOD;?>
						</strong>
						</td>
						<td>
						<?php echo $row->modified ? "$mod_date</td></tr><tr><td valign='top' align='right'><strong>". $adminLanguage->A_COMP_CONTENT_BY ."</strong></td><td>$row->modifier" : $adminLanguage->A_COMP_CONTENT_NOT_MOD;?>
						</td>
					</tr>
					</table>
					<?php
					$tabs->endTab();
					$tabs->startTab($adminLanguage->A_COMP_CONTENT_IMAGES2, $adminLanguage->A_COMP_CONT_IMG_PAGE );
					?>
					<table class="adminform" width="100%">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_CONTENT_MOSIMAGE;?>
						</th>
					<tr>
					<tr>
						<td colspan="6"><?php echo $adminLanguage->A_COMP_CONTENT_SUB_FOLDER;?>: <?php echo $lists['folders'];?></td>
					</tr>
					<tr>
						<td>
						<?php echo $adminLanguage->A_COMP_CONTENT_GALLERY;?>:
						<br />
						<?php echo $lists['imagefiles'];?>
						</td>
						<td valign="top">
						<img name="view_imagefiles" src="../images/M_images/blank.png" width="100" />
						</td>
					</tr>
					<tr>
						<td>
						<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_ADD;?>" onClick="addSelectedToList('adminForm','imagefiles','imagelist')" />
						</td>
					</tr>
					<tr>
						<td>
						<?php echo $adminLanguage->A_COMP_CONTENT_IMAGES;?>:
						<br />
						<?php echo $lists['imagelist'];?>
						</td>
						<td valign="top">
						<img name="view_imagelist" src="../images/M_images/blank.png" width="100" />
						</td>
					</tr>
					<tr>
						<td>
						<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_UP;?>" onClick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,-1)" />
						<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_DOWN;?>" onClick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,+1)" />
						<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_REMOVE;?>" onClick="delSelectedFromList('adminForm','imagelist')" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo $adminLanguage->A_COMP_CONTENT_EDIT_IMAGE;?>:
							<table>
							<tr>
								<td align="right">
								<?php echo $adminLanguage->A_COMP_SOURCE;?>:
								</td>
								<td>
								<input class="text_area" type="text" name= "_source" value="" />
								</td>
							</tr>
							<tr>
								<td align="right">
								<?php echo $adminLanguage->A_COMP_CONTENT_ALIGN;?>:
								</td>
								<td>
								<?php echo $lists['_align']; ?>
								</td>
							</tr>
							<tr>
								<td align="right">
								<?php echo $adminLanguage->A_COMP_CONTENT_ALT;?>:
								</td>
								<td>
								<input class="text_area" type="text" name="_alt" value="" />
								</td>
							</tr>
							<tr>
								<td align="right">
								<?php echo $adminLanguage->A_COMP_CONTENT_BORDER;?>:
								</td>
								<td>
								<input class="text_area" type="text" name="_border" value="" size="3" maxlength="1" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_APPLY;?>" onClick="applyImageProps()" />
								</td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
					<?php
					$tabs->endTab();
					$tabs->startTab($adminLanguage->A_COMP_CONT_PARAMETERS, "params-page" );
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_CONTENT_PARAM;?>
						</th>
					<tr>
					<tr>
						<td>
						<?php echo $adminLanguage->A_COMP_CONTENT_PARAM_MESS;?>
						<br /><br />
						</td>
					</tr>
					<tr>
						<td>
						<?php echo $params->render();?>
						</td>
					</tr>
					</table>
					<?php
					$tabs->endTab();
					$tabs->startTab($adminLanguage->A_COMP_CONTENT_META_INFO, $adminLanguage->A_COMP_CONF_META_PAGE );
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_CONTENT_META_DATA;?>
						</th>
					<tr>
					<tr>
						<td>
						<?php echo $adminLanguage->A_COMP_DESCRIPTION;?>:
						<br />
						<textarea class="text_area" cols="30" rows="3" style="width:300px; height:50px" name="metadesc" width="500"><?php echo str_replace('&','&amp;',$row->metadesc); ?></textarea>
						</td>
					</tr>
						<tr>
						<td>
						<?php echo $adminLanguage->A_COMP_CONTENT_KEYWORDS;?>:
						<br />
						<textarea class="text_area" cols="30" rows="3" style="width:300px; height:50px" name="metakey" width="500"><?php echo str_replace('&','&amp;',$row->metakey); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
						<input type="button" class="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_ADD_ETC;?>" onClick="f=document.adminForm;f.metakey.value=document.adminForm.sectionid.options[document.adminForm.sectionid.selectedIndex].text+', '+getSelectedText('adminForm','catid')+', '+f.title.value+f.metakey.value;" />
						</td>
					</tr>
					</table>
					<?php
					$tabs->endTab();
					$tabs->startTab($adminLanguage->A_COMP_CONTENT_LINK_TO_MENU, $adminLanguage->A_COMP_CONTENT_LINK_PAGE );
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_LINK_TO_MENU;?>
						</th>
					<tr>
					<tr>
						<td colspan="2">
						<?php echo $adminLanguage->A_COMP_CONTENT_LINK_CI;?>
						<br /><br />
						</td>
					<tr>
					<tr>
						<td valign="top" width="90px">
						<?php echo $adminLanguage->A_COMP_SELECT_MENU;?>
						</td>
						<td>
						<?php echo $lists['menuselect']; ?>
						</td>
					<tr>
					<tr>
						<td valign="top" width="90px">
						<?php echo $adminLanguage->A_COMP_MENU_NAME;?>
						</td>
						<td>
						<input type="text" name="link_name" class="inputbox" value="" size="30" />
						</td>
					<tr>
					<tr>
						<td>
						</td>
						<td>
						<input name="menu_link" type="button" class="button" value="<?php echo $adminLanguage->A_COMP_LINK_TO_MENU;?>" onClick="submitbutton('menulink');" />
						</td>
					<tr>
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_MENU_LINKS;?>
						</th>
					</tr>
					<?php
					if ( $menus == NULL ) {
						?>
						<tr>
							<td colspan="2">
							<?php echo $adminLanguage->A_COMP_NONE;?>
							</td>
						</tr>
						<?php
					} else {
						foreach( $menus as $menu ) {
							?>
							<tr>
								<td colspan="2">
								<hr/>
								</td>
							</tr>
							<tr>
								<td width="90px" valign="top">
								<?php echo $adminLanguage->A_COMP_MENU;?>
								</td>
								<td>
								<?php echo $menu->menutype; ?>
								</td>
							</tr>
							<tr>
								<td width="90px" valign="top">
								<?php echo $adminLanguage->A_COMP_CONTENT_LINK_NAME;?>
								</td>
								<td>
								<strong>
								<?php echo $menu->name; ?>
								</strong>
								</td>
							</tr>
							<tr>
								<td width="90px" valign="top">
								<?php echo $adminLanguage->A_COMP_STATE;?>
								</td>
								<td>
								<?php
								switch ( $menu->published ) {
									case -2:
										echo "<font color=\"red\">". $adminLanguage->A_COMP_TRASHED ."</font>";
										break;
									case 0:
										echo $adminLanguage->A_COMP_UNPUBLISHED;
										break;
									case 1:
									default:
										echo "<font color=\"green\">". $adminLanguage->A_COMP_PUBLISHED ."</font>";
										break;
								}
								?>
								</td>
							</tr>
							<?php
						}
					}
					?>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					</table>
					<?php
					$tabs->endTab();
					$tabs->endPane();
					?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="version" value="<?php echo $row->version; ?>" />
		<input type="hidden" name="mask" value="0" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
		
	}


	/**
	* Form to select Section/Category to move item(s) to
	* @param array An array of selected objects
	* @param int The current section we are looking at
	* @param array The list of sections and categories to move to
	*/
	function moveSection( $cid, $sectCatList, $option, $sectionid, $items ) {
       global $adminLanguage;
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectcat' )) {
				alert( "<?php echo $adminLanguage->A_COMP_CONTENT_SOMETHING;?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="edit">
			<?php echo $adminLanguage->A_COMP_CONTENT_MOVE_ITEMS;?>
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td align="left" valign="top" width="40%">
			<strong><?php echo $adminLanguage->A_COMP_CONTENT_MOVE_SECCAT;?>:</strong>
			<br />
			<?php echo $sectCatList; ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong><?php echo $adminLanguage->A_COMP_CONTENT_ITEMS_MOVED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ($cid as $id) {
			echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}



	/**
	* Form to select Section/Category to copys item(s) to
	*/
	function copySection( $option, $cid, $sectCatList, $sectionid, $items  ) {
       global $adminLanguage;
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectcat' )) {
				alert( "<?php echo $adminLanguage->A_COMP_CONTENT_SECCAT;?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="edit">
			<?php echo $adminLanguage->A_COMP_CONTENT_COPY_ITEMS;?>
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td align="left" valign="top" width="40%">
			<strong><?php echo $adminLanguage->A_COMP_CONTENT_COPY_SECCAT;?>:</strong>
			<br />
			<?php echo $sectCatList; ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong><?php echo $adminLanguage->A_COMP_CONTENT_ITEMS_COPIED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ($cid as $id) {
			echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


}
?>
