<fieldset style="margin-top:10px;">
		<legend><img src="../modules/<?= $this->name?>/img/connects-logo.png" /><?= $ref_manager_text?></legend>
<?php $i = false; ?>
<p style="padding-left: 120px; margin-bottom: 20px;">
	<input type="button" value="<?=$back_text?>" 
		   onclick="location.href='<?= $currentUrl ?>&start_modref'"
       	   class="button"  />
</p>

<table class="table tableDnD" align="center" border="0" width="100%">
			<tr>
					<td width="5%" style="text-align:left;font-weight:bold"><?= $id_text ?></td>
					<td width="45%;" style="text-align:left;font-weight:bold"><?= $customer_name_text?></td>
					<td width="12%" style="text-align:left;font-weight:bold""><?= $fb_ref_text?></td>
					<td width="12%" style="text-align:left;font-weight:bold""><?= $tw_ref_text?></td>
					<?php if($is_l){?>
						
					<td width="12%" style="text-align:left;font-weight:bold""><?= $linked_ref_text?></td>
					<?php }?>
					<td width="12%" style="text-align:left;font-weight:bold""><?= $google_ref_text?></td>
					
					
			</tr>
			<?php foreach ($_data_item as $stiker): 
				$customer_id = $stiker['id'];
			?>					
				<tr <?php if ($i): $i=false; ?>class="alt_row"<?php else: $i=true; endif; ?>>
					<td><?= $stiker['id'] ?></td>
					<td align="left"><b><?= $stiker['firstname'] ?> <?= $stiker['lastname'] ?></b></td>
					<td align="left"><?= $stiker['count_facebook'] ?></td>
					<td align="left"><?= $stiker['count_twitter'] ?></td>
					<?php if($is_l){?>
						
					<td align="left"><?= $stiker['count_linkedin'] ?></td>
					<?php }?>
					<td align="left"><?= $stiker['count_google'] ?></td>
					
			</tr>
	<?php endforeach; ?>
</table>

<br/>

<h3 style="padding-left:130px"><?= $customer_ref_text ?></h3>
<table style="margin:auto;text-align:center" width="100%" border="0">
	
	<tr>
		<td>
			<?php if (count($data)): ?>	
				<table class="table tableDnD" align="center" border="0" width="100%">
				<tr>
						<td width="5%" style="text-align:left;font-weight:bold"><?= $id_text ?></td>
						<td width="55%;" style="text-align:left;font-weight:bold"><?= $ip_text ?></td>
						<td width="40%" style="text-align:left;font-weight:bold"><?= $type_ref_text ?></td>
						
				</tr>
				<?php foreach ($data as $stiker): ?>
				<?php 
				switch($stiker['type']){
					
					case 1:
						$type = $fb_ref_one_text;
					break;
					case 2:
						$type = $tw_ref_one_text;
					break;
					case 3:
						$type = $linkedin_ref_one_text;
					break;
					case 4:
						$type = $google_ref_one_text;
					break;
					
				}
				?>					
					<tr <?php if ($i): $i=false; ?>class="alt_row"<?php else: $i=true; endif; ?>>
						<td><?= $stiker['id'] ?></td>
						<td align="left"><?= $stiker['ip'] ?></td>
						<td align="left"><?= $type ?></td>
						
					</tr>
				<?php endforeach; ?>
				</table>
			<?= $this->PageNavRef($start,$count_all,$step,$currentUrl,$customer_id); ?>
			<?php else: ?>
			<table class="table tableDnD" align="center" border="0" width="100%">
				<tr>
					<td style="border-bottom:none">
						<?= $no_items_text ?>
					</td>
				</tr>
			</table>
			<?php endif; ?>
		</td>
	</tr>
</table>
</fieldset>
<style type="text/css">
.pages { height:15px; padding:0 0 10px 10px; font-size:100%; margin-top:20px; line-height:1.2em;  }
.pages span, .pages b, .pages a { font-weight:bold; }
.pages a{color:#2580c7}
.pages span { color:#bbb; padding:1px 8px 2px 0; }
.pages span.nums { padding:0 10px 0 5px; }
.pages span.nums b, .pages span.nums a { padding:1px 6px 3px 6px; background:#ececec; text-decoration:none; margin-right:4px; }
.pages span.nums a:hover { background:#2580c7; color:#fff; }
.pages span.nums b { background:#6ec31c; color:#fff; }

</style>
