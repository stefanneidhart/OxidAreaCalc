<?php

/**
 * @TODO LICENCE
 */

namespace sn\snareacalc\Controller\Admin;

use oxRegistry;
use oxDb;
use oxField;
use stdClass;
use Exception;

/**
 * Class LinslinSliderMain.
 */
class MainController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController {

    protected $_oArticle = null;
    protected $_sThisTemplate = 'articlecalcsn.tpl';

    public function __construct() { 
		//var_dump($this->_sThisTemplate);
    }

    public function getDB() {
	return \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
    }

    public function render() {

	try {

	    $myConfig = $this->getConfig();

	    parent::render();

	    $this->_aViewData["edit"] = $oArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
	    ;

	    $soxId = $this->getEditObjectId();

	    if ($soxId != "-1" && isset($soxId)) {


		// load object
		$oArticle->loadInLang($this->_iEditLang, $soxId);
		// load object in other languages
		$oOtherLang = $oArticle->getAvailableInLangs();
		if (!isset($oOtherLang[$this->_iEditLang])) {
		    // echo "language entry doesn't exist! using: ".key($oOtherLang);
		    $oArticle->loadInLang(key($oOtherLang), $soxId);
		}

		foreach ($oOtherLang as $id => $language) {
		    $oLang = new stdClass();

		    $oLang->sLangDesc = $language;
		    $oLang->selected = ($id == $this->_iEditLang);
		    $this->_aViewData["otherlang"][$id] = clone $oLang;
		}


		// variant handling
		if ($oArticle->oxarticles__oxparentid->value) {
		    $oParentArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
		    ;
		    $oParentArticle->load($oArticle->oxarticles__oxparentid->value);
		    $this->_aViewData["parentarticle"] = $oParentArticle;
		    $this->_aViewData["oxparentid"] = $oArticle->oxarticles__oxparentid->value;
		}

		if ($myConfig->getConfigParam('blMallInterchangeArticles')) {
		    $sShopSelect = '1';
		} else {
		    $sShopID = $myConfig->getShopID();
		    $sShopSelect = " oxshopid =  '$sShopID' ";
		}
	    }

	    //	$aData = oxDb::getDb( oxDb::FETCH_MODE_ASSOC )->fetchAll( $sSql );
	    $this->_aViewData['calctypes'] = $this->get_types();
	    $this->_aViewData['staffelungen'] = $this->get_staffeln();
	} catch (Exception $exception) {
	    throw $exception;
	}
	return $this->_sThisTemplate;
    }

    public function getUID() {
	return \OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUID();
    }

    public function add_type() {
	$oDb = $this->getDB();


	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("typeval");

	$uid = $this->getUID();
	$aid = $this->getEditObjectId();
	//$sQ = "INSERT INTO areacalc_typen (areacalctypeid, oxidarticleid, title, title2, hoehe_min, hoehe_max, gewicht ) VALUES (" . $oDb->quote($uid) . ", " . $oDb->quote($aid) . ", " . $oDb->quote($aParams['title']) . " , " . $oDb->quote($aParams['desc']) . ", " . $oDb->quote($aParams['hoehe_min']) . " , " . $oDb->quote($aParams['hoehe_max']) . ", " . $oDb->quote($aParams['gewicht']) . ")";
	//$oDb->execute($sQ);
	//$aData = $oDb->getAll($sQ);
	$oNew = oxNew(\OxidEsales\EshopCommunity\Core\Model\BaseModel::class);
	$oNew->init('areacalc_typen');
	$oNew->areacalc_typen__oxid = new \OxidEsales\Eshop\Core\Field($uid);
	$oNew->areacalc_typen__areacalctypeid = new \OxidEsales\Eshop\Core\Field($uid);
	$oNew->areacalc_typen__oxidarticleid = new \OxidEsales\Eshop\Core\Field($aid);
	$oNew->areacalc_typen__title = new \OxidEsales\Eshop\Core\Field($aParams['title']);
	$oNew->areacalc_typen__title2 = new \OxidEsales\Eshop\Core\Field($aParams['desc']);
	$oNew->areacalc_typen__hoehe_min = new \OxidEsales\Eshop\Core\Field($aParams['hoehe_min']);
	$oNew->areacalc_typen__hoehe_max = new \OxidEsales\Eshop\Core\Field($aParams['hoehe_max']);
	$oNew->areacalc_typen__gewicht = new \OxidEsales\Eshop\Core\Field($aParams['gewicht']);
	$oNew->save();

	$this->add_staffel_type($oNew->getId());
    }

    public function delete_type() {
	
	$delid = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("voxid");
	
	$oDb = $this->getDB();
	$sQ = "DELETE FROM areacalc_typen WHERE CONVERT(`areacalc_typen`.`areacalctypeid` USING utf8) = " . $oDb->quote($delid) . " ";
	$oDb->execute($sQ);

	$sQ = "DELETE FROM areacalc_typen_staffel WHERE CONVERT(`areacalc_typen_staffel`.`areacalctypeid` USING utf8) = " . $oDb->quote($delid) . " ";
	$oDb->execute($sQ);
    }

    public function save_types() {
	$oDb = $this->getDB();
	
	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("typevalsave");

	foreach ($aParams AS $areacalctypeid => $itemvalues) {
	    $sQ = 'UPDATE areacalc_typen '
		    . 'SET title = ' . $oDb->quote($itemvalues['title']) . ', '
		    . 'title2 = ' . $oDb->quote($itemvalues['title2']) . ', '
		    . 'hoehe_min = ' . $oDb->quote($itemvalues['hoehe_min']) . ', '
		    . 'hoehe_max = ' . $oDb->quote($itemvalues['hoehe_max']) . ', '
		    . 'gewicht = ' . $oDb->quote($itemvalues['gewicht']) . ' '
		    . 'WHERE OXID = ' . $oDb->quote($areacalctypeid);
	    $oDb->execute($sQ);
	}
    }

