<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/pointsOfSale/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/pointsofsale')) {
            $cache->deleteTree(
                $dev . 'assets/components/pointsofsale/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/pointsofsale/', $dev . 'assets/components/pointsofsale');
        }
        if (!is_link($dev . 'core/components/pointsofsale')) {
            $cache->deleteTree(
                $dev . 'core/components/pointsofsale/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/pointsofsale/', $dev . 'core/components/pointsofsale');
        }
    }
}

return true;