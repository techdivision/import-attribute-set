<?php

/**
 * TechDivision\Import\Attribute\Set\Repositories\EntityAttributeRepositoryInterface
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

namespace TechDivision\Import\Attribute\Set\Repositories;

/**
 * Interface for repository implementations to load EAV entity attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
interface EntityAttributeRepositoryInterface extends \TechDivision\Import\Attribute\Repositories\EntityAttributeRepositoryInterface
{

    /**
     * Returns the EAV entity attributes for the attribute group with the passed ID.
     *
     * @param integer $attributeGroupId The attribute group ID to load the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed attribute group ID
     */
    public function findAllByAttributeGroupId($attributeGroupId);

    /**
     * Returns the EAV entity attributes for the entity type ID and attribute set with the passed name.
     *
     * @param integer $entityTypeId     The entity type ID to load the EAV entity attributes for
     * @param string  $attributeSetName The attribute set name to return the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed entity type ID and attribute set name
     */
    public function findAllByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName);
}
