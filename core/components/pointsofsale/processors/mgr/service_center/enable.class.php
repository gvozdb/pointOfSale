<?php

class pointsOfSaleServiceCenterEnableProcessor extends modObjectProcessor
{
    public $objectType = 'pof_service_center';
    public $classKey = 'pof_service_center';
    public $languageTopics = ['pointsofsale'];
    //public $permission = 'save';


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
            return $this->failure($this->modx->lexicon('pointsofsale_service_center_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var pof_service_center $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('pointsofsale_service_center_err_nf'));
            }

            $object->set('active', true);
            $object->save();
        }

        return $this->success();
    }

}

return 'pointsOfSaleServiceCenterEnableProcessor';
