<?php

class pointsOfSaleCountryCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pof_country';
    public $classKey = 'pof_country';
    public $languageTopics = ['pointsofsale'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $props = $this->getProperties();

        return parent::beforeSet();
    }

}

return 'pointsOfSaleCountryCreateProcessor';