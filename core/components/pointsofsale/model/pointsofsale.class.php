<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class pointsOfSale
{
    /** @var modX $modx */
    public $modx;

    /** @var \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet */
    public $spreadsheet;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/pointsofsale/';
        $assetsUrl = MODX_ASSETS_URL . 'components/pointsofsale/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('pointsofsale', $this->config['modelPath']);
        $this->modx->lexicon->load('pointsofsale:default');
    }


    public function getSheetCount($sheet)
    {
        $this->setSpreadsheet($sheet);
        $sheetCount = $this->spreadsheet->getSheetCount();

        return $sheetCount;
    }

    public function getSheetDataByIndex($pIndex)
    {
        $sheet = $this->spreadsheet->getSheet($pIndex);
        $sheetData = $sheet->toArray(null, true, true, true);
        $sheetData = $this->cleanSpreadsheetData($sheetData);
        $sheetData = $this->changeKeys($sheetData);
        $tableData['data'] = $sheetData;
        $tableData['title'] = $sheet->getTitle();
        return $tableData;
    }


    public function getSheet($sheet)
    {
        $this->setSpreadsheet($sheet);
        $sheet = $this->spreadsheet->getSheet(0);
        $sheetData = $sheet->toArray(null, true, true, true);
        $sheetData = $this->cleanSpreadsheetData($sheetData);
        $sheetData = $this->changeKeys($sheetData);
        return $sheetData;

    }

    public function setSpreadsheet($sheet)
    {
        $spreadsheet = IOFactory::load($sheet);
        $this->spreadsheet = $spreadsheet;
    }

    public function cleanSpreadsheetData($sheetData)
    {
        foreach($sheetData as $k => $sheetRow){
            if(empty($sheetRow['A']) && empty($sheetRow['B']) && empty($sheetRow['C'])){
                unset($sheetData[$k]);
            }
        }

        return $sheetData;
    }

    public function changeKeys($sheetData)
    {
        $keys = array();
        $countKeys = 0;
        $changedSheetData = array();

        foreach($sheetData as $k => $sheetRow){
            if($sheetRow['A'] == 'Country'){
                foreach($sheetRow as $sheetValue){
                    if(!empty($sheetValue)){
                        $keys[] = $this->normalizeKey($sheetValue);
                    }
                }
                $countKeys = count($keys);
                unset($sheetData[$k]);
                break;
            }
        }

        foreach($sheetData as $k => $sheetRow){
            $i = 1;
            foreach($sheetRow as $key => $value){
                if($i > $countKeys){
                    unset($sheetRow[$key]);
                }
                $i++;
            }
            $values = array_values($sheetRow);
            $sheetRow = array_combine($keys, $values);

            $sheetData[$k] = $sheetRow;
        }

        return $sheetData;
    }

    public function normalizeKey($k)
    {
        $k = strtolower($k);
        $k = str_replace(' ', '_', $k);

        switch($k){
            case 'e-mail':
                $k = 'email';
                break;
        }

        return $k;
    }

}