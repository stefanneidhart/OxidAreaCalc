<?php

class sn_calcarea_oxbasketitem extends sn_calcarea_oxbasketitem_parent {

    public function getMaterial($materialid) {
	return $this->_oArticle->get_type($materialid);
    }

    public function getMaterialWeight($materialid) {
	return $this->_oArticle->getMaterialWeight($materialid);
    }

    public function setBasketItemId($id) {
	$this->basketItemId = $id;
    }

    public function getBasketItemId() {
	if (isset($this->basketItemId)) {
	    return $this->basketItemId;
	} else {
	    return '0';
	}
    }

    public function getMaterialName($materialid) {
	$materialien = $this->_oArticle->get_types();
	$curM = null;
	foreach ($materialien AS $key => $material) {
	    if ($material['areacalctypeid'] == $materialid) {
		$curM = $material;
	    }
	}
	return $curM['title'] . " - " . $curM['title2'];
    }

    public function calcWeight($amount = 0) {
	$aPersParams = $this->getPersParams();
	if ($aPersParams['areacalc_active'] == 1) {
	    $m2weight = $this->getMaterialWeight($aPersParams['MaterialTypesSelect']);
	    $newWeight = ((( $aPersParams['hoehe'] * $aPersParams['breite'] ) * $m2weight ) / 1000) * $amount;
	    $oArticle = $this->getArticle(true);
	    $this->_dWeight = $newWeight ;
	    $oArticle->oxarticles__oxweight->value = $newWeight;
	}
    }

    public function calcAPrice($params = null) {

	if ($params) {
	    $aPersParams = $params;
	} else {
	    $aPersParams = $this->getPersParams();
	}

	if (isset($aPersParams['areacalc_active']) && $aPersParams['areacalc_active'] == 1) {

	    $this->areacalc_active_flag = true;

	    $breite = $aPersParams['breite'];
	    $hoehe = $aPersParams['hoehe'];
	    $staffelung = $this->_oArticle->get_staffel($aPersParams['MaterialTypesSelect'], $hoehe);
	    $this->preisStaffel = $staffelung;
	    $baseprice_staffel = doubleval($staffelung['preis']);
	    if (isset($aPersParams['areacalc_opt1']) && !empty($aPersParams['areacalc_opt1'])) {
		$baseprice_staffel = $baseprice_staffel + $this->_oArticle->getOption1();
	    }
	    $newPrice = ($breite * $hoehe) * $baseprice_staffel;

	    if (isset($aPersParams['areacalc_opt2']) && !empty($aPersParams['areacalc_opt2'])) {
		$newPrice = $newPrice + ($this->_oArticle->getOption2() * $breite);
	    }
	    return $newPrice;
	} else {
	    return $this->_oPrice;
	}
    }

    public function setPrice($oPrice, $params = null) {

	$aPersParams = $this->getPersParams();

	if ($params !== null || $aPersParams['areacalc_active'] == '1') {
	    $newPrice = $this->calcAPrice($params);

	    $this->_dNetto = $newPrice;
	    $this->_dBrutto = $newPrice;
	    $oPrice->setPrice($newPrice);

	    $this->_oUnitPrice = clone $oPrice;
	    if ($aPersParams['areacalc_active'] == '1') {
		$this->_oRegularUnitPrice = clone $oPrice;
	    }

	    $this->_oPrice = clone $oPrice;
	    $this->_oPrice->multiply($this->getAmount());
	} else {
	    $this->_oUnitPrice = clone $oPrice;
	    $this->_oPrice = clone $oPrice;
	    $this->_oPrice->multiply($this->getAmount());
	}
    }

    public function getRegularUnitPrice() {
	$aPersParams = $this->getPersParams();
	if ($aPersParam['areacalc_active'] == '1') {
	    return $this->_oPrice;
	} else {
	    return $this->_oRegularUnitPrice;
	}
    }

}
