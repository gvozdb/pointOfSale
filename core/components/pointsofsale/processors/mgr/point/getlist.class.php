<?php

class pointsOfSalePointGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pof_point';
    public $classKey = 'pof_point';
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
                'retailer:LIKE' => "%{$query}%",
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
            'title' => $this->modx->lexicon('pointsofsale_point_update'),
            //'multiple' => $this->modx->lexicon('pointsofsale_items_update'),
            'action' => 'updatePoint',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pointsofsale_point_enable'),
                'multiple' => $this->modx->lexicon('pointsofsale_points_enable'),
                'action' => 'enablePoint',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pointsofsale_point_disable'),
                'multiple' => $this->modx->lexicon('pointsofsale_points_disable'),
                'action' => 'disablePoint',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pointsofsale_point_remove'),
            'multiple' => $this->modx->lexicon('pointsofsale_points_remove'),
            'action' => 'removePoint',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'pointsOfSalePointGetListProcessor';