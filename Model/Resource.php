<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\ResourceRepositoryBundle\Model;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class Resource implements ResourceValue
{
    protected string $key;

    protected ?string $textValue = null;

    protected ?DateTimeImmutable $datetimeValue = null;

    protected ?DateTimeImmutable $dateValue = null;

    protected ?DateTimeImmutable $timeValue = null;

    protected string|null $numberValue = null;

    protected ?int $integerValue = null;

    protected ?bool $boolValue = null;

    public function __construct()
    {
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setTextValue(?string $textValue): void
    {
        $this->textValue = $textValue;
    }

    public function getTextValue(): ?string
    {
        return $this->textValue;
    }

    public function setDateValue(?DateTimeInterface $dateValue): void
    {
        $this->dateValue = $this->toDateTimeImmutable($dateValue);
    }

    public function getDateValue(): ?DateTimeImmutable
    {
        return $this->dateValue;
    }

    public function setDatetimeValue(?DateTimeInterface $datetimeValue): void
    {
        $this->datetimeValue = $this->toDateTimeImmutable($datetimeValue);
    }

    public function getDatetimeValue(): ?DateTimeImmutable
    {
        return $this->datetimeValue;
    }

    public function setTimeValue(?DateTimeInterface $timeValue): void
    {
        $this->timeValue = $this->toDateTimeImmutable($timeValue);
    }

    public function getTimeValue(): ?DateTimeImmutable
    {
        return $this->timeValue;
    }

    public function setNumberValue(string|null $numberValue): void
    {
        $this->numberValue = $numberValue;
    }

    public function getNumberValue(): string|null
    {
        return $this->numberValue;
    }

    public function setIntegerValue(?int $integerValue): void
    {
        $this->integerValue = $integerValue;
    }

    public function getIntegerValue(): ?int
    {
        return $this->integerValue;
    }

    public function setBoolValue(?bool $boolValue): void
    {
        $this->boolValue = $boolValue;
    }

    public function getBoolValue(): ?bool
    {
        return $this->boolValue;
    }

    private function toDateTimeImmutable(?DateTimeInterface $value): ?DateTimeImmutable
    {
        if (true === $value instanceof DateTime) {
            return DateTimeImmutable::createFromMutable($value);
        }

        if (true === $value instanceof DateTimeImmutable) {
            return $value;
        }

        return null;
    }
}
