<?php

class posProductPricesGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pof_country';
    public $classKey = 'pof_country';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $permission = 'list';
    /**
     * @var pointsOfSale $pos
     */
    protected $pos;
    /**
     * @var array $prices
     */
    protected $prices;

    /**
     * @return boolean|string
     */
    public function initialize()
    {
        $this->pos = $this->modx->getService('pointsofsale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/');

        return parent::initialize();
    }

    /**
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        $this->setProperty('sort', str_replace('_formatted', '', $this->getProperty('sort')));

        return parent::beforeQuery();
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        //
        $c->select([
            $this->modx->getSelectColumns('pof_country', 'pof_country', '', [
                'id',
                'country',
                'currency',
                'position',
                'code',
            ]),
        ]);

        //
        if ($query = trim($this->getProperty('query'))) {
            $c->where([
                'country:LIKE' => "%{$query}%",
            ]);
        }

        //
        $c->where([
            'show_in_switcher' => true,
            'active' => true,
        ]);

        return $c;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        //
        $data = $object->toArray();

        //
        $data['product_id'] = (int)$this->getProperty('product_id', null);

        //
        $data['price'] = isset($this->prices[$data['id']])
            ? $this->prices[$data['id']] : null;

        return $data;
    }

    /**
     * @param array $rows
     *
     * @return array
     */
    public function beforeIteration(array $rows)
    {
        $prices = [];
        if ($product_id = (int)$this->getProperty('product_id', null)) {
            if ($product = $this->modx->getObject('msProductData', ['id' => $product_id])) {
                if ($tmp = $product->get('prices')) {
                    if ($this->pos->tools->isJSON($tmp)) {
                        $tmp = $this->modx->fromJSON($tmp);
                    }
                    if (is_array($tmp)) {
                        $prices = $tmp;
                    }
                }
                unset($tmp);
            }
        }
        $this->prices = $prices;

        // $this->modx->log(1, '$prices ' . print_r($prices, 1));

        return $rows;
    }

    /**
     * @param array $rows
     *
     * @return array
     */
    public function afterIteration(array $rows)
    {
        // $this->modx->log(1, '$rows ' . print_r($rows, 1));

        return $rows;
    }
}

return 'posProductPricesGetListProcessor';