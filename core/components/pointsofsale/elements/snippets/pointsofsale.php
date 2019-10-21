<?php
$modx->addPackage('pointsofsale', MODX_CORE_PATH . 'components/pointsofsale/model/');
$countries = $modx->getIterator('pof_country',
    array(
        'active' => 1,
        'show_in_switcher' => 1,
        'code:!=' => ''
    ));
$output = [];
if($countries){
    foreach($countries as $country){
        $output[$country->id] = $country->toArray();

    }
}

return $output;