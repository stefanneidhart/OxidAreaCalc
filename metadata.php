<?php
/**
 * @TODO LICENCE HERE
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'snAreaCalc',
    'title'       => array(
        'de' => 'OXID6 Flächenberechung mit Staffelpreis',
        'en' => 'OXID6 Flächenberechung mit Staffelpreis',
    ),
    'description' => array(
        'de' => '<h2>OXID6 Flächenberechung mit Staffelpreis</h2>',
        'en' => '<h2>OXID6 Flächenberechung mit Staffelpreis</h2>',
    ),
    'thumbnail'   => '',
    'version'     => '1.0.0',
    'author'      => 'Stefan Neidhart',
    'url'         => 'https://www.stefanneidhart.de',
    'email'       => 'info@stefanneidhart.de',
    'extend'      => array(
	
	'oxarticle' => 'areacalc2/application/models/sn_areacalc_oxarticle',
	'oxbasketitem' => 'areacalc2/application/models/sn_calcarea_oxbasketitem',
	'oxorderarticle' => 'areacalc2/application/models/sn_calcarea_oxorderarticle',
	'basket' => 'areacalc2/application/models/sn_calcarea_basket',
	'order' => 'areacalc2/application/models/sn_calcarea_order',
	'oxviewconfig' => 'areacalc2/application/models/sn_calcarea_oxviewconfig',
	'oxBasket' => 'areacalc2/application/models/sn_areacalc_oxBasket',	
    ),
    'controllers'       => array(  
        'maincontrollerareacalc' => \sn\oxid6AreacalcModule\Controller\Admin\MainController::class,
    ),  
    'files'       => array(),
    'templates'   => array(
        'article_calcsn.tpl' => 'sn/oxid6-areacalc-module/views/admin/article_calcsn.tpl',
	'ajaxareacalc.tpl' => 'areacalc2/out/tpl/page/details/inc/ajaxareacalc.tpl',
    ),
    'blocks'      => array(
	
	array(
	    'template' => 'page/details/inc/productmain.tpl',
	    'block' => 'details_productmain_shortdesc',
	    'file' => 'application/views/blocks/details_productmain_calctest.tpl'),
	array(
	    'template' => 'page/checkout/inc/basketcontents.tpl',
	    'block' => 'checkout_basketcontents_basketitem_titlenumber',
	    'file' => 'application/views/blocks/checkout_basketcontents_basketitem_titlenumber.tpl'
	),
	array(
	    'template' => 'page/account/order.tpl',
	    'block' => 'account_order_history',
	    'file' => 'application/views/blocks/account_order_history.tpl'
	),
	array(
	    'template' => 'email/html/order_owner.tpl',
	    'block' => 'email_html_order_owner_basketitem',
	    'file' => 'application/views/blocks/email_html_order_owner_basketitem.tpl'
	),
	array(
	    'template' => 'email/plain/order_owner.tpl',
	    'block' => 'email_plain_order_ownerbasketitem',
	    'file' => 'application/views/blocks/email_plain_order_ownerbasketitem.tpl'
	),
	
		array(
	    'template' => 'email/html/order_cust.tpl',
	    'block' => 'email_html_order_cust_basketitem',
	    'file' => 'application/views/blocks/email_html_order_cust_basketitem.tpl'
	),
	array(
	    'template' => 'email/plain/order_cust.tpl',
	    'block' => 'email_plain_order_cust_basketitem',
	    'file' => 'application/views/blocks/email_plain_order_cust_basketitem.tpl'
	),
	
	
	
    ),
    'settings' => array(
	array('group' => 'main', 'name' => 'testsetting', 'type' => 'bool', 'value' => 'true'),
    ),
    'files' => array(
	'snareacalcajax' => 'areacalc2/controllers/snareacalcajax.php',
    ),
);
