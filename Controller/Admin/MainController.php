<?php
/**
 * @TODO LICENCE
 */
namespace sn\oxid6AreacalcModule\Controller\Admin;

/**
 * Class LinslinSliderMain.
 */
class MainController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    /**
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        return "main.tpl";
    }
}
