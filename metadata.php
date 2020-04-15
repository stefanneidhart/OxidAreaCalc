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
	'id' => 'snareacalc',
	'title' => array(
		'de' => 'Streifenvorhang mit Staffelpreis',
		'en' => 'Streifenvorhang mit Staffelpreis',
	),
	'description' => array(
		'de' => '<h2>Streifenvorhang mit Staffelpreis</h2>',
		'en' => '<h2>Streifenvorhang mit Staffelpreis</h2>',
	),
	'thumbnail' => 'calc.png',
	'version' => '1.0.9',
	'author' => 'Stefan Neidhart',
	'url' => 'https://www.stefanneidhart.de',
	'email' => 'info@stefanneidhart.de',
	'extend' => array(
		\OxidEsales\Eshop\Application\Model\Article::class => \sn\snareacalc\Model\Article::class,
		// \OxidEsales\Eshop\Application\Model\Basket::class => \sn\snareacalc\Model\Basket::class,
		\OxidEsales\Eshop\Application\Model\BasketItem::class => \sn\snareacalc\Model\BasketItem::class,
		\OxidEsales\Eshop\Application\Model\OrderArticle::class => \sn\snareacalc\Model\OrderArticle::class,
		\OxidEsales\Eshop\Application\Component\BasketComponent::class => \sn\snareacalc\Component\BasketComponent::class,
	),
	'controllers' => array(
		'maincontrollerareacalc' => \sn\snareacalc\Controller\Admin\MainController::class,
	),
	'files' => array(),
	'templates' => array(
		'articlecalcsn.tpl' => 'sn/snareacalc/views/admin/tpl/articlecalcsn.tpl'
	),
	'blocks' => array(
		array(
			'template' => 'page/account/order.tpl',
			'block' => 'account_order_history',
			'file' => 'views/blocks/account/account_order_history.tpl'
		),	    
		array(
			'template' => 'page/checkout/inc/basketcontents_list.tpl',
			'block' => 'checkout_basketcontents_basketitem_persparams',
			'file' => 'views/blocks/checkout/inc/checkout_basketcontents_basketitem_persparams.tpl'
		),
		array(
			'template' => 'email/html/order_owner.tpl',
			'block' => 'email_html_order_owner_basketitem',
			'file' => 'views/blocks/email/html/email_html_order_owner_basketitem.tpl'
		),	    
		array(
			'template' => 'email/html/order_cust.tpl',
			'block' => 'email_html_order_cust_basketitem',
			'file' => 'views/blocks/email/html/email_html_order_cust_basketitem.tpl'
		),	    
		array(
			'template' => 'email/plain/order_owner.tpl',
			'block' => 'email_plain_order_ownerbasketitem',
			'file' => 'views/blocks/email/plain/email_plain_order_ownerbasketitem.tpl'
		),
		array(
			'template' => 'email/plain/order_cust.tpl',
			'block' => 'email_plain_order_cust_basketitem',
			'file' => 'views/blocks/email/plain/email_plain_order_cust_basketitem.tpl'
		),	    
	    
		array(
			'template' => 'page/details/inc/productmain.tpl',
			'block' => 'details_productmain_shortdesc',
			'file' => 'views/blocks/page/inc/details_productmain_streifenvorhaenge.tpl'),
	),
);
