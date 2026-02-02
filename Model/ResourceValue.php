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
use DateTimeInterface;

interface ResourceValue
{
    public function setKey(string $key): void;

    public function getKey(): string;

    public function setTextValue(?string $textValue): void;

    public function getTextValue(): ?string;

    public function setDateValue(?DateTimeInterface $dateValue): void;

    public function getDateValue(): ?DateTimeImmutable;

    public function setDatetimeValue(?DateTimeInterface $datetimeValue): void;

    public function getDatetimeValue(): ?DateTimeImmutable;

    public function setTimeValue(?DateTimeInterface $timeValue): void;

    public function getTimeValue(): ?DateTimeImmutable;

    public function setNumberValue(string|null $numberValue): void;

    public function getNumberValue(): string|null;

    public function setIntegerValue(?int $integerValue): void;

    public function getIntegerValue(): ?int;

    public function setBoolValue(?bool $boolValue): void;

    public function getBoolValue(): ?bool;
}
