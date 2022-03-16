<?php
use \Bitrix\Main\Application,
    \Bitrix\Main\Type\DateTime,
    \Bitrix\Sale\Order;


class cDeliverycorrection {


    public function onSaleDeliveryServiceCalculateHandler($result, $shipment, $deliveryID){

        $options=\Bitrix\Main\Config\Option::getForModule("deliverycorrection");
        $orderPrice = $shipment->getShipmentItemCollection()->getPrice();
        $shipmentPrice=$result->getPrice();
        $newPrice=false;
        if($shipment->getField("XML_ID")=="RU" && $options["xml_id_ru"]){
           $newPrice=$shipmentPrice/100 * $options["xml_id_ru"];
           $newPrice=$shipmentPrice+$newPrice;
        }elseif($orderPrice>=$options["order_summ"]){
            $newPrice=$options['delivery_price'];
        }elseif($options["xml_id_all"]){
            $newPrice=$shipmentPrice+$options["xml_id_all"];
        }

        if($newPrice) $shipment->setBasePriceDelivery($newPrice);

    }

}