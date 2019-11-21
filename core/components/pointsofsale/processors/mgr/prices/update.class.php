<?php

class posProductPricesUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'msProductData';
    public $classKey = 'msProductData';
    public $primaryKeyField = 'id';
    public $languageTopics = array('pointsofsale:default');
    public $permission = 'save';
    /**
     * @var pointsOfSale $pos
     */
    protected $pos;

    /**
     * @return bool
     */
    public function initialize()
    {
        //
        $this->pos = $this->modx->getService('pointsofsale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/');

        // Prepare data for updating from grid
        $data = $this->modx->fromJSON($this->getProperty('data'));
        if (is_array($data)) {
            $data['country_id'] = (int)$data['id'];
            $data['id'] = (int)$data['product_id'];
            $data['price'] = (float)$data['price'];
            foreach ([
                'product_id',
                'country',
                'actions',
                'menu',
            ] as $v) {
                unset($data[$v]);
            }
        }
        if (empty($data)) {
            return $this->modx->lexicon('invalid_data');
        }
        $this->setProperties($data);
        $this->unsetProperty('data');

        // $this->modx->log(1, '$data ' . print_r($data, 1));

        return parent::initialize();
    }

    /**
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::beforeSave();
    }

    /**
     * @return bool
     */
    public function beforeSet()
    {
        if (!$id = (int)$this->getProperty('id')) {
            return $this->modx->lexicon('pos_err_ns');
        }

        // Check on required
        $required = [
            'country_id',
            'price',
        ];
        $this->pos->tools->checkProcessorRequired($this, $required, 'pos_err_required');

        // Prepare properties
        if (($tmp = $this->prepareProperties()) !== true) {
            return $tmp;
        }
        unset($tmp);

        return parent::beforeSet();
    }

    /**
     * @return string|bool
     */
    public function prepareProperties()
    {
        $data = $this->getProperties();

        //
        $data['prices'] = $this->object->get('prices') ?: [];
        if ($this->pos->tools->isJSON($data['prices'])) {
            $data['prices'] = $this->modx->fromJSON($data['prices']);
        }
        $data['prices'] = is_array($data['prices']) ? $data['prices'] : [];
        $data['prices'][$data['country_id']] = $data['price'];
        foreach (['country_id', 'price'] as $k) {
            $this->unsetProperty($k);
            unset($data[$k]);
        }
        $data['prices'] = $this->modx->toJSON($data['prices']);

        //
        $this->setProperties($data);

        return true;
    }
}

return 'posProductPricesUpdateProcessor';