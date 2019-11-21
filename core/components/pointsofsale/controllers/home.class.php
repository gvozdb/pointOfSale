<?php

/**
 * The home manager controller for pointsOfSale.
 *
 */
class pointsOfSaleHomeManagerController extends modExtraManagerController
{
    /** @var pointsOfSale $pointsOfSale */
    public $pointsOfSale;

    /**
     *
     */
    public function initialize()
    {
        $this->pointsOfSale = $this->modx->getService('pointsOfSale', 'pointsOfSale', MODX_CORE_PATH . 'components/pointsofsale/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['pointsofsale:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('pointsofsale');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->pointsOfSale->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/pointsofsale.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/points.grid.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/points.windows.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/distributors.grid.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/distributors.windows.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/service_centers.grid.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/service_centers.windows.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/dealers.grid.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/dealers.windows.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/countries.grid.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/countries.windows.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->pointsOfSale->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('
            <script>
                pointsOfSale.config = ' . json_encode($this->pointsOfSale->config) . ';
                pointsOfSale.config.connector_url = "' . $this->pointsOfSale->config['connectorUrl'] . '";
                Ext.onReady(function() {MODx.load({ xtype: "pointsofsale-page-home"});});
            </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="pointsofsale-panel-home-div"></div>';

        return '';
    }
}