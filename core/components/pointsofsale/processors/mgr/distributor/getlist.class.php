<?php

class pointsOfSaleDistributorGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pof_distributor';
    public $classKey = 'pof_distributor';
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
            'title' => $this->modx->lexicon('pointsofsale_distributor_update'),
            //'multiple' => $this->modx->lexicon('pointsofsale_items_update'),
            'action' => 'updateDistributor',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('pointsofsale_distributor_enable'),
                'multiple' => $this->modx->lexicon('pointsofsale_distributors_enable'),
                'action' => 'enableDistributor',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('pointsofsale_distributor_disable'),
                'multiple' => $this->modx->lexicon('pointsofsale_distributors_disable'),
                'action' => 'disableDistributor',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('pointsofsale_distributor_remove'),
            'multiple' => $this->modx->lexicon('pointsofsale_distributors_remove'),
            'action' => 'removeDistributor',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'pointsOfSaleDistributorGetListProcessor';