[{assign var="basketproduct" value=$basketitemlist.$basketindex }]
<tr valign="top">
    <td style="padding: 5px; border-bottom: 4px solid #ddd;">
		<img src="[{$basketproduct->getThumbnailUrl(false) }]" border="0" hspace="0" vspace="0" alt="[{$basketitem->getTitle()|strip_tags}]" align="texttop">
		[{if $oViewConf->getShowGiftWrapping() }]
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
			[{assign var="oWrapping" value=$basketitem->getWrapping() }]
			<b>[{oxmultilang ident="GIFT_WRAPPING" suffix="COLON" }]&nbsp;</b>[{if !$basketitem->getWrappingId() }][{oxmultilang ident="NONE" }][{else}][{$oWrapping->oxwrapping__oxname->value}][{/if}]
		</p>
		[{/if}]
    </td>
    <td style="padding: 5px; border-bottom: 4px solid #ddd;">
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
			<b>[{$basketitem->getTitle()}]</b>
			[{if $basketitem->getChosenSelList() }],
			[{foreach from=$basketitem->getChosenSelList() item=oList}]
			[{ $oList->name }] [{ $oList->value }]&nbsp;
			[{/foreach}]
			[{/if}]
			[{if $basketitem->getPersParams() }]	    

			[{assign var=oxPersParams value=$basketitem->getPersParams()}]
			[{if $oxPersParams.areacalc_active == 1 }]

			[{foreach key=sVar from=$basketitem->getPersParams() item=aParam}]
				[{if $sVar != 'areacalc_active' }]
					[{if $sVar == 'MaterialTypesSelect' }]
						,&nbsp;<em>[{ oxmultilang ident=$sVar suffix="COLON" }] [{$basketitem->getMaterialName($aParam)}]</em>
					[{elseif $sVar == 'areacalc_opt1' && $aParam == 1  || $sVar == 'areacalc_opt2' && $aParam == 1 }]  
						,&nbsp;<em>[{ oxmultilang ident=$sVar suffix="COLON" }] [{ oxmultilang ident="ja" }]</li>
					[{else }]
						,&nbsp;<em>[{ oxmultilang ident=$sVar suffix="COLON" }] [{$aParam}]</em>
					[{/if}]      
				[{/if}]   
			[{/foreach}]

			[{else }]


			[{foreach key=sVar from=$basketitem->getPersParams() item=aParam}]
			,&nbsp;<em>[{$sVar}] : [{$aParam}]</em>                                  [{/foreach}]

			[{/if}]  









			[{/if}]
			<br>[{oxmultilang ident="PRODUCT_NO" suffix="COLON" }] [{ $basketproduct->oxarticles__oxartnum->value }]
			</p>
			</td>
			<td style="padding: 5px; border-bottom: 4px solid #ddd;">
				<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
					<b>[{if $basketitem->getUnitPrice() }][{oxprice price=$basketitem->getUnitPrice() currency=$currency }][{/if}]</b>
					[{if !$basketitem->isBundle() }]
					[{assign var=dRegUnitPrice value=$basketitem->getRegularUnitPrice()}]
					[{assign var=dUnitPrice value=$basketitem->getUnitPrice()}]
					[{if $dRegUnitPrice->getPrice() > $dUnitPrice->getPrice() }]
					<br><s>[{oxprice price=$basketitem->getRegularUnitPrice() currency=$currency }]</s>
					[{/if}]
					[{/if}]
					[{if $basketitem->aDiscounts}]<br><br>
					<em style="font-size: 7pt;font-weight: normal;">[{oxmultilang ident="DISCOUNT" suffix="COLON" }]
						[{foreach from=$basketitem->aDiscounts item=oDiscount}]
						<br>[{ $oDiscount->sDiscount }]
						[{/foreach}]
					</em>
					[{/if}]
					[{if $basketproduct->oxarticles__oxorderinfo->value }]
					[{ $basketproduct->oxarticles__oxorderinfo->value }]
					[{/if}]
				</p>
			</td>
			<td style="padding: 5px; border-bottom: 4px solid #ddd;">
				<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
					[{$basketitem->getAmount()}]
				</p>
			</td>
			<td style="padding: 5px; border-bottom: 4px solid #ddd;">
				<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
					[{$basketitem->getVatPercent() }]%
				</p>
			</td>
			<td style="padding: 5px; border-bottom: 4px solid #ddd;">
				<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 10px 0;">
					<b>[{oxprice price=$basketitem->getPrice() currency=$currency}]</b>
				</p>
			</td>
</tr>