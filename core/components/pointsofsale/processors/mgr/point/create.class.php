<?php

class pointsOfSalePointCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pof_point';
    public $classKey = 'pof_point';
    public $languageTopics = ['pointsofsale'];
    //public $permission = 'create';

}

return 'pointsOfSalePointCreateProcessor';