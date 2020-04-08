<?php

namespace sn\snareacalc\Model;

class Basket extends Basket_parent {

	public function addToBasket($sProductID, $dAmount, $aSel = null, $aPersParam = null, $blOverride = false, $blBundle = false, $sOldBasketItemId = null) {
		// enabled ?
		if (!$this->isEnabled())
			return null;

		// basket exclude
		if ($this->getConfig()->getConfigParam('blBasketExcludeEnabled')) {
			if (!$this->canAddProductToBasket($sProductID)) {
				$this->setCatChangeWarningState(true);
				return null;
			}
			else {
				$this->setCatChangeWarningState(false);
			}
		}

		$session = \OxidEsales\Eshop\Core\Registry::getSession();

		if ($sOldBasketItemId != null) {
			//  $bitemsdata = oxSession::getVar($sOldBasketItemId);
			$bitemsdata = $session->getVariable($sOldBasketItemId);

			if ($bitemsdata != null) {
				$aPersParam = $bitemsdata;
			}
		}



		//$areacalc_active = \OxidEsales\Eshop\Core\Config::getParameter('areacalc_active');


		$areacalc_active = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("areacalc_active");

		//$areacalc_active = oxConfig::getParameter('areacalc_active');
		$calcnewflag = false;
		if (!empty($areacalc_active) && $areacalc_active == '1') {
			$aPersParam['areacalc_active'] = '1';
			$aPersParam['breite'] = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("breite");
			$aPersParam['hoehe'] = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("hoehe");
			$aPersParam['MaterialTypesSelect'] = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("MaterialTypesSelect");
			$aPersParam['areacalc_opt1'] = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("areacalc_opt1");
			$aPersParam['areacalc_opt2'] = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("areacalc_opt2");
			$calcnewflag = true;
		}

		$sItemId = $this->getItemKey($sProductID, $aSel, $aPersParam, $blBundle);
		if (!empty($areacalc_active) && $areacalc_active == '1') {
			//   $sItemId = $sItemId . '++' . $aPersParam['breite'] . $aPersParam['hoehe'];
		}

		if (!empty($areacalc_active) && $areacalc_active == '1') {
			// oxSession::setVar($sItemId, $aPersParam);
			$session->setVariable($sItemId, $aPersParam);
		}


		if ($sOldBasketItemId && ( strcmp($sOldBasketItemId, $sItemId) != 0 )) {



			if (isset($this->_aBasketContents[$sItemId])) {
				// we are merging, so params will just go to the new key
				unset($this->_aBasketContents[$sOldBasketItemId]);
				// do not override stock
				$blOverride = false;
			}
			else {
				// value is null - means isset will fail and real values will be filled
				$this->_changeBasketItemKey($sOldBasketItemId, $sItemId);
			}
		}

		// after some checks item must be removed from basket
		$blRemoveItem = false;

		// initialling exception storage
		$oEx = null;

		if (isset($this->_aBasketContents[$sItemId])) {

			//updating existing
			try {
				// setting stock check status
				$this->_aBasketContents[$sItemId]->setStockCheckStatus($this->getStockCheckMode());
				//validate amount
				//possibly throws exception
				$this->_aBasketContents[$sItemId]->setAmount($dAmount, $blOverride, $sItemId);
				$this->_aBasketContents[$sItemId]->calcWeight($dAmount);
			} catch (oxOutOfStockException $oEx) {
				// rethrow later
			}
		}
		else {
			//inserting new
			$oBasketItem = oxNew('oxbasketitem');
			try {
				$oBasketItem->setStockCheckStatus($this->getStockCheckMode());
				$oBasketItem->init($sProductID, $dAmount, $aSel, $aPersParam, $blBundle);
				if ($calcnewflag) {
					$oBasketItem->setBasketItemId($sItemId);
					$oBasketItem->calcAPrice();
					$oBasketItem->calcWeight($dAmount);
				}
			} catch (oxNoArticleException $oEx) {
				// in this case that the article does not exist remove the item from the basket by setting its amount to 0
				//$oBasketItem->dAmount = 0;
				$blRemoveItem = true;
			} catch (oxOutOfStockException $oEx) {
				// rethrow later
			} catch (oxArticleInputException $oEx) {
				// rethrow later
				$blRemoveItem = true;
			}

			$this->_aBasketContents[$sItemId] = $oBasketItem;
		}

		//in case amount is 0 removing item
		if ($this->_aBasketContents[$sItemId]->getAmount() == 0 || $blRemoveItem) {
			$this->removeItem($sItemId);
		}
		elseif ($blBundle) {
			//marking bundles
			$this->_aBasketContents[$sItemId]->setBundle(true);
		}

		//calling update method
		$this->onUpdate();

		if ($oEx) {
			throw $oEx;
		}

		// notifying that new basket item was added
		if (!$blBundle) {
			$this->_addedNewItem($sProductID, $dAmount, $aSel, $aPersParam, $blOverride, $blBundle, $sOldBasketItemId);
		}



		// returning basket item object
		return $this->_aBasketContents[$sItemId];
	}

	protected function _changeBasketItemKey($sOldKey, $sNewKey, $value = null) {
		reset($this->_aBasketContents);
		$iOldKeyPlace = 0;
		while (key($this->_aBasketContents) != $sOldKey && next($this->_aBasketContents)) {
			++$iOldKeyPlace;
		}
		$aNewCopy = array_merge(
				array_slice($this->_aBasketContents, 0, $iOldKeyPlace, true), array($sNewKey => $value), array_slice($this->_aBasketContents, $iOldKeyPlace + 1, count($this->_aBasketContents) - $iOldKeyPlace, true)
		);
		$this->_aBasketContents = $aNewCopy;

		$bitemsdata = oxSession::getVar($sOldKey);
		if ($bitemsdata != null) {
			oxSession::setVar($sNewKey, $bitemsdata);
		}
	}

}