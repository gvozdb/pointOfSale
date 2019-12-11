<?php

/**
 *
 */
class posMsOnGetProductPrice extends posPlugin
{
    /**
     * @var AviatorSite $avs
     */
    protected $avs;
    /**
     * @var avsLanguageLocation $all
     */
    protected $all;

    function __construct(pointsOfSale &$pos, array &$sp)
    {
        parent::__construct($pos, $sp);

        $this->avs = $this->modx->getService('aviatorsite', 'AviatorSite',
            $this->modx->getOption('avs_core_path', null, MODX_CORE_PATH . 'components/aviatorsite/') . 'model/aviatorsite/');
        $this->avs->initialize($this->modx->context->key);

        $this->all = $this->avs->getLanguageLocation();
    }

    public function run()
    {
        /** @var msProductData $product */
        $data = $this->sp['data'];
        $product = $this->sp['product'];
        $price = $this->sp['price'];

        // Get prices data
        $prices = [];
        if (!empty($data['prices'])) {
            $prices = $data['prices'];
        }
        if (empty($prices)) {
            if (!$product instanceof msProductData) {
                $product = $this->modx->getObject('msProductData', ['id' => $data['id']]);
            }
            if ($product instanceof msProductData) {
                $prices = $product->get('prices') ?: [];
            }
        }
        if (!empty($prices) && $this->pos->tools->isJSON($prices)) {
            $prices = $this->modx->fromJSON($prices);
        }

        // // Get price from msOptionsPrice placeholder
        // $returned = $this->modx->getPlaceholder('_returned_price') ?: [];
        // if (!empty($returned['price'])) {
        //     if (empty($data['id']) || (int)$returned['id'] === (int)$data['id']) {
        //         $price = $returned['price'];
        //     }
        // }
        // $returned['price'] = $price;

        // Set product id to msOptionsPrice placeholder
        if (!empty($data['id'])) {
            $returned['id'] = $data['id'];
        }

        //
        if (!empty($prices)) {
            $location = $this->all->getLocationData();
            if (!empty($prices[$location['id']])) {
                $price = $prices[$location['id']];
            }
        }

        // Set product price
        $returned['price'] = $price;
        $this->setPrice($returned);
    }

    /**
     * @param $returned
     *
     * @return bool
     */
    protected function setPrice($returned)
    {
        if (is_numeric($returned['price'])) {
            $this->modx->setPlaceholder('_returned_price', $returned);
            $this->modx->event->returnedValues['price'] = $returned['price'];
        }

        return true;
    }
}