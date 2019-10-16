[{assign var="basketproduct" value=$basketitemlist.$basketindex }]
[{ $basketproduct->oxarticles__oxtitle->getRawValue()|strip_tags }][{ if $basketproduct->oxarticles__oxvarselect->value}], [{ $basketproduct->oxarticles__oxvarselect->value}][{/if}]
[{ if $basketitem->getChosenSelList() }][{foreach from=$basketitem->getChosenSelList() item=oList}]

[{ $oList->name }] [{ $oList->value }]

[{ /foreach }][{ /if }]
[{ if $basketitem->getPersParams() }]
[{ foreach key=sVar from=$basketitem->getPersParams() item=aParam }]

[{ $sVar }] : [{ $aParam }]
[{ /foreach }]
[{ /if }]
[{ if $oViewConf->getShowGiftWrapping() }]
[{ assign var="oWrapping" value=$basketitem->getWrapping() }]

[{ oxmultilang ident="GIFT_WRAPPING" suffix="COLON" }] [{ if !$basketitem->getWrappingId() }][{ oxmultilang ident="NONE" }][{else}][{$oWrapping->oxwrapping__oxname->value}][{/if}]
[{ /if }]
[{ if $basketproduct->oxarticles__oxorderinfo->value }]
[{ $basketproduct->oxarticles__oxorderinfo->getRawValue() }]
[{ /if }]

[{assign var=dRegUnitPrice value=$basketitem->getRegularUnitPrice()}]
[{assign var=dUnitPrice value=$basketitem->getUnitPrice()}]
[{ oxmultilang ident="UNIT_PRICE" }] [{oxprice price=$basketitem->getUnitPrice() currency=$currency }] [{if !$basketitem->isBundle() }][{if $dRegUnitPrice->getPrice() > $dUnitPrice->getPrice() }] ([{oxprice price=$basketitem->getRegularUnitPrice() currency=$currency }]) [{/if}][{/if}]

[{ oxmultilang ident="QUANTITY" }] [{$basketitem->getAmount()}]
[{ oxmultilang ident="VAT" }] [{$basketitem->getVatPercent() }]%
[{ oxmultilang ident="TOTAL" }] [{oxprice price=$basketitem->getPrice() currency=$currency}]