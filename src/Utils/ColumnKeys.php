<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\ColumnKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Utils;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class ColumnKeys extends \TechDivision\Import\Attribute\Utils\ColumnKeys
{

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
