<?php

class pointsOfSaleDealerUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pof_dealer';
    public $classKey = 'pof_dealer';
    public $languageTopics = ['pointsofsale'];
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        return parent::beforeSet();
    }
}

return 'pointsOfSaleDealerUpdateProcessor';
