<?php
/** @var modX $modx */
/** @var pointsOfSale $pos */
/** @var array $scriptProperties */
if (!$pos = $modx->getService('pointsofsale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/')) {
    return;
}

//
$exists_group = false;
$exists_single = false;

//
$className = 'pos' . $modx->event->name;
$modx->loadClass('posPlugin', $pos->config['pluginsPath'], true, true);
$modx->loadClass('posPluginGroup', $pos->config['pluginsPath'], true, true);
if (file_exists($pos->config['pluginsPath'] . strtolower($className) . '.class.php')) {
    $modx->loadClass($className, $pos->config['pluginsPath'], true, true);
}

//
if (class_exists('posPluginGroup')) {
    /** @var posPluginGroup $handlerGroup */
    $handlerGroup = new posPluginGroup($pos, $scriptProperties);
    if ($exists_group = method_exists($handlerGroup, $modx->event->name)) {
        $handlerGroup->{$modx->event->name}();
    }
    unset($handlerGroup);
}

//
if ($exists_single = class_exists($className)) {
    /** @var posPlugin $handlerSingle */
    $handlerSingle = new $className($pos, $scriptProperties);
    $handlerSingle->run();
    unset($handlerSingle);
}

// Удаляем событие у плагина, если такого класса не существует
if ($exists_group === false && $exists_single === false) {
    if ($event = $modx->getObject('modPluginEvent', array(
        'pluginid' => $modx->event->plugin->get('id'),
        'event' => $modx->event->name,
    ))) {
        $event->remove();
    }
}
return;