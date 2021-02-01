<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Product
{
    /**
     * @var UuidInterface
     */
    private $serialNumber;

    /**
     * @var BigDecimal
     */
    private $price;

    /**
     * @var string
     */
    private $desc;

    /**
     * @var string
     */
    private $longDesc;

    /**
     * @var int
     */
    private $counter;

    /**
     * Product constructor.
     * @param BigDecimal $price
     * @param string $desc
     * @param string $longDesc
     * @param int $counter
     */
    public function __construct(BigDecimal $price, string $desc, string $longDesc, int $counter)
    {
        $this->serialNumber = Uuid::uuid4();
        $this->price = $price;
        $this->desc = $desc;
        $this->longDesc = $longDesc;
        $this->counter = $counter;
    }

    /**
     * @return UuidInterface
     */
    public function getSerialNumber(): UuidInterface
    {
        return $this->serialNumber;
    }

    /**
     * @return BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string
    {
        return $this->longDesc;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    public function decrementCounter(): void
    {
        $this->priceSignValidation();
        --$this->counter;
        if ($this->counter < 0) {
            throw new \RuntimeException('Negative counter');
        }
    }

    public function incrementCounter(): void
    {
        $this->priceSignValidation();
        ++$this->counter;
    }

    /**
     * @param BigDecimal $newPrice
     */
    public function changePriceTo(BigDecimal $newPrice): void
    {
        if ($this->counter > 0) {
            $this->price = $newPrice;
            $this->priceSignValidation();
        }
    }

    /**
     * @param string $charToReplace
     * @param string $replaceWith
     * @throws \Exception
     */
    public function replaceCharFromDesc(string $charToReplace, string $replaceWith): void
    {
        if ($this->isDescsFilled() !== true) {
            throw new \RuntimeException('empty desc');
        }

        $this->longDesc = $this->replaceChar($charToReplace, $replaceWith, $this->longDesc);
        $this->desc = $this->replaceChar($charToReplace, $replaceWith, $this->desc);
    }

    /**
     * @return string
     */
    public function formatDesc(): string {
        return ($this->isDescsFilled() === true) ? $this->desc . ' *** ' . $this->longDesc : '';
    }

    /**
     * @return bool
     */
    public function isDescsFilled(): bool
    {
        return !(empty($this->longDesc) || empty($this->desc));
    }

    /**
     * @param $search
     * @param $replace
     * @param $subject
     * @return mixed
     */
    public function replaceChar($search, $replace, $subject)
    {
        return str_replace($search, $replace, $subject);
    }

    private function priceSignValidation(): void
    {
        if ($this->price->getSign() <= 0) {
            throw new \RuntimeException('Invalid price');
        }
    }
}





















