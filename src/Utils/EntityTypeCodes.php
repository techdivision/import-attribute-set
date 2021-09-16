<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\EntityTypeCodes
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Utils;

/**
 * Utility class containing the entity type codes.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class EntityTypeCodes extends \TechDivision\Import\Utils\EntityTypeCodes
{

    /**
     * Key for the product entity 'eav_attribute_set'.
     *
     * @var string
     */
    const EAV_ATTRIBUTE_SET = 'eav_attribute_set';

    /**
     * Key for the product entity 'eav_attribute_group'.
     *
     * @var string
     */
    const EAV_ATTRIBUTE_GROUP = 'eav_attribute_group';
}
