<?php

namespace GoDaddy\WordPress\MWC\Common\Helpers;

/**
 * URLs helper.
 */
class UrlHelper
{
    /**
     * Adds a query to a URL.
     *
     * @see \add_query_arg()
     *
     * @param string $url URL to add query to
     * @param array $query array of key-values to add to the query
     * @return string
     */
    public static function addQuery(string $url, array $query) : string
    {
        return add_query_arg($query, $url);
    }

    /**
     * Removes a query element from a URL.
     *
     * @see \remove_query_arg()
     *
     * @param string $url URL to remove query from
     * @param string $key key of the query element to remove
     * @return string
     */
    public static function removeQuery(string $url, string $key) : string
    {
        return remove_query_arg($key, $url);
    }
}
