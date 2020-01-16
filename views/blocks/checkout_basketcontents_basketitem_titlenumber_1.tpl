[{* product title & number *}]

<td>
    <div>
	<a rel="nofollow" href="[{$basketitem->getLink()}]"><b>[{$basketitem->getTitle()}]</b></a>

	[{if $basketitem->isSkipDiscount() }] <sup><a rel="nofollow" href="#noteWithSkippedDiscount" >[{$oMarkGenerator->getMark('skippedDiscount')}]</a></sup>[{/if}]
	[{if $oViewConf->getActiveClassName() == 'order' && $oViewConf->isFunctionalityEnabled('blEnableIntangibleProdAgreement')}]
	[{if $oArticle->hasDownloadableAgreement() }] <sup><a rel="nofollow" href="#noteForDownloadableArticles" >[{$oMarkGenerator->getMark('downloadable')}]</a></sup>[{/if}]
	[{if $oArticle->hasIntangibleAgreement() }] <sup><a rel="nofollow" href="#noteForIntangibleArticles" >[{$oMarkGenerator->getMark('intangible')}]</a></sup>[{/if}]
	[{/if}]
    </div>
    <div class="smallFont">
	[{ oxmultilang ident="PRODUCT_NO" suffix="COLON" }] [{ $basketproduct->oxarticles__oxartnum->value }]
    </div>
    <div class="smallFont">
	[{assign var=sep value=", "}]
	[{assign var=result value=""}]
	[{foreach key=oArtAttributes from=$oAttributes->getArray() item=oAttr name=attributeContents}]
	[{assign var=temp value=$oAttr->oxattribute__oxvalue->value}]
	[{assign var=result value=$result$temp$sep}]
	[{/foreach}]
	<b>[{$result|trim:$sep}]</b>
    </div>

    [{if !$basketitem->isBundle() || !$basketitem->isDiscountArticle()}]
    [{assign var="oSelections" value=$basketproduct->getSelections(null,$basketitem->getSelList())}]
    [{if $oSelections}]
    <div class="selectorsBox clear" id="cartItemSelections_[{$smarty.foreach.basketContents.iteration}]">
	[{foreach from=$oSelections item=oList name=selections}]
	[{if $oViewConf->showSelectListsInList()}]
	[{include file="widget/product/selectbox.tpl" oSelectionList=$oList sFieldName="aproducts[`$basketindex`][sel]" iKey=$smarty.foreach.selections.index blHideDefault=true sSelType="seldrop"}]
	[{else}]
	[{assign var="oActiveSelection" value=$oList->getActiveSelection()}]
	[{if $oActiveSelection}]
	<input type="hidden" name="aproducts[[{$basketindex}]][sel][[{$smarty.foreach.selections.index}]]" value="[{if $oActiveSelection }][{$oActiveSelection->getValue()}][{/if}]">
	<div>[{$oList->getLabel()}]: [{$oActiveSelection->getName()}]</div>
	[{/if}]
	[{/if}]
	[{/foreach}]
    </div>
    [{/if}]
    [{/if}]

    [{assign var=aParams value=$basketitem->getPersParams()}]

    [{if !$editable }]

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
    <p class="persparamBox">
	[{foreach key=sVar from=$basketitem->getPersParams() item=aParam name=persparams }]
	[{if !$smarty.foreach.persparams.first}]<br />[{/if}]
	<strong>
	    [{if $smarty.foreach.persparams.first && $smarty.foreach.persparams.last}]
	    [{ oxmultilang ident="LABEL" suffix="COLON" }]
	    [{else}]
	    [{ $sVar }] :
	    [{/if}]
	</strong> [{ $aParam }]
	[{/foreach}]
    </p>

    [{/if}]
    [{else}]



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


    [{if $basketproduct->oxarticles__oxisconfigurable->value}]
    [{if $basketitem->getPersParams()}]
    <br />
    
    

    [{foreach key=sVar from=$basketitem->getPersParams() item=aParam name=persparams }]  xxx
    <p>
	<label class="persParamLabel">
	    [{if $smarty.foreach.persparams.first && $smarty.foreach.persparams.last}]
	    [{ oxmultilang ident="LABEL" suffix="COLON" }]
	    [{else}]
	    [{ $sVar }]:
	    [{/if}] 
	</label>
	<input class="textbox persParam" type="text" name="aproducts[[{ $basketindex }]][persparam][[{ $sVar }]]" value="[{ $aParam }]">
    </p>
    [{/foreach}]




    [{else}]
    <p>[{ oxmultilang ident="LABEL" suffix="COLON" }] <input class="textbox persParam" type="text" name="aproducts[[{ $basketindex }]][persparam][details]" value=""></p>
    [{/if}]


    [{/if}]
    [{/if}]
    [{/if}]

</td>