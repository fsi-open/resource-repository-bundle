<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\ResourceRepositoryBundle\Model;

Interface ResourceValue
{
    /**
     * @param string $key
     */
    public function setKey($key);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param string $textValue
     */
    public function setTextValue($textValue);

    /**
     * @return string
     */
    public function getTextValue();

    /**
     * @param \DateTimeInterface $dateValue
     */
    public function setDateValue($dateValue);

    /**
     * @return \DateTimeImmutable
     */
    public function getDateValue();

    /**
     * @param \DateTimeInterface $datetimeValue
     */
    public function setDatetimeValue($datetimeValue);

    /**
     * @return \DateTimeImmutable
     */
    public function getDatetimeValue();

    /**
     * @param \DateTimeInterface $timeValue
     */
    public function setTimeValue($timeValue);

    /**
     * @return \DateTimeImmutable
     */
    public function getTimeValue();

    /**
     * @param mixed $numberValue
     */
    public function setNumberValue($numberValue);

    /**
     * @return mixed
     */
    public function getNumberValue();

    /**
     * @param int $integerValue
     */
    public function setIntegerValue($integerValue);

    /**
     * @return int
     */
    public function getIntegerValue();

    /**
     * @param boolean $boolValue
     */
    public function setBoolValue($boolValue);

    /**
     * @return boolean
     */
    public function getBoolValue();
}
