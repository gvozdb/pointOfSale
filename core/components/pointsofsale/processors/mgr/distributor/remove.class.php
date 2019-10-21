<?php

class pointsOfSaleDistributorRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'pof_distributor';
    public $classKey = 'pof_distributor';
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
            return $this->failure($this->modx->lexicon('pointsofsale_distributor_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var pof_distributor $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('pointsofsale_distributor_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'pointsOfSaleDistributorRemoveProcessor';