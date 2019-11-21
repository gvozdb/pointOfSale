<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class pointsOfSale
{
    public $config = [];
    /**
     * @var modX $modx
     */
    public $modx;
    /**
     * @var posTools $tools
     */
    public $tools;
    /**
     * @var pdoTools $pdoTools
     */
    public $pdoTools;
    /**
     * @var pdoFetch $pdoFetch
     */
    public $pdoFetch;
    /**
     * @var \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     */
    public $spreadsheet;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx = &$modx;
        $corePath = MODX_CORE_PATH . 'components/pointsofsale/';
        $assetsUrl = MODX_ASSETS_URL . 'components/pointsofsale/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'pluginsPath' => $corePath . 'plugins/',
            'handlersPath' => $corePath . 'handlers/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',

            'prepareResponse' => false,
            'jsonResponse' => false,
        ], $config);

        $this->modx->addPackage('pointsofsale', $this->config['modelPath']);
        $this->modx->lexicon->load('pointsofsale:default');

        //
        $this->getTools();
    }

    /**
     * @param modManagerController $controller
     *
     * @return bool
     */
    public function loadManagerScripts(modManagerController $controller)
    {
        if (empty($this->modx->loadedjscripts['posManagerScripts'])) {
            if (!(is_object($controller) && ($controller instanceof modManagerController))) {
                return false;
            }

            // Lexicon
            $controller->addLexiconTopic('pointsofsale:default');

            // CSS
            $controller->head['css'][] = $this->config['cssUrl'] . 'mgr/main.css';

            // JS
            $controller->head['js'][] = $this->config['jsUrl'] . 'mgr/pointsofsale.js';
            // $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/ux.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/utils.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/combo.js';
            // $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/renderer.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/default/grid.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/default/window.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/default/formpanel.js';
            $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/misc/default/panel.js';

            // Config
            $controller->addHtml('
                <script>
                    pointsOfSale[\'config\'] = ' . json_encode($this->config) . ';
                    pointsOfSale.config[\'connector_url\'] = "' . $this->config['connectorUrl'] . '";
                </script>
            ');
        }

        return $this->modx->loadedjscripts['posManagerScripts'] = true;
    }

    /**
     * @param modManagerController $controller
     *
     * @return bool
     */
    public function loadManagerResourceScripts(modManagerController $controller)
    {
        if (!$this->loadManagerScripts($controller)) {
            return false;
        }
        if (!isset($controller->resource) || !is_object($controller->resource) || $controller->resource->get('class_key') !== 'msProduct') {
            return false;
        }
        /** @var msProduct $product */
        $product = &$controller->resource;

        // JS
        $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/widgets/prices/grid.js';
        $controller->head['lastjs'][] = $this->config['jsUrl'] . 'mgr/inject/product.tab.js';

        // Config
        $controller->addHtml('
            <script>
                pointsOfSale.config[\'product_id\'] = "' . $product->get('id') . '";
            </script>
        ');

        return true;
    }

    /**
     * @param array $config
     *
     * @return posTools
     */
    public function getTools(array $config = [])
    {
        if (!is_object($this->tools)) {
            if ($class = $this->modx->loadClass('tools.posTools', $this->config['handlersPath'], true, true)) {
                $this->tools = new $class($this, $config);
            }
        }

        return $this->tools;
    }

    /**
     * @return pdoTools
     */
    public function getPdoTools()
    {
        if (class_exists('pdoTools') && !is_object($this->pdoTools)) {
            $this->pdoTools = $this->modx->getService('pdoTools');
        }

        return $this->pdoTools;
    }

    /**
     * @return pdoFetch
     */
    public function getPdoFetch()
    {
        if (class_exists('pdoFetch') && !is_object($this->pdoFetch)) {
            $this->pdoFetch = $this->modx->getService('pdoFetch');
        }

        return $this->pdoFetch;
    }

    /**
     * @param $sheet
     *
     * @return int
     */
    public function getSheetCount($sheet)
    {
        $this->setSpreadsheet($sheet);
        $sheetCount = $this->spreadsheet->getSheetCount();

        return $sheetCount;
    }

    /**
     * @param $pIndex
     *
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
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

    /**
     * @param $sheet
     *
     * @return array|mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function getSheet($sheet)
    {
        $this->setSpreadsheet($sheet);
        $sheet = $this->spreadsheet->getSheet(0);
        $sheetData = $sheet->toArray(null, true, true, true);
        $sheetData = $this->cleanSpreadsheetData($sheetData);
        $sheetData = $this->changeKeys($sheetData);
        return $sheetData;

    }

    /**
     * @param $sheet
     *
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function setSpreadsheet($sheet)
    {
        $spreadsheet = IOFactory::load($sheet);
        $this->spreadsheet = $spreadsheet;
    }

    /**
     * @param $sheetData
     *
     * @return mixed
     */
    public function cleanSpreadsheetData($sheetData)
    {
        foreach($sheetData as $k => $sheetRow){
            if(empty($sheetRow['A']) && empty($sheetRow['B']) && empty($sheetRow['C'])){
                unset($sheetData[$k]);
            }
        }

        return $sheetData;
    }

    /**
     * @param $sheetData
     *
     * @return mixed
     */
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

    /**
     * @param $k
     *
     * @return mixed|string
     */
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