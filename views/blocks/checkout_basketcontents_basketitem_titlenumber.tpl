[{assign var=aParams value=$basketitem->getPersParams()}]

[{*$aParams|var_dump*}]

    [{if $aParams.areacalc_active == '1' }]

    <p class="persparamBox">
		[{assign var=aMaterial value=$basketitem->getMaterial($aParams.MaterialTypesSelect)}]
		<strong>Material: </strong> [{$aMaterial.title}]<br />
		<strong>Breite: </strong> [{$aParams.breite}]<br />
		<strong>Höhe: </strong> [{$aParams.hoehe}]
		[{if $aParams.areacalc_opt1 == '1' }]<br /><strong>Edelstahlprofilschine:</strong> ja[{/if}]
		[{if $aParams.areacalc_opt2 == '1' }]<br /><strong>S - vor Sturz:</strong> ja[{/if}]
    </p>
	  [{else}]
	[{if !$editable}]
                                        <p class="persparamBox">
                                            <small>
                                                [{foreach key=sVar from=$basketitem->getPersParams() item=aParam name=persparams}]
                                                    [{if !$smarty.foreach.persparams.first}]<br />[{/if}]
                                                    [{if $smarty.foreach.persparams.first && $smarty.foreach.persparams.last}]
                                                        [{oxmultilang ident="LABEL"}]
                                                    [{else}]
                                                        [{$sVar}] :
                                                    [{/if}]
                                                    [{$aParam}]
                                                [{/foreach}]
                                            </small>
                                        </p>
                                    [{else}]
                                        [{if $basketproduct->oxarticles__oxisconfigurable->value}]
                                            [{if $basketitem->getPersParams()}]
                                                <br />
                                                [{foreach key=sVar from=$basketitem->getPersParams() item=aParam name=persparams}]
                                                    <p>
                                                        <input class="textbox persParam form-control" type="text" name="aproducts[[{$basketindex}]][persparam][[{$sVar}]]" value="[{$aParam}]" placeholder="[{if $smarty.foreach.persparams.first && $smarty.foreach.persparams.last}][{oxmultilang ident="LABEL"}][{else}][{$sVar}][{/if}]">
                                                    </p>
                                                [{/foreach}]
                                            [{else}]
                                                <p>
                                                    <input class="textbox persParam form-control" type="text" name="aproducts[[{$basketindex}]][persparam][details]" value="" placeholder="[{oxmultilang ident="LABEL"}]">
                                                </p>
                                            [{/if}]
                                        [{/if}]
                                    [{/if}]
                                
	
	
    [{/if}] 