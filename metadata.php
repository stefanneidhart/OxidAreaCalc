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
    'version'     => '1.0.2',
    'author'      => 'Stefan Neidhart',
    'url'         => 'https://www.stefanneidhart.de',
    'email'       => 'info@stefanneidhart.de',
    'extend'      => array(
	
	/*'oxarticle' => 'oxid6-areacalc-module/application/models/sn_areacalc_oxarticle',
	'oxbasketitem' => 'oxid6-areacalc-module/application/models/sn_calcarea_oxbasketitem',
	'oxorderarticle' => 'oxid6-areacalc-module/application/models/sn_calcarea_oxorderarticle',
	'basket' => 'oxid6-areacalc-module/application/models/sn_calcarea_basket',
	'order' => 'oxid6-areacalc-module/application/models/sn_calcarea_order',
	'oxviewconfig' => 'oxid6-areacalc-module/application/models/sn_calcarea_oxviewconfig',
	'oxBasket' => 'oxid6-areacalc-module/application/models/sn_areacalc_oxBasket',	*/
	
		'oxarticle' => \sn\oxid6AreacalcModule\Controller\Admin\sn_areacalc_oxarticle::class,
	'oxbasketitem' => \sn\oxid6AreacalcModule\Controller\Admin\sn_calcarea_oxbasketitem::class,
	'oxorderarticle' => \sn\oxid6AreacalcModule\Controller\Admin\sn_calcarea_oxorderarticle::class,
	'basket' => \sn\oxid6AreacalcModule\Controller\Admin\sn_calcarea_basket::class,
	'order' => \sn\oxid6AreacalcModule\Controller\Admin\sn_calcarea_order::class,
	'oxviewconfig' => \sn\oxid6AreacalcModule\Controller\Admin\sn_calcarea_oxviewconfig::class,
	'oxBasket' => \sn\oxid6AreacalcModule\Controller\Admin\sn_areacalc_oxBasket::class,
	
	
    ),
    'controllers'       => array(  
        'maincontrollerareacalc' => \sn\oxid6AreacalcModule\Controller\Admin\MainController::class,
    ),  
    'files'       => array(),
    'templates'   => array(
        'articlecalcsn.tpl' => 'sn/oxid6-areacalc-module/views/admin/articlecalcsn.tpl',
	'ajaxareacalc.tpl' => 'oxid6-areacalc-module/out/tpl/page/details/inc/ajaxareacalc.tpl',
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
	'snareacalcajax' => 'oxid6-areacalc-module/controllers/snareacalcajax.php',
    ),
);
