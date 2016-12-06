<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 11:39
 */

namespace UnlemBilisim\Bulut\Entity;


class UserListsRequest extends Entity
{
    private $class_start = '<ein:getUserListRequest>';
    private $class_stop = '</ein:getUserListRequest>';

    private $xml;
    private $length;
    private $SOAPAction = "getUserList";

    public function __construct($Identifier = "", $VKN_TCKN = "", $Role = "", $RegisteredAfter = "", $Filter_VKN_TCKN = "")
    {
        $this->xml = $this->start_param;
        $this->xml .= $this->body_start_param;
        $this->xml .= $this->class_start;

        if($Identifier != "")
            $this->xml .= '<ein:Identifier>'.$Identifier.'</ein:Identifier>';
        if($VKN_TCKN != "")
            $this->xml .= '<ein:VKN_TCKN>'.$VKN_TCKN.'</ein:VKN_TCKN>';
        if($Role != "")
            $this->xml .= '<ein:Role>'.$Role.'</ein:Role>';
        if($RegisteredAfter != "")
            $this->xml .= '<ein:RegisteredAfter>'.$RegisteredAfter.'</ein:RegisteredAfter>';
        if($Filter_VKN_TCKN != "")
            $this->xml .= '<ein:Filter_VKN_TCKN>'.$Filter_VKN_TCKN.'</ein:Filter_VKN_TCKN>';

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