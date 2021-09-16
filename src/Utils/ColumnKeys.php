<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\ColumnKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Utils;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class ColumnKeys extends \TechDivision\Import\Attribute\Utils\ColumnKeys
{

    /**
     * Name for the column 'based_on'.
     *
     * @var string
     */
    const BASED_ON = 'based_on';

    /**
     * Name for the column 'default_id'.
     *
     * @var string
     */
    const DEFAULT_ID = 'default_id';

    /**
     * Name for the column 'attribute_group_code'.
     *
     * @var string
     */
    const ATTRIBUTE_GROUP_CODE = 'attribute_group_code';

    /**
     * Name for the column 'attribute_group_tab_group_code'.
     *
     * @var string
     */
    const ATTRIBUTE_GROUP_TAB_GROUP_CODE = 'attribute_group_tab_group_code';

    /**
     * Name for the column 'attribute_group_sort_order'.
     *
     * @var string
     */
    const ATTRIBUTE_GROUP_SORT_ORDER = 'attribute_group_sort_order';
}
