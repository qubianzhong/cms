<? if(!defined('UC_ROOT')) exit('Access Denied');?>
<? include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>

<div class="container">
	<h3>���»���</h3>
	<? if($updated) { ?>
		<div class="correctmsg"><p>���³ɹ���</p></div>
	<? } ?>
	<div class="mainbox">
		<form action="admin.php?m=cache&a=update" method="post">
			<input type="hidden" name="formhash" value="<?=FORMHASH?>">
			<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
				<tr>
					<td class="option"><input type="checkbox" name="type[]" value="data" class="checkbox" checked="checked" /></td>
					<td>�������ݻ���</td>
				</tr>
				<tr>
					<td class="option"><input type="checkbox" name="type[]" value="tpl" class="checkbox" /></td>
					<td>����ģ�建��</td>
				</tr>
				<tr class="nobg">
					<td colspan="2"><input type="submit" value="�� ��" class="btn" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<? include $this->gettpl('footer');?>