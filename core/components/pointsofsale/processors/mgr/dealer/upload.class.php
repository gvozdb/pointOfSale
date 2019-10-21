<?php

class pointsOfSaleDealerUploadProcessor extends modObjectProcessor
{
    public $objectType = 'pof_dealer';
    public $classKey = 'pof_dealer';
    public $languageTopics = ['pointsofsale'];
    public $workFile;
    public $pointsOfSale;
    //public $permission = 'save';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize()
    {
        return true;
    }

    public function process()
    {
        $filename = $this->getProperty('file');
        if (!empty($filename)) {
            $pointsOfSale = $this->modx->getService('pointsOfSale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/', array());
            if (!$pointsOfSale) {
                return $this->failure('Could not load pointsOfSale class!');
            }

            $this->pointsOfSale =& $pointsOfSale;
            $this->workFile = MODX_BASE_PATH . $filename;

            $countries = array();

            if (!is_file($this->workFile)) {
                $error = $this->modx->lexicon('pointsofsale_dealer_file_nf');
                return $this->failure($error);
            }

            $data = $this->pointsOfSale->getSheet($this->workFile);
            if (!is_array($data)) {
                return $this->failure('not array');
            }
            foreach ($data as $item) {
                if (!is_array($item)) {
                    continue;
                }
                if (empty($item['address_line_2'])) {
                    continue;
                }
                $q = $this->modx->newObject($this->classKey);
                $q->fromArray($item);
                $q->save();
                $this->modx->logManagerAction($this->objectType . '_upload', $this->classKey, $q->get($this->primaryKeyField));

                if (!in_array($item['country'], $countries)) {
                    $countries[] = $item['country'];
                }
            }


            $processorProps = array(
                'countries' => $countries
            );
            $otherProps = array(
                // Здесь указываем где лежат наши процессоры
                'processors_path' => $this->modx->getOption('core_path') . 'components/pointsofsale/processors/'
            );

            $response = $this->modx->runProcessor('mgr/country/upload', $processorProps, $otherProps);

            //return $response->response;



            $msg = $this->modx->lexicon('pointsofsale_dealer_file_uploaded');
            return $this->modx->error->success($msg, $q);
        } else {
            $error = $this->modx->lexicon('pointsofsale_dealer_file_nf');
            return $this->failure($error);
        }
    }


}

return 'pointsOfSaleDealerUploadProcessor';
