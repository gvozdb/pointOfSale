<?php

class pointsOfSaleCountryUploadProcessor extends modObjectProcessor
{
    public $objectType = 'pof_country';
    public $classKey = 'pof_country';
    public $languageTopics = ['pointsofsale'];
    private $countries;

    //public $permission = 'save';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize()
    {
        $this->countries = $this->getProperty('countries');
        return true;
    }

    public function process()
    {

        $pointsOfSale = $this->modx->getService('pointsOfSale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/', array());
        if (!$pointsOfSale) {
            return $this->failure('Could not load pointsOfSale class!');
        }

        foreach ($this->countries as $item) {

            $q = $this->modx->newObject($this->classKey);
            $q->fromArray(array('country' => $item));
            $q->save();
            $this->modx->logManagerAction($this->objectType . '_upload', $this->classKey, $q->get($this->primaryKeyField));

        }

        $msg  = $this->modx->lexicon('pointsofsale_country_countries_uploaded');
        return $this->modx->error->success($msg, $q);
    }


}

return 'pointsOfSaleCountryUploadProcessor';
