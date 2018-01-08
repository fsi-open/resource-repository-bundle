<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Model;

use DateTimeImmutable;

class Resource implements ResourceValue
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $textValue;

    /**
     * @var DateTimeImmutable
     */
    protected $datetimeValue;

    /**
     * @var DateTimeImmutable
     */
    protected $dateValue;

    /**
     * @var DateTimeImmutable
     */
    protected $timeValue;

    /**
     * @var int
     */
    protected $numberValue;

    /**
     * @var int
     */
    protected $integerValue;

    /**
     * @var bool
     */
    protected $boolValue;

    public function __construct()
    {
        $this->boolValue = false;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;
    }

    public function getTextValue()
    {
        return $this->textValue;
    }

    public function setDateValue($dateValue)
    {
        $this->dateValue = $dateValue;
    }

    public function getDateValue()
    {
        return $this->dateValue;
    }

    public function setDatetimeValue($datetimeValue)
    {
        $this->datetimeValue = $datetimeValue;
    }

    public function getDatetimeValue()
    {
        return $this->datetimeValue;
    }

    public function setTimeValue($timeValue)
    {
        $this->timeValue = $timeValue;
    }

    public function getTimeValue()
    {
        return $this->timeValue;
    }

    public function setNumberValue($numberValue)
    {
        $this->numberValue = $numberValue;
    }

    public function getNumberValue()
    {
        return $this->numberValue;
    }

    public function setIntegerValue($integerValue)
    {
        $this->integerValue = $integerValue;
    }

    public function getIntegerValue()
    {
        return $this->integerValue;
    }

    public function setBoolValue($boolValue)
    {
        $this->boolValue = $boolValue;
    }

    public function getBoolValue()
    {
        return $this->boolValue;
    }
}
