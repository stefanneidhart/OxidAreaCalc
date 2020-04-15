<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace sn\snareacalc\Component;

class BasketComponent extends BasketComponent_parent
{


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
