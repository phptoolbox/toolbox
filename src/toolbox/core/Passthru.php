<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\core;

/**
 * Advanced passthru command
 */
class Passthru
{
    static public function create($command)
    {
        $ob = new self();
        return $ob;
    }
}
?>
