<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace sn\snareacalc\Component;

class BasketItem extends BasketComponent_parent
{


    /**
     * Basket content update controller.
     * Before adding article - check if client is not a search engine. If
     * yes - exits method by returning false. If no - executes
     * oxcmp_basket::_addItems() and puts article to basket.
     * Returns position where to redirect user browser.
     *
     * @param string $sProductId Product ID (default null)
     * @param double $dAmount    Product amount (default null)
     * @param array  $aSel       (default null)
     * @param array  $aPersParam (default null)
     * @param bool   $blOverride If true amount in basket is replaced by $dAmount otherwise amount is increased by $dAmount (default false)
     *
     * @return mixed
     */
    public function toBasket($sProductId = null, $dAmount = null, $aSel = null, $aPersParam = null, $blOverride = false)
    {
        // adding to basket is not allowed ?
        $myConfig = $this->getConfig();
        if (\OxidEsales\Eshop\Core\Registry::getUtils()->isSearchEngine()) {
            return;
        }

        // adding articles
        if ($aProducts = $this->_getItems($sProductId, $dAmount, $aSel, $aPersParam, $blOverride)) {
            $this->_setLastCallFnc('tobasket');

            $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
            $database->startTransaction();
            try {
                $oBasketItem = $this->_addItems($aProducts);
                //reserve active basket
                if (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('blPsBasketReservationEnabled')) {
                    $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
                    \OxidEsales\Eshop\Core\Registry::getSession()->getBasketReservations()->reserveBasket($basket);
                }
            } catch (\Exception $exception) {
                $database->rollbackTransaction();
                unset($oBasketItem);
                throw $exception;
            }
            $database->commitTransaction();

            // new basket item marker
            if ($oBasketItem && $myConfig->getConfigParam('iNewBasketItemMessage') != 0) {
                $oNewItem = new stdClass();
                $oNewItem->sTitle = $oBasketItem->getTitle();
                $oNewItem->sId = $oBasketItem->getProductId();
                $oNewItem->dAmount = $oBasketItem->getAmount();
                $oNewItem->dBundledAmount = $oBasketItem->getdBundledAmount();

                // passing article
                \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('_newitem', $oNewItem);
            }

            // redirect to basket
            return $this->_getRedirectUrl();
        }
    }

    /**
     * Similar to tobasket, except that as product id "bindex" parameter is (can be) taken
     *
     * @param string $sProductId Product ID (default null)
     * @param double $dAmount    Product amount (default null)
     * @param array  $aSel       (default null)
     * @param array  $aPersParam (default null)
     * @param bool   $blOverride If true means increase amount of chosen article (default false)
     *
     * @return mixed
     */
  

    /**
     * Cleans and returns persisted parameters.
     *
     * @param array $persistedParameters key-value parameters (optional). If not passed - takes parameters from request.
     *
     * @return array|null cleaned up parameters or null, if there are no non-empty parameters
     */
    protected function getPersistedParameters($persistedParameters = null)
    {
        $persistedParameters = ($persistedParameters ?: \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('persparam'));
        if (!is_array($persistedParameters)) {
            return null;
        }
        return array_filter($persistedParameters) ?: null;
    }


    /**
     * Adds all articles user wants to add to basket. Returns
     * last added to basket item.
     *
     * @param array $products products to add array
     *
     * @return  object  $oBasketItem    last added basket item
     */
    protected function _addItems($products)
    {
        $activeView = $this->getConfig()->getActiveView();
        $errorDestination = $activeView->getErrorDestination();

        $basket = $this->getSession()->getBasket();
        $basketInfo = $basket->getBasketSummary();

        $basketItemAmounts = [];

        foreach ($products as $addProductId => $productInfo) {
            $data = $this->prepareProductInformation($addProductId, $productInfo);
            $productAmount = 0;
            if (isset($basketInfo->aArticles[$data['id']])) {
                $productAmount = $basketInfo->aArticles[$data['id']];
            }
            $products[$addProductId]['oldam'] = $productAmount;

            //If we already changed articles so they now exactly match existing ones,
            //we need to make sure we get the amounts correct
            if (isset($basketItemAmounts[$data['oldBasketItemId']])) {
                $data['amount'] = $data['amount'] + $basketItemAmounts[$data['oldBasketItemId']];
            }

            $basketItem = $this->addItemToBasket($basket, $data, $errorDestination);

            if (($basketItem instanceof \OxidEsales\Eshop\Application\Model\BasketItem)) {
                $basketItemKey = $basketItem->getBasketItemKey();
                if ($basketItemKey) {
                    if (! isset($basketItemAmounts[$basketItemKey])) {
                        $basketItemAmounts[$basketItemKey] = 0;
                    }
                    $basketItemAmounts[$basketItemKey] += $data['amount'];
                }
            }

            if (!$basketItem) {
                $info = $basket->getBasketSummary();
                $productAmount = $info->aArticles[$data['id']];
                $products[$addProductId]['am'] = isset($productAmount) ? $productAmount : 0;
            }
        }

        //if basket empty remove possible gift card
        if ($basket->getProductsCount() == 0) {
            $basket->setCardId(null);
        }

        // information that last call was tobasket
        $this->_setLastCall($this->_getLastCallFnc(), $products, $basketInfo);

        return $basketItem;
    }


    /**
     * Add one item to basket. Handle eventual errors.
     *
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @param array                                      $itemData
     * @param string                                     $errorDestination
     *
     * @return null|oxBasketItem
     */
    protected function addItemToBasket($basket, $itemData, $errorDestination)
    {
        $basketItem = null;

        try {
            $basketItem = $basket->addToBasket(
                $itemData['id'],
                $itemData['amount'],
                $itemData['selectList'],
                $itemData['persistentParameters'],
                $itemData['override'],
                $itemData['bundle'],
                $itemData['oldBasketItemId']
            );
        } catch (\OxidEsales\Eshop\Core\Exception\OutOfStockException $exception) {
            $exception->setDestination($errorDestination);
            // #950 Change error destination to basket popup
            if (!$errorDestination && $this->getConfig()->getConfigParam('iNewBasketItemMessage') == 2) {
                $errorDestination = 'popup';
            }
            \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($exception, false, (bool) $errorDestination, $errorDestination);
        } catch (\OxidEsales\Eshop\Core\Exception\ArticleInputException $exception) {
            //add to display at specific position
            $exception->setDestination($errorDestination);
            \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($exception, false, (bool) $errorDestination, $errorDestination);
        } catch (\OxidEsales\Eshop\Core\Exception\NoArticleException $exception) {
            //ignored, best solution F ?
        }

        return $basketItem;
    }
}
