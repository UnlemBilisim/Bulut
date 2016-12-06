<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 11:59
 */

namespace UnlemBilisim\Bulut\Entity;


class UserListItem
{

    private $Identifier;
    private $Alias;
    private $Title;
    private $Type;
    private $RegisterTime;
    private $FirstCreationTime;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->Identifier;
    }

    /**
     * @param mixed $Identifier
     */
    public function setIdentifier($Identifier)
    {
        $this->Identifier = $Identifier;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->Alias;
    }

    /**
     * @param mixed $Alias
     */
    public function setAlias($Alias)
    {
        $this->Alias = $Alias;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param mixed $Title
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getRegisterTime()
    {
        return $this->RegisterTime;
    }

    /**
     * @param mixed $RegisterTime
     */
    public function setRegisterTime($RegisterTime)
    {
        $this->RegisterTime = $RegisterTime;
    }

    /**
     * @return mixed
     */
    public function getFirstCreationTime()
    {
        return $this->FirstCreationTime;
    }

    /**
     * @param mixed $FirstCreationTime
     */
    public function setFirstCreationTime($FirstCreationTime)
    {
        $this->FirstCreationTime = $FirstCreationTime;
    }


}