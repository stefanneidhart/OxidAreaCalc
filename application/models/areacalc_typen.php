<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Model;

use oxField;

/**
 * Manages product assignment to category.
 */
class areacalc_typen extends \OxidEsales\Eshop\Core\Model\BaseModel
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'areacalc_typen';

    /**
     * Class constructor, initiates parent constructor (parent::oxBase()) and sets table name.
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('areacalc_typen');
    }

}
