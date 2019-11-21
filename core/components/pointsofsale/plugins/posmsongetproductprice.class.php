<?php

/**
 *
 */
class posMsOnGetProductPrice extends posPlugin
{
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

        // //
        // if (!empty($prices)) {
        //     if (!empty($_SESSION['user_location']) && !empty($_SESSION['user_location']['code'])) {
        //
        //     }
        // }

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