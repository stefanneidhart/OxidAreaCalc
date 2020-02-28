<?php

namespace sn\oxid6AreacalcModule\Model;

class OrderArticle extends OrderArticle_parent {
	
	public function getDB() {
		return \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
	}

	public function getPrice($dAmount = 1) {
		parent::getPrice($dAmount = 1);
		if (!empty($this->oxarticles__oxcalctest->value)) {

			$types = $this->get_sntypes();
			$firsttype = array_shift($types);


			$oPrice = $this->_getPriceObject();
			$orgiPrice = $this->_oPrice->getPrice();
			$oPrice->setPrice($firsttype['staffeln'][0]['preis']);
			$this->_oPrice = $oPrice;
		}
		return $this->_oPrice;
	}

	public function get_types_json() {

		$aData = $this->get_sntypes();
		return json_encode($aData);
	}

	public function get_sntype($materialid) {
		$materialien = $this->get_sntypes();
		$curM = null;
		foreach ($materialien AS $key => $material) {
			if ($material['OXID'] == $materialid) {
				$curM = $material;
			}
		}
		return $curM;
	}

	public function getMaterialWeight($materialid) {
		$materialien = $this->get_sntypes();
		$curM = null;
		foreach ($materialien AS $key => $material) {
			if ($material['OXID'] == $materialid) {
				$curM = $material;
			}
		}

		return $curM['gewicht'];
	}

	public function getMaterialName($materialid) {
		$materialien = $this->get_sntypes();
		$curM = null;
		foreach ($materialien AS $key => $material) {
			if ($material['OXID'] == $materialid) {
				$curM = $material;
			}
		}
		return $curM['title'] . " - " . $curM['title2'];
	}

	public function get_sntypes() {
		$oDb = $this->getDB();
		$aid = $this->getProductId();

		$sQ = "SELECT * FROM areacalc_typen WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY title ASC";
		$oDb->execute($sQ);
		$aData = $oDb->getAll($sQ);

		foreach ($aData as $key => $typeitem) {

			$aData[$key]['staffeln'] = $this->get_staffeln_types($typeitem['OXID']);
		}
		//var_dump($aData);
		return $aData;
	}

	public function get_staffeln() {
		$oDb = $this->getDB();
		$aid = $this->getProductId();
		$sQ = "SELECT DISTINCT staffel FROM areacalc_typen_staffel WHERE oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
		$aData = $oDb->getAll($sQ);
		return $aData;
	}

	public function get_staffel($materialid, $hoehe) {

		$materialien = $this->get_sntypes();
		$curM = null;
		foreach ($materialien AS $key => $material) {
			if ($material['OXID'] == $materialid) {
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
		$oDb = $this->getDB();
		$aid = $this->getProductId();
		$sQ = "SELECT * FROM areacalc_typen_staffel WHERE areacalctypeid = " . $oDb->quote($typeid) . " and oxidarticleid = " . $oDb->quote($aid) . " ORDER BY staffel ASC";
		$aData = $oDb->getAll($sQ);
		return $aData;
	}

	public function getOption1() {
		return $this->oxarticles__areacalc_opt1->value;
	}

	public function getOption2() {
		return $this->oxarticles__areacalc_opt2->value;
	}
	public function getOption3() {
		return $this->oxarticles__areacalc_opt3->value;
	}
}
