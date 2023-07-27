<?php
namespace phpEther\Encoder;

use phpEther\Tool\Hex;

/**
 * Class RplEncoder
 * @package phpEther\Encoder
 * @see https://github.com/ethereum/wiki/wiki/RLP
 */
class RplEncoder
{

    static function encode($input)
    {
        if (is_string($input)) {
            if($input === hex2bin("00")) {
                return chr(128);
            }
            if (strlen($input) == 1 && ord($input) < 128){
                return $input;
            }

            return self::encodeLength(strlen($input), 128) . $input;
        }
        if (is_array($input)) {
            $output = '';
            foreach ($input as $item) {
                $output .= self::encode($item);
            }

            return self::encodeLength(strlen($output), 192) . $output;
        }
    }

    static function encodeLength($l, $offset)
    {
        if ($l < 56) {
            return chr($l + $offset);
        } elseif ($l < 256 ** 8) {
            $bl = hex2bin(Hex::fromDec($l));
            return chr(strlen($bl) + $offset + 55) . $bl;
        } else {
            throw new \Exception('Failed to encode length');
        }
    }
}