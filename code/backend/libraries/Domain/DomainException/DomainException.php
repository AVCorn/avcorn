<?php

/**
 * Domain Exception
 *
 * PHP version 8.2
 *
 * @phpversion >= 8.2
 * @category   CMS
 * @package    AVCorn
 * @subpackage App\Domain\DomainException
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

declare(strict_types=1);

namespace App\Domain\DomainException;

use Exception;

/**
 * Abstract Domain Exception Class
 */
abstract class DomainException extends Exception
{
}
