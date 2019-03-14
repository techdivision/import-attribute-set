<?php

/**
 * TechDivision\Import\Attribute\Set\Repositories\EavAttributeGroupRepositoryInterface
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
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Repositories;

/**
 * Interface for a EAV attribute group data repository implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface EavAttributeGroupRepositoryInterface extends \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface
{

    /**
     * Return's the attribute group for the passed attribute set ID and attribute group code.
     *
     * @param integer $attributeSetId     The EAV attribute set ID to return the attribute group for
     * @param string  $attributeGroupCode The EAV attribute group code to load the attribute group for
     *
     * @return array|boolean The EAV attribute group for the passed attribute set ID and attribute group code
     */
    public function findOneByAttributeSetIdAndAttributeGroupCode($attributeSetId, $attributeGroupCode);
}
