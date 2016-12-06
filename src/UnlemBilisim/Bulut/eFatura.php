<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 11:17
 */

namespace UnlemBilisim\Bulut;


use UnlemBilisim\Bulut\Entity\GetUBLListRequest;
use UnlemBilisim\Bulut\Entity\GetUBLRequest;
use UnlemBilisim\Bulut\Entity\UserListsRequest;
use UnlemBilisim\Bulut\Entity\UserListItem;

class eFatura
{
    private $SERVICE_TEST_URL = "https://efaturawstest.fitbulut.com/ClientEInvoiceServices/ClientEInvoiceServicesPort.svc";
    private $SERVICE_PROD_URL = "https://efaturaws.fitbulut.com/ClientEInvoiceServices/ClientEInvoiceServicesPort.svc";

    private $findBodyStart = ["<s:Body xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">", "<s:Body>", '<s:Fault>'];
    private $findBodyStop = ["</s:Body>","</s:Body>", '</s:Fault>'];

    private $serviceUsername;
    private $servicePassword;
    private $ch;

    private $_headers = [
        'Content-type: text/xml;charset="utf-8"',
        'Accept: text/xml',
        'Cache-Control: no-cache',
        'Pragma: no-cache',
    ];
    //"SOAPAction: getUserList",
    //"Content-length: ".strlen($xml_post_string),


    public function setTestUrl($url)
    {
        $this->SERVICE_TEST_URL = $url;
    }

    public function setProdUrl($url)
    {
        $this->SERVICE_PROD_URL = $url;
    }

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_POST, true);
    }

    /*
     * $type @String
     * "PROD", "TEST"
     *
     */
    public function serviceType($type)
    {
        if($type == "TEST")
            curl_setopt($this->ch, CURLOPT_URL, $this->SERVICE_TEST_URL);
        else
            curl_setopt($this->ch, CURLOPT_URL, $this->SERVICE_PROD_URL);

    }

    public function setWSAuth($wsUser, $wsPass)
    {
        $this->servicePassword = $wsPass;
        $this->serviceUsername = $wsUser;
        curl_setopt($this->ch, CURLOPT_USERPWD, $wsUser.":".$wsPass); // username and password - declared at the top of the doc

    }

    public function FaturaGonder($TCKN_VKN, $gonBirim, $PK, $tarih1)
    {

/*
            //proje içerisine include edilen UBL-Invoice-2_1.cs dosyasına namespace ekleyerek projemize dahil ediyoruz.
            InvoiceType createdUbl = CreateUBL(TCKN_VKN, tarih1); //bu metod ile göndereceğimiz efatura nın parametrelerini set ediyoruz.

            string strFatura = GetXML(createdUbl); //CreateUBL (projenin en üst kısmında) metodundan dönen veriyi xml'e çeviriyoruz. hazır metod sizde kopyalayabilirsiniz.

            byte[] byteFatura = System.Text.Encoding.ASCII.GetBytes(strFatura); //xml verisini byte tipine çeviriyoruz.

            //burda dikkat edilmesi gereken kısım, ZipFile() metodu (projenin üst kısmında) sadece .net 4.5 da çalışmatadır. öncesi sistemler için 3rd party ionic zip kullanılmaktadır. DLL dosyası projenin içinde mevcut.
            byte[] zipliFile = IonicZipFile(strFatura, createdUbl.UUID.Value); //xml olarak dönüştürülen efaturayı zip dosyası içine ekliyoruz.

            //diğer bir nokta, xml olarak gelen veriyi ve zip dosyasını fiziksel dosya olarak herhangi bir yere kayıt etmiyoruz. bellekte saklanan veriyi gönderiyoruz.

            ClientEInvoiceServicesPortClient wsClient = new ClientEInvoiceServicesPortClient();

            using (new System.ServiceModel.OperationContextScope((System.ServiceModel.IClientChannel)wsClient.InnerChannel))
            {

                System.ServiceModel.Web.WebOperationContext.Current.OutgoingRequest.Headers.Add(HttpRequestHeader.Authorization, GetAuthorization(wsUserName, wsPass));

                var req = new sendUBLRequest()
                {
                    SenderIdentifier = gonbirim, //gönderici birim etiketi
                    ReceiverIdentifier = pk, //alıcı posta kutusu
                    VKN_TCKN = TCKN_VKN, //tc veya vergi numarası
                    DocType = "INVOICE", //gönderilen döküman tipi. zarf, fatura vs.
                    DocData = zipliFile //içinde xml dosyası olan zip lenen dosya.
                };

                var result = wsClient.sendUBL(req);

                return result;
            }
        }
*/
    }

    public function getUserLists(UserListsRequest $UserListsRequest)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UserListsRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UserListsRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UserListsRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);

        $response = curl_exec($this->ch);

        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);

        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;
    }

    public function mukellefSorgu($TCKN_VKN, $gonderenBirim, $gelenBirim)
    {
        $UserListsRequest = new UserListsRequest($gonderenBirim, $TCKN_VKN, "GB", "", $gelenBirim);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UserListsRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UserListsRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UserListsRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);

        $response = curl_exec($this->ch);



        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);
        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;

    }

    public function getUBLRequest(GetUBLRequest $UBLRequest)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UBLRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UBLRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UBLRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);

        $response = curl_exec($this->ch);

        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);

        var_dump($response3);
        exit;

        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;
    }
    public function GelenZarflar($TCKN_VKN = "", $Pk = "", $Tarih1 = "", $Tarih2 = "")
    {
        //public function __construct($DocType = "", $Type = "", $Parameters = "", $FromDate = "", $ToDate = "")


        $UBLRequest = new GetUBLListRequest($Pk,$TCKN_VKN, "", "ENVELOPE", "INBOUND", "", $Tarih1, $Tarih2);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UBLRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UBLRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UBLRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);


        $response = curl_exec($this->ch);

        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);

        var_dump($response3);
        exit;

        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;
    }

    public function GelenFaturalar($TCKN_VKN = "", $Pk = "", $Tarih1 = "", $Tarih2 = "")
    {
        //public function __construct($DocType = "", $Type = "", $Parameters = "", $FromDate = "", $ToDate = "")


        $UBLRequest = new GetUBLListRequest($Pk,$TCKN_VKN, "", "INVOICE", "INBOUND", "", $Tarih1, $Tarih2);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UBLRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UBLRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UBLRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);


        $response = curl_exec($this->ch);

        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);

        var_dump($response3);
        exit;

        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;
    }

    public function GelenUygulamaYanitlari($TCKN_VKN = "", $gonBirim = "", $Tarih1 = "", $Tarih2 = "")
    {
        //public function __construct($DocType = "", $Type = "", $Parameters = "", $FromDate = "", $ToDate = "")


        $UBLRequest = new GetUBLListRequest($gonBirim,$TCKN_VKN, "", "APP_RESP", "INBOUND", "", $Tarih1, $Tarih2);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $UBLRequest->getXML());
        $this->_headers[] = 'SOAPAction: ' . $UBLRequest->getSOAPAction();
        $this->_headers[] = 'Content-length: ' . $UBLRequest->getLength();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->_headers);


        $response = curl_exec($this->ch);

        $response1 = str_replace($this->findBodyStart,"",$response);
        $response2 = str_replace($this->findBodyStop,"",$response1);

        $response3 = simplexml_load_string($response2);

        var_dump($response3);
        exit;

        if(isset($response3->faultstring))
            throw new \Exception('['.$response3->detail->ProcessingFault->Code->__toString().'] -> '.$response3->detail->ProcessingFault->Message->__toString());

        $arrs = [];
        foreach ($response3->getUserListResponse->User as $res)
        {
            $Item = new UserListItem();
            $Item->setIdentifier($res->Identifier->__toString());
            $Item->setAlias($res->Alias->__toString());
            $Item->setTitle($res->Title->__toString());
            $Item->setType($res->Type->__toString());
            $Item->setRegisterTime($res->RegisterTime->__toString());
            $Item->setFirstCreationTime($res->FirstCreationTime->__toString());
            $arrs[] = $Item;
        }
        return $arrs;
    }



    public function __destruct()
    {
        curl_close($this->ch);
    }

}
