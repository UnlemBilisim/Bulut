<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 11:39
 */

namespace UnlemBilisim\Bulut\Entity;


class Entity
{
    public $start_param = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ein="http:/fitcons.com/eInvoice/"><soapenv:Header/>';
    public $body_start_param = '<soapenv:Body>';

    public $stop_param = '</soapenv:Envelope>';
    public $body_stop_param = '</soapenv:Body>';

}