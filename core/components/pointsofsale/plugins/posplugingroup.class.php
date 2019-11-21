<?php

/**
 *
 */
class posPluginGroup extends posPlugin
{
    /**
     * @param pointsOfSale $pos
     * @param array        $sp
     */
    public function __construct(pointsOfSale &$pos, array &$sp)
    {
        parent::__construct($pos, $sp);
    }

    /**
     *
     */
    public function OnDocFormRender()
    {
        /** @var modManagerController $controller */
        $controller = &$this->modx->controller;

        $this->pos->loadManagerResourceScripts($controller);
    }
}