<?php

namespace As3\ShortMongoId;

use \MongoId;

/**
 * Shortens a MongoId to a "reasonably" unique, six character string.
 * Is a PHP port of the npm module 'short-mongo-id' by treygriffith.
 *
 * @link    https://www.npmjs.com/package/short-mongo-id
 * @link    https://github.com/treygriffith/short-mongo-id
 *
 * @author  Jacob Bare <jacob.bare@gmail.com>
 */
class Shortener
{
    /**
     * Shortens a MongoId to a "reasonably" unique, six character string.
     *
     * @param   MongoId|string  $identifier
     * @return  string
     */
    public function shorten($identifier)
    {
        $identifier = $this->convertIdentifier($identifier);

        // Create a timestamp by setting the "faux-milliseconds" from the identifier's increment.
        $timestamp  = (Integer) ($identifier->getTimestamp() * 1000) + substr($identifier->getInc(), -3);

        // Encode the timestamp, set the value to six characters and reverse.
        return strrev(substr($this->toBase($timestamp, 64), 1));
    }

    /**
     * Converts an identifier value to a MongoId instance.
     *
     * @param   MongoId|string  $identifier
     * @return  MongoId
     */
    private function convertIdentifier($identifier)
    {
        if ($identifier instanceof MongoId) {
            return $identifier;
        }
        return new MongoId((string) $identifier);
    }

    /**
     * Converts a number to the specified base.
     *
     * @param   int     $num
     * @param   int     $base
     * @return  string
     * @throws  \OutOfRangeException
     */
    private function toBase($num, $base)
    {
        $symbols    = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-');
        $decimal    = $num;
        $conversion = '';

        if ($base > count($symbols) || $base <= 1) {
            throw new \OutOfRangeException(sprintf('Radix must be less than %s and greater than 1', count($symbols)));
        }

        while ($decimal > 0) {
            $temp       = floor($decimal / $base);
            $index      = $decimal - ($base * $temp);
            $conversion = $symbols[$index] . $conversion;
            $decimal    = $temp;
        }
        return $conversion;
    }
}
