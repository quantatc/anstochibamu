<?php

namespace GoDaddy\WordPress\MWC\Shipping\Models;

use GoDaddy\WordPress\MWC\Common\Models\AbstractModel;

/**
 * Represents a shipping label generated by a shipping provider.
 *
 * @since 0.1.0
 */
class ShippingLabel extends AbstractModel
{
    /** @var string binary data for an image */
    private $data;

    /** @var string the image format */
    private $format;

    /**
     * Gets the binary data for an image.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getImageData() : string
    {
        return is_string($this->data) ? $this->data : '';
    }

    /**
     * Sets the binary data for an image.
     *
     * @since 0.1.0
     *
     * @param string $value binary data
     * @return self
     */
    public function setImageData(string $value) : ShippingLabel
    {
        $this->data = $value;

        return $this;
    }

    /**
     * Gets the image format.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getImageFormat() : string
    {
        return is_string($this->format) ? $this->format : '';
    }

    /**
     * Sets the image format.
     *
     * @since 0.1.0
     *
     * @param string $value image format
     * @return self
     */
    public function setImageFormat(string $value) : ShippingLabel
    {
        $this->format = $value;

        return $this;
    }
}
