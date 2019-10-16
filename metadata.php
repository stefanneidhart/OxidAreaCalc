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
    ),
    'controllers'       => array( 
        'maincontrollerareacalc' => \sn\oxid6-areacalc-module\Controller\Admin\MainController::class,
    ),
    'files'       => array(),
    'templates'   => array(
        'main.tpl' => 'sn/oxid6-areacalc-module/views/admin/main.tpl'
    ),
    'blocks'      => array(),
    'settings'    => array(),
    'events'      => array(),
);
