<?php
/** @var xPDOTransport $transport */
/** @var array $options */
if ($transport->xpdo) {
    /** @var modX $modx */
    $modx = &$transport->xpdo;
    /** @var miniShop2 $ms2 */
    if (!$ms2 = $modx->getService('miniShop2')) {
        $modx->log(modX::LOG_LEVEL_ERROR, '[pointsOfSale] Could not load miniShop2');

        return false;
    }
    if (!property_exists($ms2, 'version') || version_compare($ms2->version, '2.4.0-beta2', '<')) {
        $modx->log(modX::LOG_LEVEL_ERROR, '[pointsOfSale] You need to upgrade miniShop2 at least to version 2.4.2-beta2');

        return false;
    }

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $ms2->removePlugin('pointsOfSale');
            $ms2->addPlugin('pointsOfSale', 'core/components/pointsofsale/ms2plugin/index.php');
            // $ms2->loadMap();
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            $ms2->removePlugin('pointsOfSale');
            break;
    }
}
return true;