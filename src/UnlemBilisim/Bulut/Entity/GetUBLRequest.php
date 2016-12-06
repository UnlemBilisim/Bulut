<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 11:39
 */

namespace UnlemBilisim\Bulut\Entity;


class GetUBLRequest extends Entity
{
    private $class_start = '<ein:getUBLRequest>';
    private $class_stop = '</ein:getUBLRequest>';

    private $xml;
    private $length;
    private $SOAPAction = "getUBL";

    public function __construct($Identifier = "", $VKN_TCKN = "", $UUID = "", $DocType = "", $Type = "", $Parameters = "")
    {
        $this->xml = $this->start_param;
        $this->xml .= $this->body_start_param;
        $this->xml .= $this->class_start;

        if($Identifier != "")
            $this->xml .= '<ein:Identifier>'.$Identifier.'</ein:Identifier>';
        if($VKN_TCKN != "")
            $this->xml .= '<ein:VKN_TCKN>'.$VKN_TCKN.'</ein:VKN_TCKN>';
        if($UUID != "")
            $this->xml .= '<ein:UUID>'.$UUID.'</ein:UUID>';
        if($DocType != "")
            $this->xml .= '<ein:DocType>'.$DocType.'</ein:DocType>';
        if($Type != "")
            $this->xml .= '<ein:Type>'.$Type.'</ein:Type>';
        if($Parameters != "")
            $this->xml .= '<ein:Parameters>'.$Parameters.'</ein:Parameters>';


        $this->xml .= $this->class_stop;
        $this->xml .= $this->body_stop_param;
        $this->xml .= $this->stop_param;

        $this->length = strlen($this->xml);
    }

    public function getLength()
    {
        return $this->length;
    }
    public function getSOAPAction()
    {
        return $this->SOAPAction;
    }
    public function getXML()
    {
        return $this->xml;
    }
}