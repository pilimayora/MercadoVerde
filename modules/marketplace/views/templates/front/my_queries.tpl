<style>
	#center_column {
		width:757px !important;
	}
</style>
<div style="width:100%;margin-top:10px;float:left;">
<div style="float:left;width:100%;">
<div id="my_bulk_buy_query" style="float:left;width:200px;">Product Queries</div>
{if $is_seller == 1}
 <div style="float:right;width:175px;">
 <input type="button" value="Customers Queries" onclick="window.location.href='{$customer_queries}'" style="background-color:#4D90FE;border:1px solid #3079ED;color:#FFFFFF;text-shadow:0 1px rgba(0, 0, 0, 0.1);cursor:pointer;height:25px;">
 <input type="button" value="My Queries" onclick="window.location.href='{$link->getModuleLink('marketplace', 'my_queries')}'" style="background-color:#4D90FE;border:1px solid #3079ED;color:#FFFFFF;text-shadow:0 1px rgba(0, 0, 0, 0.1);cursor:pointer;height:25px;">
 </div>
{/if}
</div>
<input type="hidden" value="{$base_dir}" id="base_url" />
<table id="bulk_detail_table">
<tr>
<th>Product Name</th>
<th>Title</th>
<th>Date</th>
<th>Status</th>
</tr>

{if $count == 0}

<tr><td></td><td>No Enquiry</td><td></td><td></td></tr>
{else}

{assign var=j value=0}

	
	  {foreach from=$product_info item=foo}
		{if $j/2 == 0}
		<tr class="cus_enq" id="{$foo.id}">
		{else}
		<tr class="cus_enq" id="{$foo.id}" style="background-color:#C0C0C0;">
		{/if}
			<td>{$foo.product_name}</td>
			<td>{$foo.title}</td>
            <td>{$foo.date}</td>
			<td>My Queries</td>
			</tr>

	{assign var=j value=$j+1}
    {/foreach}
  	
{/if}
</table>

</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.cus_enq').click(function() {
		var id = $(this).attr('id');
		var url= $('#base_url').val();
		var base_url = url+'index.php?fc=module&module=marketplace&controller=my_queries_desc&id='+id;
		window.location.href = base_url;
		});
		});
</script>