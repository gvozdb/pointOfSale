<?php

class pointsOfSaleServiceCenterGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pof_service_center';
    public $classKey = 'pof_service_center';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'distributor:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('pointsofsale_service_center_update'),
            //'multiple' => $this->modx->lexicon('pointsofsale_items_update'),
            'action' => 'updateServiceCenter',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pointsofsale_service_center_enable'),
                'multiple' => $this->modx->lexicon('pointsofsale_service_centers_enable'),
                'action' => 'enableServiceCenter',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pointsofsale_service_center_disable'),
                'multiple' => $this->modx->lexicon('pointsofsale_service_centers_disable'),
                'action' => 'disableServiceCenter',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pointsofsale_service_center_remove'),
            'multiple' => $this->modx->lexicon('pointsofsale_service_centers_remove'),
            'action' => 'removeServiceCenter',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'pointsOfSaleServiceCenterGetListProcessor';