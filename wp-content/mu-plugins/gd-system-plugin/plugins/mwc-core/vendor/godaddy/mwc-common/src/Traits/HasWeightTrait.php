<?php

namespace GoDaddy\WordPress\MWC\Common\Traits;

use GoDaddy\WordPress\MWC\Common\Models\Weight;

/**
 * A trait to assign a weight property to an object.
 */
trait HasWeightTrait
{
    /** @var Weight */
    protected $weight;

    /**
     * Gets the weight.
     *
     * @return Weight
     */
    public function getWeight() : Weight
    {
        return $this->weight;
    }

    /**
     * Sets the weight.
     *
     * @param Weight $weight
     * @return $this
     */
    public function setWeight(Weight $weight)
    {
        $this->weight = $weight;

        return $this;
    }
}
