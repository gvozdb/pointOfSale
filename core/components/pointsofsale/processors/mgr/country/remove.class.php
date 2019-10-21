<?php

class pointsOfSaleCountryRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'pof_country';
    public $classKey = 'pof_country';
    public $languageTopics = ['pointsofsale'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('pointsofsale_country_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var pof_country $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('pointsofsale_country_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'pointsOfSaleCountryRemoveProcessor';