<?php

/**
 * TechDivision\Import\Attribute\Set\Utils\MemberNames
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
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class MemberNames extends \TechDivision\Import\Attribute\Utils\MemberNames
{

    /**
     * Name for the member 'default_id'.
     *
     * @var string
     */
    const DEFAULT_ID = 'default_id';

    /**
     * Name for the member 'attribute_group_name'.
     *
     * @var string
     */
    const ATTRIBUTE_GROUP_NAME = 'attribute_group_name';

    /**
     * Name for the member 'attribute_group_code'.
     *
     * @var string
     */
    const ATTRIBUTE_GROUP_CODE = 'attribute_group_code';

    /**
     * Name for the member 'tab_group_code'.
     *
     * @var string
     */
    const TAB_GROUP_CODE = 'tab_group_code';
}
