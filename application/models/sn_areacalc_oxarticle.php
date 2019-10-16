<?php

class sn_areacalc_oxarticle extends sn_areacalc_oxarticle_parent {

    public function getPrice($dAmount = 1) {
	parent::getPrice($dAmount = 1);
	if (!empty($this->oxarticles__oxcalctest->value)) {
	    $types = $this->get_types();
	    $firsttype = array_shift($types);
	    $oPrice = $this->_getPriceObject();
	    $orgiPrice = $this->_oPrice->getPrice();
	    $oPrice->setPrice($firsttype['staffeln'][0]['preis']);
	    $this->_oPrice = $oPrice;
	}
	return $this->_oPrice;
    }

    public function get_types_json() {

	$aData = $this->get_types();
	return json_encode($aData);
    }

    public function get_type($materialid) {
	$materialien = $this->get_types();
	$curM = null;
	foreach ($materialien AS $key => $material) {
	    if ($material['areacalctypeid'] == $materialid) {
		$curM = $material;
	    }
	}
	return $curM;
    }

    public function get_types() {
	$oDb = oxDb::getDb();
	$aid = $this->getId();

	$sQ = "SELECT * FROM areacalc_typen WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY title ASC";
	$oDb->execute($sQ);
	$aData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getAll($sQ);

	foreach ($aData as $key => $typeitem) {

	    $aData[$key]['staffeln'] = $this->get_staffeln_types($typeitem['areacalctypeid']);
	}
	return $aData;
    }

    public function get_staffeln() {
	$oDb = oxDb::getDb();
	$aid = $this->getId();
	$sQ = "SELECT DISTINCT staffel FROM areacalc_typen_staffel WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	$aData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getAll($sQ);
	return $aData;
    }

    public function getMaterialWeight($materialid) {
	$materialien = $this->get_types();
	$curM = null;
	foreach ($materialien AS $key => $material) {
	    if ($material['areacalctypeid'] == $materialid) {
		$curM = $material;
	    }
	}
	return $curM['gewicht'];
    }

    public function getMaterialName($materialid) {
	$materialien = $this->get_types();
	$curM = null;
	foreach ($materialien AS $key => $material) {
	    if ($material['areacalctypeid'] == $materialid) {
		$curM = $material;
	    }
	}
	return $curM['title'] . " - " . $curM['title2'];
    }

    public function get_staffel($materialid, $hoehe) {

	$materialien = $this->get_types();
	$curM = null;
	foreach ($materialien AS $key => $material) {
	    if ($material['areacalctypeid'] == $materialid) {
		$curM = $material;
	    }
	}

	$staffelung = $curM['staffeln'][0];
	foreach ($curM['staffeln'] as $key => $staffelarr) {
	    if ($hoehe > $staffelarr['staffel']) {
		$staffelung = $curM['staffeln'][$key + 1];
	    }
	}
	return $staffelung;
    }

    public function get_staffeln_types($typeid) {
	$oDb = oxDb::getDb();
	$aid = $this->getId();
	$sQ = "SELECT * FROM areacalc_typen_staffel WHERE areacalctypeid = " . $oDb->quote($typeid) . " and oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
	$aData = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getAll($sQ);
	return $aData;
    }

    public function getOption1() {

	return $this->oxarticles__areacalc_opt1->value;
    }

    public function getOption2() {

	return $this->oxarticles__areacalc_opt2->value;
    }

    public function render() {
	
    }

}
