<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\ClearAttributeObserver
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

namespace TechDivision\Import\Attribute\Set\Observers;

use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;

/**
 * Observer that removes the EAV attribute with the code found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class ClearAttributeSetObserver extends AbstractAttributeSetObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // load the entity type code and attribute set name
        $entityTypeCode = $this->getValue(ColumnKeys::ENTITY_TYPE_CODE);
        $attributeSetName = $this->getValue(ColumnKeys::ATTRIBUTE_SET_NAME);

        // query whether or not we've found a line with a attribute group definition
        if ($entityTypeCode === null && $attributeSetName === null) {
            return;
        }

        // query whether or not, we've found a new entity type code/attribute set name => means we've found a new attribute set
        if ($this->hasBeenProcessed($entityTypeCode, $attributeSetName)) {
            return;
        }

        // try to load the EAV attribute set with the given entity type code and attribute set name found in the CSV file
        $attributeSet = $this->loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName);

        // delete the EAV attribute set
        $this->deleteAttributeSet(array(MemberNames::ATTRIBUTE_SET_ID_ID => $attributeSet[MemberNames::ATTRIBUTE_SET_ID]));

        // temporary persist the ID of the deleted attribute set
        $this->setLastAttributeId($attributeSet[MemberNames::ATTRIBUTE_SET_ID]);
    }

    /**
     * Load's and return's the EAV attribute set with the passed entity type code and attribute set name.
     *
     * @param string $entityTypeCode   The entity type code of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    protected function loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName);
    }

    /**
     * Delete's the EAV attribute set with the passed attributes.
     *
     * @param array       $row  The attributes of the EAV attribute set to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteAttributeSet($row, $name = null)
    {
        $this->getAttributeSetBunchProcessor()->deleteAttributeSet($row, $name);
    }
}
