[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]


<script type="text/javascript">
<!--
	function loadLang(obj)
	{
		var langvar = document.getElementById("agblang");
		if (langvar != null)
			langvar.value = obj.value;
		document.myedit.submit();
	}
	function editThis(sID)
	{
		var oTransfer = top.basefrm.edit.document.getElementById("transfer");
		oTransfer.oxid.value = sID;
		oTransfer.cl.value = top.basefrm.list.sDefClass;
		//forcing edit frame to reload after submit
		top.forceReloadingEditFrame();
		var oSearch = top.basefrm.list.document.getElementById("search");
		oSearch.oxid.value = sID;
		oSearch.actedit.value = 0;
		oSearch.submit();
	}
	function deleteThis(sID)
	{
		blCheck = confirm("Wirklich löschen?");
		if (blCheck == true)
		{
			var oSearch = document.getElementById("transfer");
			oSearch.fnc.value = 'delete_type';
			oSearch.voxid.value = sID;
			oSearch.submit();
		}
	}
	function deleteStaffel(sID)
	{
		blCheck = confirm("Wirklich löschen?");
		if (blCheck == true)
		{
			var oSearch = document.getElementById("transfer");
			oSearch.fnc.value = 'delete_staffel';
			oSearch.voxid.value = sID;
			oSearch.submit();
		}
	}
//-->
</script>