    public function get_types() { 
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();

	$sQ = "SELECT * FROM areacalc_typen WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY title ASC";

	$aData = $oDb->getAll($sQ);
	foreach ($aData as $key => $typeitem) {

	    $aData[$key]['staffeln'] = $this->get_staffeln_types($typeitem['OXID']);
	}
	return $aData;
    }

    public function add_staffel() {
	$oDb = $this->getDB();
	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("staffelval");

	$aid = $this->getEditObjectId();
	$types = $this->get_types();
	$staffelung = $aParams['staffelung'];

	foreach ($types as $typeitem) { 
	    $staffel_uid = $this->getUID();
	    $type_id = $typeitem['OXID'];
	    $sQ = "INSERT INTO areacalc_typen_staffel (staffel, areacalctypeid, areacalcstaffelid, oxidarticleid, OXID) VALUES (" . $oDb->quote($staffelung) . ", " . $oDb->quote($type_id) . ", " . $oDb->quote($staffel_uid) . " , " . $oDb->quote($aid) . ", " . $oDb->quote($staffel_uid) . ")";
	    $oDb->execute($sQ); 
	}
    }

    public function add_staffel_type($type_id) {
		
	$oDb = $this->getDB();
	
	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("staffelval");

	$aid = $this->getEditObjectId();
	$staffeln = $this->get_staffeln();


	foreach ($staffeln as $staffeltem) {
	    $staffel_uid = $uid = $this->getUID();

	    $oNew = oxNew(\OxidEsales\EshopCommunity\Core\Model\BaseModel::class);
	    $oNew->init('areacalc_typen_staffel');
	    $oNew->areacalc_typen_staffel__staffel = new \OxidEsales\Eshop\Core\Field($staffeltem['staffel']);
	    $oNew->areacalc_typen_staffel__areacalctypeid = new \OxidEsales\Eshop\Core\Field($type_id);
	    $oNew->areacalc_typen_staffel__areacalcstaffelid = new \OxidEsales\Eshop\Core\Field($staffel_uid);
	    $oNew->areacalc_typen_staffel__OXID = new \OxidEsales\Eshop\Core\Field($staffel_uid);
	    $oNew->areacalc_typen_staffel__oxidarticleid = new \OxidEsales\Eshop\Core\Field($aid);

	    $oNew->save();
	}
    }

    public function get_staffeln() {
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();
	$sQ = "SELECT DISTINCT staffel FROM areacalc_typen_staffel WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	$aData = $oDb->getAll($sQ);
	return $aData;
    }

    public function get_staffeln_types($typeid) {
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();
	$sQ = "SELECT * FROM areacalc_typen_staffel WHERE areacalctypeid = " . $oDb->quote($typeid) . " and oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	$aData = $oDb->getAll($sQ);
	return $aData;
    }

    public function save_staffeln() {
	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("staffelungen");
	foreach ($aParams as $typeitem => $staffeln) {

	    foreach ($staffeln AS $staffel => $staffelpreis) {
		$oDb = $this->getDB();

		$sQ = 'UPDATE areacalc_typen_staffel '
			. 'SET preis = ' . $oDb->quote($staffelpreis) . ' '
			. 'WHERE staffel = ' . $oDb->quote($staffel) . ''
			. 'AND areacalctypeid = ' . $oDb->quote($typeitem);

		$oDb->execute($sQ);
	    }
	}
    }

    public function delete_staffel() {
	$delstaffel = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("voxid");

	$aid = $this->getEditObjectId();

	$oDb = $this->getDB();
	$sQ = "DELETE FROM areacalc_typen_staffel WHERE staffel = " . $oDb->quote($delstaffel) . " AND CONVERT(`areacalc_typen_staffel`.`oxidarticleid` USING utf8) = " . $oDb->quote($aid) . " ";
	$oDb->execute($sQ);
    }

    public function save() {
	parent::save();

	$soxId = $this->getEditObjectId();
	$aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");

	if (!isset($aParams['oxarticles__oxcalctest'])) {

	    $aParams['oxarticles__oxcalctest'] = '';
	}

	$oArticle = $this->_aViewData['edit'];	
	$myConfig = $this->getConfig();
	
	
	//$sShopID = oxSession::getVar("actshop");
	$sShopID = $myConfig->getShopID();
	
	$aParams['oxarticles__oxshopid'] = $sShopID;

	$oArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
	
	$oArticle->loadInLang($this->_iEditLang, $soxId);

	$oArticle->setLanguage(0);

// checkbox handling
	if (!$oArticle->oxarticles__oxparentid->value && !isset($aParams['oxarticles__oxremindactive'])) {
	    $aParams['oxarticles__oxremindactive'] = 0;
	}

	$oArticle->assign($aParams);

//tells to article to save in different language
	$oArticle->setLanguage($this->_iEditLang);
	$oArticle = oxRegistry::get("oxUtilsFile")->processFiles($oArticle);

	$oArticle->resetRemindStatus();

	$oArticle->updateVariantsRemind();

	$oArticle->save();
    }

    protected function _getEditValue($oObject, $sField) {
	$sEditObjectValue = '';
	if ($oObject) {
	    $oDescField = $oObject->getLongDescription();
	    $sEditObjectValue = $this->_processEditValue($oDescField->getRawValue());
	    $oDescField = new oxField($sEditObjectValue, oxField::T_RAW);
	}
	return $sEditObjectValue;
    }

}
