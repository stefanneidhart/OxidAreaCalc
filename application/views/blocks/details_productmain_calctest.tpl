[{$smarty.block.parent}]

[{if $oDetailsProduct->oxarticles__oxcalctest->value == 1}]

[{oxstyle include=$oViewConf->getModuleUrl("snAreaCalc", "out/src/css/sn_calc.css") }]

[{assign var="staffeltypen" value=$oDetailsProduct->get_types()}]
[{assign var="typesjson" value=$oDetailsProduct->get_types_json()}]

<script type="text/javascript">
<!--
	var typejsonraw = '[{$typesjson}]';
	var option1 = '[{$oDetailsProduct->getOption1()}]';
	var option2 = '[{$oDetailsProduct->getOption2()}]';
//-->
</script>
[{oxscript include=$oViewConf->getModuleUrl("snAreaCalc", "out/src/js/sn_calc.js") }]

<div class="PreisKalkulationContainer">    
    <div class="InputContainer">
		<div class="itemrow MaterialTypContainer">
			<label>Material:</label>
			<select class="MaterialTypesSelect" id="MaterialTypesSelect" name="MaterialTypesSelect">
				[{foreach from=$staffeltypen item=oMaterialTypen key=iKey}]

				<option value="[{$oMaterialTypen.areacalctypeid}]">[{$oMaterialTypen.title}] - [{$oMaterialTypen.title2}]</option>

				[{/foreach}]
			</select>
		</div>
		<div class="itemrow HoeheContainer">
			<label>Höhe:</label>
			<input id="hoehe" type="text" name="hoehe" value="1" size="3" autocomplete="off" class="textbox">
		</div>	
		<div class="itemrow BreiteContainer">
			<label>Breite:</label>
			<input id="breite" type="text" name="breite" value="1" size="3" autocomplete="off" class="textbox">
			<input id="areacalc_active" name="areacalc_active" value="1" autocomplete="off" type="hidden">
		</div>		
    </div>
    <div class="ResultContainer">
		<div class="itemrow AreaContainer">
			<label>Fläche:</label>
			<div id="AreaResult" class="AreaResult"></div>
			<input id="flaeche" type="hidden" name="flaeche" value="1" size="3" autocomplete="off" class="textbox">
		</div>

		<div class="itemrow WeightContainer">
			<label>Gewicht:</label>
			<div class="WeightResult"></div>
			<input id="CalcWeight" type="hidden" name="CalcWeight" value="1" size="3" autocomplete="off" class="textbox">
		</div>

		<div class="itemrow StahlschieneContainer">
			<label>Edelstahlprofilschine:</label>
			<div class="WeightResult"></div>
			<input class="edittext" type="checkbox" id="areacalc_opt1" name="areacalc_opt1" value='1' [{if $oDetailsProduct->oxarticles__areacalc_opt1->value == 1}]checked[{/if}] [{ $readonly }]>
		</div>
		
		<div class="itemrow VorSturtzContainer">
			<label>S - vor Sturz</label>
			<div class="WeightResult"></div>
			<input class="edittext" type="checkbox" id="areacalc_opt2" name="areacalc_opt2" value='1' [{if $oDetailsProduct->oxarticles__areacalc_opt2->value == 1}]checked[{/if}] [{ $readonly }]>
		</div>		

    </div>

</div>

[{/if}]