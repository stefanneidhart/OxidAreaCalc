[{assign var="basketproduct" value=$basketitemlist.$basketindex }]

<tr valign="top">
	<td style="padding: 5px; border-bottom: 4px solid #ddd;">
		<img src="[{$basketproduct->getThumbnailUrl(false)}]" border="0" hspace="0" vspace="0" alt="[{$basketitem->getTitle()|strip_tags}]" align="texttop">
		[{if $oViewConf->getShowGiftWrapping() }]
		[{assign var="oWrapping" value=$basketitem->getWrapping() }]
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
			<b>[{oxmultilang ident="GIFT_WRAPPING" suffix="COLON"}]&nbsp;</b>
			[{if !$basketitem->getWrappingId() }]
			[{oxmultilang ident="NONE" }]
			[{else}]
			[{$oWrapping->oxwrapping__oxname->value}]
			[{/if}]
		</p>
		[{/if}]
	</td>
	<td style="padding: 5px; border-bottom: 4px solid #ddd;">
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
			<b>[{$basketitem->getTitle()}]</b>
			[{if $basketitem->getChosenSelList() }]
		<ul style="padding: 0 10px; margin: 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
			[{foreach from=$basketitem->getChosenSelList() item=oList}]
			<li style="padding: 3px;">[{ $oList->name }] [{ $oList->value }]</li>
			[{/foreach}]
		</ul>
		[{/if}]
		[{if $basketitem->getPersParams() }]


		<ul style="padding: 0 10px; margin: 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
			[{assign var=oxPersParams value=$basketitem->getPersParams()}]
			[{if $oxPersParams.areacalc_active == 1 }]

			[{foreach key=sVar from=$basketitem->getPersParams() item=aParam}]
				[{if $sVar != 'areacalc_active' }]
				
				
					[{if $sVar == 'MaterialTypesSelect' }]
						<li style="padding: 3px;">[{ oxmultilang ident=$sVar suffix="COLON" }] [{$basketitem->getMaterialName($aParam)}]</li>
					[{elseif $sVar == 'areacalc_opt1' || $sVar == 'areacalc_opt2'}]  
					
						[{if $aParam == 1}]
							<li style="padding: 3px;">[{ oxmultilang ident=$sVar suffix="COLON" }] [{ oxmultilang ident="ja" }]</li>
						[{/if}]
					[{else}]
						<li style="padding: 3px;">[{ oxmultilang ident=$sVar suffix="COLON" }] [{$aParam}]</li>
					[{/if}]       
				[{/if}]   
			[{/foreach}]

			[{else }]


			[{foreach key=sVar from=$basketitem->getPersParams() item=aParam}]
			<li style="padding: 3px;">[{$sVar}] : [{$aParam}]</li>
			[{/foreach}]

			[{/if}]  
		</ul>
		[{/if}]
		<br>
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
			<b>[{oxmultilang ident="PRODUCT_NO" suffix="COLON" }] [{ $basketproduct->oxarticles__oxartnum->value }]</b>
		</p>
	</p>
</td>
<td style="padding: 5px; border-bottom: 4px solid #ddd;" align="right">
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
		<b>[{if $basketitem->getUnitPrice() }][{oxprice price=$basketitem->getUnitPrice() currency=$currency }][{/if}]</b>
		[{if !$basketitem->isBundle() }]
		[{assign var=dRegUnitPrice value=$basketitem->getRegularUnitPrice()}]
		[{assign var=dUnitPrice value=$basketitem->getUnitPrice()}]
		[{if $dRegUnitPrice->getPrice() > $dUnitPrice->getPrice() }]
		<br><s>[{oxprice price=$basketitem->getRegularUnitPrice() currency=$currency }]</s>
		[{/if}]
		[{/if}]
	</p>
	[{if $basketitem->aDiscounts}]
	<p>
		<em style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">[{oxmultilang ident="DISCOUNT" suffix="COLON" }]
			[{foreach from=$basketitem->aDiscounts item=oDiscount}]
			<br>[{ $oDiscount->sDiscount }]
			[{/foreach}]
		</em>
	</p>
	[{/if}]

	[{if $basketproduct->oxarticles__oxorderinfo->value }]
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
		[{ $basketproduct->oxarticles__oxorderinfo->value }]
	</p>
	[{/if}]
</td>
<td style="padding: 5px; border-bottom: 4px solid #ddd;" align="right">
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
		<b>[{$basketitem->getAmount()}]</b>
	</p>
</td>
<td style="padding: 5px; border-bottom: 4px solid #ddd;" align="right">
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
		[{$basketitem->getVatPercent() }]%
	</p>
</td>
<td style="padding: 5px; border-bottom: 4px solid #ddd;" align="right">
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;">
		<b>[{oxprice price=$basketitem->getPrice() currency=$currency}]</b>
	</p>
</td>
[{if $blShowReviewLink}]
<td style="padding: 5px; border-bottom: 4px solid #ddd;">
	<a href="[{ $oConf->getShopURL() }]index.php?shp=[{$shop->oxshops__oxid->value}]&amp;anid=[{$basketitem->getProductId()}]&amp;cl=review&amp;reviewuserhash=[{$user->getReviewUserHash($user->getId())}]" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;" target="_blank">[{oxmultilang ident="REVIEW" }]</a>
</td>
[{/if}]
</tr>