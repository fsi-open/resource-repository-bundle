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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setDateValue($dateValue)
    {
        $this->dateValue = $dateValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setDatetimeValue($datetimeValue)
    {
        $this->datetimeValue = $datetimeValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setTimeValue($timeValue)
    {
        $this->timeValue = $timeValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setNumberValue($numberValue)
    {
        $this->numberValue = $numberValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setIntegerValue($integerValue)
    {
        $this->integerValue = $integerValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setBoolValue($boolValue)
    {
        $this->boolValue = $boolValue;

        return $this;
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
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setFileValue($file)
    {
        if (!empty($file)) {
            $this->fileValue = $file;
        }

        return $this;
    }

    /**
     * @return \FSi\DoctrineExtensions\Uploadable\File|null
     */
    public function getFileValue()
    {
        return $this->fileValue;
    }

    /**
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function removeFileValue()
    {
        $this->fileValue = null;

        return $this;
    }

    /**
     * @param string $fileKeyValue
     *
     * @return \FSi\Bundle\ResourceRepositoryBundle\Entity\Resource
     */
    public function setFileKeyValue($fileKeyValue)
    {
        $this->fileKeyValue = $fileKeyValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileKeyValue()
    {
        return $this->fileKeyValue;
    }
}
