<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\AttributeSetCleanUpObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Observers;

use TechDivision\Import\Attribute\Utils\ColumnKeys;

/**
 * Clean-Up after importing the EAV attribute set row.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetCleanUpObserver extends AbstractAttributeSetObserver
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

        // add the entity type code + attribute set name => entity ID mapping
        $this->addEntityTypeCodeAndAttributeSetNameIdMapping($entityTypeCode, $attributeSetName);
    }

    /**
     * Map's the passed entity type code and attribute set name to the attribute set ID that has been created recently.
     *
     * @param string $entityTypeCode   The entity type code to map
     * @param string $attributeSetName The attribute set name to map
     *
     * @return void
     */
    public function addEntityTypeCodeAndAttributeSetNameIdMapping($entityTypeCode, $attributeSetName)
    {
        $this->getSubject()->addEntityTypeCodeAndAttributeSetNameIdMapping($entityTypeCode, $attributeSetName);
    }
}
