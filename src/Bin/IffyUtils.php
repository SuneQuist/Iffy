<?php

namespace Iffy\Bin;

class IffyUtils {

    /**
     * #### Gets the in-between of the two provided regex's.
     * -------------
     * ---
     * This example will return all elements in order 
     * from an html/dom string.
     * 
     * ```php
     * $elements = array();
     * 
     * between($string, ['/<[^\/]([^<]*)>/', '/<\/(.+?)>/'], $elements);
     * ```
     * ---
     * -------------
     * 
     * @param array|object|string $search - required*
     * @param array $inBetween - required*
     * @param array|object $pointer - not required
     * @return array
     */
    public static function inbetween(array|object|string $search, array $inBetween, array|object &$pointer = null) 
    {
        if (is_array($search) || is_object($search)) {
            "".join("\n", (array)$search);
        }

        [$opening, $closing] = $inBetween;

        preg_match_all($opening, $search, $opening_matches, PREG_OFFSET_CAPTURE);

        preg_match_all($closing, $search, $closing_matches, PREG_OFFSET_CAPTURE);

        $opening_matches = $opening_matches[0];
        $closing_matches = $closing_matches[0];

        if ( $opening_matches === null
        ||   $closing_matches === null
        ) { return null; }

        $opening_matches = array_map(function ($match) {
            $match = (object)$match;
            $match->opening = $match->{0};
            $match->position = $match->{1};
            unset($match->{0});
            unset($match->{1});
            return $match;
        }, $opening_matches);

        $closing_matches = array_map(function ($match) {
            $match = (object)$match;
            $match->closing = $match->{0};
            $match->position = $match->{1};
            unset($match->{0});
            unset($match->{1});
            return $match;
        }, $closing_matches);

        $matches = array_merge($opening_matches, $closing_matches);

        /** Sort the matches in order of found */
        usort($matches, function ($current, $next) {
            return abs($current->position) - abs($next->position);
        });

        $queue = array();
        $stack = array();
        foreach ($matches as $match) {
            $match = (object)$match;

            if (isset($match->opening)) {
                $match->opening_position = $match->position;
                unset($match->position);
                $queue[] = $match;
            }
            
            if (isset($match->closing)) {
                $match->closing_position = $match->position;
                unset($match->position);

                $obj = (object)array();
                $opening_match = array_pop($queue);

                if (isset($opening_match)) {
                    $obj->opening = $opening_match->opening;
                    $obj->closing = $match->closing;
                    $obj->opening_position = $opening_match->opening_position;
                    $obj->closing_position = $match->closing_position;
        
                    $stack[] = $obj;
                }
            }
        }

        usort($stack, function ($current, $next) {
            return abs($current->opening_position) - abs($next->opening_position);
        });

        $stack = array_map(function ($match) use(&$search) {
            $get = function () use (&$match, &$search) {
                $offset = $match->opening_position + strlen($match->opening);
                $inner_content = substr(
                    $search, 
                    $offset,
                    ($match->closing_position - $offset)
                );

                /* Content */
                $match->content = $match->opening.$inner_content.$match->closing;
                $match->inner_content = $inner_content;

                /* Length  */
                $match->content_length = (($match->closing_position + strlen($match->closing)) - $match->opening_position);
                $match->inner_content_length = ($match->closing_position - $offset);

                /* Positions */
                $obj = (object)array();
                $obj->opening_position = $match->opening_position;
                $obj->closing_position = $match->closing_position + strlen($match->closing);
                $obj->opening_position_inner_content = $match->opening_position + strlen($match->opening);
                $obj->closing_position_inner_content = $match->closing_position;
                
                unset($match->opening_position);
                unset($match->closing_position);
                
                return $obj;
            };

            $match->positions = $get();
            return $match;
        }, $stack);

        if ($pointer) {
            if (is_object($pointer)) {
                $pointer = (array)$pointer;
                $pointer = array_merge($pointer, $stack);
                $pointer = (object)$pointer;
            } else { $pointer = array_merge($pointer, $stack); }

            if ( ! empty($pointer) ) {
                return $pointer;
            }
        }

        if ( empty($stack) ) { return null; }
        return $stack;
    }

    /**
     * @param int $length - Length of string.
     * @return string
     */
    public static function filler(int $length = 10) 
    {
        $characters ='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $total_characters = strlen($characters);
        $clamp_to_length = ceil($length/$total_characters);

        // Repeat and shuffle the characters
        $repeat_characters = str_repeat($characters, $clamp_to_length);
        $shuffle_string = str_shuffle($repeat_characters);

        return substr($shuffle_string, 1, $length);
    }
}