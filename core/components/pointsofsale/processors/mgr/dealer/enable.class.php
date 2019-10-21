<?php

class pointsOfSaleDealerEnableProcessor extends modObjectProcessor
{
    public $objectType = 'pof_dealer';
    public $classKey = 'pof_dealer';
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
            return $this->failure($this->modx->lexicon('pointsofsale_dealer_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var pof_dealer $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('pointsofsale_dealer_err_nf'));
            }

            $object->set('active', true);
            $object->save();
        }

        return $this->success();
    }

}

return 'pointsOfSaleDealerEnableProcessor';
