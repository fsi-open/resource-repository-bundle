<?php

/**
 * (c) Fabryka Stron Internetowych sp. z o.o <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Entity;

class Resource
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $textValue;

    /**
     * @var \DateTime
     */
    private $datetimeValue;

    /**
     * @var
     */
    private $dateValue;

    /**
     * @var
     */
    private $timeValue;

    /**
     * @var
     */
    private $numberValue;

    /**
     * @var int
     */
    private $integerValue;

    /**
     * @var bool
     */
    private $boolValue;

    /**
     * @var string
     */
    private $fileKeyValue;

    /**
     * @var \FSi\DoctrineExtensions\Uploadable\File|null
     */
    private $fileValue;

    public function __construct()
    {
        $this->boolValue = false;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $textValue
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;
    }

    /**
     * @return string
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * @param mixed $dateValue
     */
    public function setDateValue($dateValue)
    {
        $this->dateValue = $dateValue;
    }

    /**
     * @return mixed
     */
    public function getDateValue()
    {
        return $this->dateValue;
    }

    /**
     * @param \DateTime $datetimeValue
     */
    public function setDatetimeValue($datetimeValue)
    {
        $this->datetimeValue = $datetimeValue;
    }

    /**
     * @return \DateTime
     */
    public function getDatetimeValue()
    {
        return $this->datetimeValue;
    }

    /**
     * @param mixed $timeValue
     */
    public function setTimeValue($timeValue)
    {
        $this->timeValue = $timeValue;
    }

    /**
     * @return mixed
     */
    public function getTimeValue()
    {
        return $this->timeValue;
    }

    /**
     * @param mixed $numberValue
     */
    public function setNumberValue($numberValue)
    {
        $this->numberValue = $numberValue;
    }

    /**
     * @return mixed
     */
    public function getNumberValue()
    {
        return $this->numberValue;
    }

    /**
     * @param int $integerValue
     */
    public function setIntegerValue($integerValue)
    {
        $this->integerValue = $integerValue;
    }

    /**
     * @return int
     */
    public function getIntegerValue()
    {
        return $this->integerValue;
    }

    /**
     * @param boolean $boolValue
     */
    public function setBoolValue($boolValue)
    {
        $this->boolValue = $boolValue;
    }

    /**
     * @return boolean
     */
    public function getBoolValue()
    {
        return $this->boolValue;
    }

    /**
     * @param \FSi\DoctrineExtensions\Uploadable\File|null $file
     */
    public function setFileValue($file)
    {
        $this->fileValue = $file;
    }

    /**
     * @return \FSi\DoctrineExtensions\Uploadable\File|null
     */
    public function getFileValue()
    {
        return $this->fileValue;
    }

    /**
     * @param string $fileKeyValue
     */
    public function setFileKeyValue($fileKeyValue)
    {
        $this->fileKeyValue = $fileKeyValue;
    }

    /**
     * @return string
     */
    public function getFileKeyValue()
    {
        return $this->fileKeyValue;
    }
}