[{ if $readonly }]
[{assign var="readonly" value="readonly disabled"}]
[{else}]
[{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="maincontrollerareacalc">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="voxid" value="[{ $oxid }]">
    <input type="hidden" name="editlanguage" value="[{ $editlanguage }]">
</form>


<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">

    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="maincontrollerareacalc">
    <input type="hidden" name="fnc" value="save">
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="voxid" value="[{ $oxid }]">
    <input type="hidden" name="oxparentid" value="[{ $oxparentid }]">
    <input type="hidden" name="editval[article__oxid]" value="[{ $oxid }]">

	<table>
		<tr>
			<td>Flächenberechnung aktivieren: </td>
			<td>   
				<input class="edittext" onClick="Javascript:document.myedit.submit()" type="checkbox" name="editval[oxarticles__oxcalctest]" value='1' [{if $edit->oxarticles__oxcalctest->value == 1}]checked[{/if}] [{ $readonly }]>
			</td>
		</tr>
		<tr>
			<td>Aufschlag Profilschine je m</td>
			<td>				
				<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="editval[oxarticles__areacalc_opt1]" value="[{$edit->oxarticles__areacalc_opt1->value}]"  [{ $readonly }]>
			</td>
		</tr>
		<tr>
			<td>Aufschlag vor Sturz je m²</td>
			<td>				
				<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="editval[oxarticles__areacalc_opt2]" value="[{$edit->oxarticles__areacalc_opt2->value}]"  [{ $readonly }]>
			</td>
		</tr>
			<tr>
				<td></td>
						<td>
							<input type="submit" class="edittext" name="save" value="speichern" [{ $readonly }]>
						</td>
					</tr>
	</table>


</form>
<table border="0">
    <tr>
		<td class="edittext">
			<h2>Typen</h2>
			[{if count($calctypes) > 0}]

			<table>
				<form name="myedit1" id="myedit1" action="[{ $oViewConf->getSelfLink() }]" method="post">
					[{ $oViewConf->getHiddenSid() }]
					<input type="hidden" name="cl" value="maincontrollerareacalc">
					<input type="hidden" name="fnc" value="save_types">
					<input type="hidden" name="oxid" value="[{ $oxid }]">
					<input type="hidden" name="voxid" value="[{ $oxid }]">
					<input type="hidden" name="oxparentid" value="[{ $oxparentid }]">
					<input type="hidden" name="editval[article__oxid]" value="[{ $oxid }]">

					<tr id="type_row_head">
						<td class="[{ $listclass}]">
							Type
						</td>
						<td class="[{ $listclass}]">
							Streifen
						</td>
						<td class="[{ $listclass}]">
							min. Höhe in m
						</td>	
						<td class="[{ $listclass}]">
							max. Höhe in m
						</td>
						<td class="[{ $listclass}]">
							Gewicht/m² in g			</td>					


					</tr>


					[{foreach from=$calctypes item=typeitem}]
					[{assign var="_cnt1" value=$_cnt1+1}]
					<tr id="type_row.[{$_cnt1}]">
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typevalsave[[{$typeitem.OXID}]][title]" value="[{$typeitem.title}]"  [{ $readonly }]>
						</td>
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typevalsave[[{$typeitem.OXID}]][title2]" value="[{$typeitem.title2}]"  [{ $readonly }]>
						</td>
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typevalsave[[{$typeitem.OXID}]][hoehe_min]" value="[{$typeitem.hoehe_min}]"  [{ $readonly }]>
						</td>	
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typevalsave[[{$typeitem.OXID}]][hoehe_max]" value="[{$typeitem.hoehe_max}]" [{ $readonly }]>
						</td>	
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typevalsave[[{$typeitem.OXID}]][gewicht]" value="[{$typeitem.gewicht}]"  [{ $readonly }]>
						</td>					
						<td class="[{ $listclass}]">
							<a href="Javascript:deleteThis('[{$typeitem.areacalctypeid}]');" class="delete"></a>
						</td>
					</tr>
					[{/foreach}]
					<tr>
						<td>
							<input type="submit" class="edittext" name="save_types" value="Typen speichern" [{ $readonly }]>
						</td>
					</tr>
				</form>
			</table>
			[{/if}]
		</td>         
    </tr>
    <tr>
		<td class="edittext">

			<form name="myedit2" id="myedit2" action="[{ $oViewConf->getSelfLink() }]" method="post">
				[{ $oViewConf->getHiddenSid() }]
				<input type="hidden" name="cl" value="maincontrollerareacalc">
				<input type="hidden" name="fnc" value="add_type">
				<input type="hidden" name="oxid" value="[{ $oxid }]">
				<input type="hidden" name="voxid" value="[{ $oxid }]">
				<input type="hidden" name="oxparentid" value="[{ $oxparentid }]">
				<input type="hidden" name="editval[article__oxid]" value="[{ $oxid }]">
				<table>
					<tr id="type_row_head">
						<td class="[{ $listclass}]">
							Type
						</td>
						<td class="[{ $listclass}]">
							Streifen
						</td>
						<td class="[{ $listclass}]">
							min. Höhe in m
						</td>	
						<td class="[{ $listclass}]">
							max. Höhe in m
						</td>
						<td class="[{ $listclass}]">
							Gewicht/m² in g			
						</td>					
					</tr>	
					<tr id="type_row_head">
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typeval[title]" value="" onClick="Javascript:document.myedit2.fnc.value = 'add_type'"" [{ $readonly }]>
						</td>
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typeval[desc]" value="" onClick="Javascript:document.myedit2.fnc.value = 'add_type'"" [{ $readonly }]>
						</td>
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typeval[hoehe_min]" value="" onClick="Javascript:document.myedit2.fnc.value = 'add_type'"" [{ $readonly }]>
						</td>	
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typeval[hoehe_max]" value="" onClick="Javascript:document.myedit2.fnc.value = 'add_type'"" [{ $readonly }]>
						</td>
						<td class="[{ $listclass}]">
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="typeval[gewicht]" value="" onClick="Javascript:document.myedit2.fnc.value = 'add_type'"" [{ $readonly }]>
						</td>					
						<td>
							<input type="submit" class="edittext" name="add_type" value="Type hinzufügen" [{ $readonly }]><br>
						</td>
					</tr>				
				</table>
			</form>  
		</td>
    </tr>
	<tr>
		<td class="edittext">
			<h2>Staffelungen</h2>
			<form name="myeditstaffel" id="myeditstaffel" action="[{ $oViewConf->getSelfLink() }]" method="post">

				[{ $oViewConf->getHiddenSid() }]
				<input type="hidden" name="cl" value="maincontrollerareacalc">
				<input type="hidden" name="fnc" value="save_staffeln">
				<input type="hidden" name="oxid" value="[{ $oxid }]">
				<input type="hidden" name="voxid" value="[{ $oxid }]">
				<input type="hidden" name="oxparentid" value="[{ $oxparentid }]">
				<input type="hidden" name="editval[article__oxid]" value="[{ $oxid }]">
				<table>
					<tr>

						<td>
							Type
						</td>

						[{foreach from=$staffelungen item=staffelitem}]
						[{assign var="_cnt1" value=$_cnt1+1}]
						<td>
							<a href="Javascript:deleteStaffel('[{$staffelitem.staffel}]');" class="delete"></a><span>[{$staffelitem.staffel}] Meter</span>
						</td>
						[{/foreach}]
					</tr>
					[{foreach from=$calctypes item=typeitem}]
					[{assign var="_cnt1" value=$_cnt1+1}]
					<tr>
						<td>
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="title_[{$_cnt1}]" value="[{$typeitem.title}]" readonly>
						</td>
[{*$typeitem|@var_dump*}] 
	
						[{foreach from=$typeitem.staffeln item=staffel}]

						<td>
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="staffelungen[[{$typeitem.OXID}]][[{$staffel.staffel}]]" value="[{$staffel.preis}]" >
						</td>


						[{/foreach}]
					</tr>
					[{/foreach}]
				</table>

				<table>
					<tr>
						<td>
							<input type="submit" class="edittext" name="save_staffeln" value="Staffelungen speichern" [{ $readonly }]><br>
						</td>
					</tr>
				</table>
			</form>  
		</td>
    </tr>


    <tr>
		<td class="edittext">
			<form name="myedit2" id="myedit3" action="[{ $oViewConf->getSelfLink() }]" method="post">

				[{ $oViewConf->getHiddenSid() }]
				<input type="hidden" name="cl" value="maincontrollerareacalc">
				<input type="hidden" name="fnc" value="add_staffel">
				<input type="hidden" name="oxid" value="[{ $oxid }]">
				<input type="hidden" name="voxid" value="[{ $oxid }]">
				<input type="hidden" name="oxparentid" value="[{ $oxparentid }]">
				<input type="hidden" name="editval[article__oxid]" value="[{ $oxid }]">
				<table>
					<tr>
						<td>
							<input type="text" class="editinput" size="20" maxlength="[{$edit->oxarticles__oxcalctest->fldmax_length}]" name="staffelval[staffelung]" value="Höhe in Meter" onClick="Javascript:document.myedit2.fnc.value = 'add_staffel'"" [{ $readonly }]>
						</td>	<td>
							<input type="submit" class="edittext" name="add_staffel" value="Staffelung hinzufügen" [{ $readonly }]><br>
						</td>
					</tr>
				</table>
			</form>  
		</td>
    </tr>
</table>  
[{$edit->oxarticles__AREACALC}]
[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]