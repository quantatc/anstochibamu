<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Contracts;

use GoDaddy\WordPress\MWC\Common\Contracts\CanConvertToArrayContract;
use GoDaddy\WordPress\MWC\Common\Contracts\CanSeedContract;

/**
 * Model contract.
 *
 * @since 3.4.1
 */
interface ModelContract extends CanConvertToArrayContract, CanSeedContract
{
    /**
     * Creates a new instance of the given model class and saves it.
     *
     * Classes implementing this contract can update this method to expect an array of property values and set the model properties.
     *
     * @since 3.4.1
     *
     * @return self
     */
    public static function create();

    /**
     * Gets an instance of the given model class, if found.
     *
     * @since 3.4.1
     *
     * @param mixed $identifier
     * @return self|null
     */
    public static function get($identifier);

    /**
     * Updates a given instance of the model class and saves it.
     *
     * Classes implementing this contract can update this method to expect an array of property values and set the model properties.
     *
     * @since 3.4.1
     *
     * @return self
     */
    public function update();

    /**
     * Deletes a given instance of the model class.
     *
     * @since 3.4.1
     */
    public function delete();

    /**
     * Saves the instance of the class with its current state.
     *
     * @since 3.4.1
     *
     * @return self
     */
    public function save();
}
