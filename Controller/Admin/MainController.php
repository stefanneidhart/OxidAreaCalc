<?php

/**
 * @TODO LICENCE
 */

namespace sn\oxid6AreacalcModule\Controller\Admin;

use stdClass;
use oxDb;

/**
 * Class LinslinSliderMain.
 */
class MainController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController {

    protected $_oArticle = null;
    protected $_sThisTemplate = 'article_calcsn.tpl';

    public function __construct() {
	
    }

    public function getDB($blAssoc = true) {
	return \OxidEsales\Eshop\Core\DatabaseProvider::getDb($blAssoc);
    }

    /*

      public function render() {

      try {
      $oDb = $this->getDB();

      var_dump($oDb->getAll('SELECT * FROM areacalc_typen WHERE oxidarticleid'));


      } catch (Exception $exception) {
      throw $exception;
      }
      return "article_calcsn.tpl";
      }
     */
    /* 	 */

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
	return "article_calcsn.tpl";
    }

    public function add_type() {
	$oDb = $this->getDB();
	$aParams = oxConfig::getParameter("typeval");
	$uid = oxUtilsObject::getInstance()->generateUID();
	$aid = $this->getEditObjectId();
	//$sQ = "INSERT INTO areacalc_typen (areacalctypeid, oxidarticleid, title, title2, hoehe_min, hoehe_max, gewicht ) VALUES (" . $oDb->quote($uid) . ", " . $oDb->quote($aid) . ", " . $oDb->quote($aParams['title']) . " , " . $oDb->quote($aParams['desc']) . ", " . $oDb->quote($aParams['hoehe_min']) . " , " . $oDb->quote($aParams['hoehe_max']) . ", " . $oDb->quote($aParams['gewicht']) . ")";
	//$oDb->execute($sQ);
	
	
		//$aData = $oDb->getAll($sQ);
	$oNew = oxNew(\OxidEsales\EshopCommunity\Core\Model\BaseModel::class);
	$oNew->init('areacalc_typen');
	$oNew->areacalc_typen__oxid = new \OxidEsales\Eshop\Core\Field($uid);
	$oNew->areacalc_typen__areacalctypeid = new \OxidEsales\Eshop\Core\Field($uid);
	$oNew->areacalc_typen__oxidarticleid = new \OxidEsales\Eshop\Core\Field($oDb->quote($aid));
	$oNew->areacalc_typen__title = new \OxidEsales\Eshop\Core\Field($oDb->quote($aParams['title']));
	$oNew->areacalc_typen__title2 = new \OxidEsales\Eshop\Core\Field($oDb->quote($aParams['desc']));
	$oNew->areacalc_typen__hoehe_min = new \OxidEsales\Eshop\Core\Field($oDb->quote($aParams['hoehe_min']));
	$oNew->areacalc_typen__hoehe_max = new \OxidEsales\Eshop\Core\Field($oDb->quote($aParams['hoehe_max']));
	$oNew->areacalc_typen__gewicht = new \OxidEsales\Eshop\Core\Field($oDb->quote($aParams['gewicht']));
	$oNew->save();

	//$this->add_staffel_type($uid);
    }

    public function delete_type() {
	$delid = oxConfig::getParameter("voxid");
	$oDb = $this->getDB();
	$sQ = "DELETE FROM areacalc_typen WHERE CONVERT(`areacalc_typen`.`areacalctypeid` USING utf8) = " . $oDb->quote($delid) . " ";
	$oDb->execute($sQ);

	$sQ = "DELETE FROM areacalc_typen_staffel WHERE CONVERT(`areacalc_typen_staffel`.`areacalctypeid` USING utf8) = " . $oDb->quote($delid) . " ";
	$oDb->execute($sQ);
    }

    public function save_types() {
	$oDb = $this->getDB();
	$aParams = oxConfig::getParameter("typevalsave");

	foreach ($aParams AS $areacalctypeid => $itemvalues) {

	    $sQ = 'UPDATE areacalc_typen '
		    . 'SET title = ' . $oDb->quote($itemvalues['title']) . ', '
		    . 'title2 = ' . $oDb->quote($itemvalues['title2']) . ', '
		    . 'hoehe_min = ' . $oDb->quote($itemvalues['hoehe_min']) . ', '
		    . 'hoehe_max = ' . $oDb->quote($itemvalues['hoehe_max']) . ', '
		    . 'gewicht = ' . $oDb->quote($itemvalues['gewicht']) . ' '
		    . 'WHERE CONVERT(`areacalc_typen`.`areacalctypeid` USING utf8) = ' . $oDb->quote($areacalctypeid);
	    $oDb->execute($sQ);
	}
    }

    public function get_types() {
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();

	$sQ = "SELECT * FROM areacalc_typen WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY title ASC";
	//$oDb->execute($sQ);
	//$aData = $oDb->fetchAll($sQ);

	$aData = $oDb->getAll($sQ);



	foreach ($aData as $key => $typeitem) {

	    $aData[$key]['staffeln'] = $this->get_staffeln_types($typeitem['areacalctypeid']);
	}
	return $aData;
    }

    public function add_staffel() {
	$oDb = $this->getDB();
	$aParams = oxConfig::getParameter("staffelval");

	$aid = $this->getEditObjectId();
	$types = $this->get_types();
	$staffelung = $aParams['staffelung'];

	foreach ($types as $typeitem) {
	    $staffel_uid = oxUtilsObject::getInstance()->generateUID();
	    $type_id = $typeitem['areacalctypeid'];
	    $sQ = "INSERT INTO areacalc_typen_staffel (staffel, areacalctypeid, areacalcstaffelid, oxidarticleid) VALUES (" . $oDb->quote($staffelung) . ", " . $oDb->quote($type_id) . ", " . $oDb->quote($staffel_uid) . " , " . $oDb->quote($aid) . ")";
	    $oDb->execute($sQ);
	}
    }

    public function add_staffel_type($type_id) {
	$oDb = $this->getDB();
	$aParams = oxConfig::getParameter("staffelval");

	$aid = $this->getEditObjectId();
	$staffeln = $this->get_staffeln();


	foreach ($staffeln as $staffeltem) {
	    $staffel_uid = oxUtilsObject::getInstance()->generateUID();
	    $sQ = "INSERT INTO areacalc_typen_staffel (staffel, areacalctypeid, areacalcstaffelid, oxidarticleid) VALUES (" . $oDb->quote($staffeltem['staffel']) . ", " . $oDb->quote($type_id) . ", " . $oDb->quote($staffel_uid) . " , " . $oDb->quote($aid) . ")";
	    $oDb->execute($sQ);
	}
    }

    public function get_staffeln() {
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();
	$sQ = "SELECT DISTINCT staffel FROM areacalc_typen_staffel WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	//$aData = $oDb->fetchAll($sQ);

	
	$aData = $oDb->getAll($sQ);


	return $aData;
    }

    public function get_staffeln_types($typeid) {
	$oDb = $this->getDB();
	$aid = $this->getEditObjectId();
	$sQ = "SELECT * FROM areacalc_typen_staffel WHERE areacalctypeid = " . $oDb->quote($typeid) . " and oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	//$aData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->fetchAll($sQ);
	$aData = $oDb->fetchAll($sQ);
	return $aData;
    }

    public function save_staffeln() {
	$aParams = oxConfig::getParameter("staffelungen");
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
	$delstaffel = oxConfig::getParameter("voxid");
	$aid = $this->getEditObjectId();

	$oDb = $this->getDB();
	$sQ = "DELETE FROM areacalc_typen_staffel WHERE staffel = " . $oDb->quote($delstaffel) . " AND CONVERT(`areacalc_typen_staffel`.`oxidarticleid` USING utf8) = " . $oDb->quote($aid) . " ";
	$oDb->execute($sQ);
    }

    public function save() {
	parent::save();

	$soxId = $this->getEditObjectId();
	$aParams = oxConfig::getParameter("editval");

	if (!isset($aParams['oxarticles__oxcalctest'])) {

	    $aParams['oxarticles__oxcalctest'] = '';
	}


	$oArticle = $this->_aViewData['edit'];

// shopid
	$sShopID = oxSession::getVar("actshop");
	$aParams['oxarticles__oxshopid'] = $sShopID;

	$oArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
	;
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
