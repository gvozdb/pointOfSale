<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var pointsOfSale $pointsOfSale */
$pointsOfSale = $modx->getService('pointsOfSale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/');
$modx->lexicon->load('pointsofsale:default');

// handle request
$corePath = $modx->getOption('pointsofsale_core_path', null, $modx->getOption('core_path') . 'components/pointsofsale/');
$path = $modx->getOption('processorsPath', $pointsOfSale->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);