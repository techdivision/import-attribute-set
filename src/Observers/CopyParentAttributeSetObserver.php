<?php

/**
 * TechDivision\Import\Attribute\Set\Observers\CopyParentAttributeSetObserver
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

use TechDivision\Import\Attribute\Set\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;
use TechDivision\Import\Dbal\Utils\EntityStatus;
use TechDivision\Import\Attribute\Set\Utils\ConfigurationKeys;

/**
 * Observer that copies the EAV attribute groups and attribute relations from the parent.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class CopyParentAttributeSetObserver extends AbstractAttributeSetObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {

        // load the last attribute set
        $attributeSet = $this->getLastAttributeSet();

        // query whether or not the a given attribute set has to be extended
        if ($this->shouldCopy()) {
            // load the attribute set the new one is based on
            $basedOn = $this->loadAttributeSetByEntityTypeCodeAndAttributeSetName(
                $this->getValue(ColumnKeys::ENTITY_TYPE_CODE),
                $this->getValue(ColumnKeys::BASED_ON)
            );

            // load the attribute groups of the attribute set the new one should be based on
            $attributeGroupsBasedOn = $this->loadAttributeGroupsByAttributeSetId($basedOn[MemberNames::ATTRIBUTE_SET_ID]);

            // copy the attribute groups from the based on
            foreach ($attributeGroupsBasedOn as $attributeGroupBasedOn) {
                // create the attribute group
                $attributeGroupId = $this->persistAttributeGroup(
                    $attributeGroup = $this->initializeAttributeForAttributeGroup(
                        $this->prepareAttributesForAttributeGroup($attributeSet, $attributeGroupBasedOn)
                    )
                );

                // set the new attribute group ID
                $attributeGroup[MemberNames::ATTRIBUTE_GROUP_ID] = $attributeGroupId;

                // load the entity attributes of the attribute group
                $entityAttributes = $this->loadEntityAttributesByAttributeGroupId($attributeGroupBasedOn[MemberNames::ATTRIBUTE_GROUP_ID]);

                // copy the attribute group => attribute relation
                foreach ($entityAttributes as $entityAttribute) {
                    $this->persistEntityAttribute(
                        $this->initializeAttributeForEntityAttribute(
                            $this->prepareAttributesForEntityAttribute($attributeSet, $attributeGroup, $entityAttribute)
                        )
                    );
                }
            }
        }
    }

    /**
     * Queries whether or not the attribute groups and attribute relations of the attribute
     * set the actual one is based on, should be copied or not.
     *
     * They SHOULD be copied if the attribute set is new and has been created recently or
     * if the attribute set already exists and the `copy-parent-on-update` flag parameter
     * has been set to TRUE.
     *
     * @return boolean TRUE if the attribute groups and attribute relations should be copied, else FALSE
     */
    protected function shouldCopy()
    {

        // load the last attribute set
        $attributeSet = $this->getLastAttributeSet();

        // query whether or not the a given attribute set has to be extended
        return $this->hasValue(ColumnKeys::BASED_ON) && (
            $attributeSet[EntityStatus::MEMBER_NAME] === EntityStatus::STATUS_CREATE || (
                $attributeSet[EntityStatus::MEMBER_NAME] === EntityStatus::STATUS_UPDATE && $this->shouldCopyParentOnUpdate())
            );
    }

    /**
     * Queries whether or not the configuration param `copy-parent-on-update` has been set,
     * if yes it returns the value.
     *
     * @return boolean TRUE if the param is set and the value is TRUE, else FALSE
     */
    protected function shouldCopyParentOnUpdate()
    {

        // load the subject's configuration
        $configuration = $this->getSubject()->getConfiguration();

        // return the configuration value
        if ($configuration->hasParam(ConfigurationKeys::COPY_PARENT_ON_UPDATE)) {
            return $configuration->getParam(ConfigurationKeys::COPY_PARENT_ON_UPDATE);
        }

        // return FALSE
        return false;
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @param array $attributeSet    The attribute set with the data used to prepare the entity attribute
     * @param array $attributeGroup  The attribute group with the data used to prepare the entity attribute
     * @param array $entityAttribute The entity attribute with the data used to prepare the entity attribute
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributesForEntityAttribute(array $attributeSet, array $attributeGroup, array $entityAttribute)
    {

        // return the prepared product
        return $this->initializeEntity(
            array(
                MemberNames::ATTRIBUTE_SET_ID   => $attributeSet[MemberNames::ATTRIBUTE_SET_ID],
                MemberNames::ATTRIBUTE_GROUP_ID => $attributeGroup[MemberNames::ATTRIBUTE_GROUP_ID],
                MemberNames::ATTRIBUTE_ID       => $entityAttribute[MemberNames::ATTRIBUTE_ID],
                MemberNames::ENTITY_TYPE_ID     => $entityAttribute[MemberNames::ENTITY_TYPE_ID],
                MemberNames::SORT_ORDER         => $entityAttribute[MemberNames::SORT_ORDER]
            )
        );
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @param array $attributeSet   The attribute set with the data used to prepare the attribute group
     * @param array $attributeGroup The attribute group with the data used to prepare the attribute group
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributesForAttributeGroup(array $attributeSet, array $attributeGroup)
    {

        // return the prepared product
        return $this->initializeEntity(
            array(
                MemberNames::ATTRIBUTE_SET_ID     => $attributeSet[MemberNames::ATTRIBUTE_SET_ID],
                MemberNames::ATTRIBUTE_GROUP_NAME => $attributeGroup[MemberNames::ATTRIBUTE_GROUP_NAME],
                MemberNames::SORT_ORDER           => $attributeGroup[MemberNames::SORT_ORDER],
                MemberNames::DEFAULT_ID           => $attributeGroup[MemberNames::DEFAULT_ID],
                MemberNames::ATTRIBUTE_GROUP_CODE => $attributeGroup[MemberNames::ATTRIBUTE_GROUP_CODE],
                MemberNames::TAB_GROUP_CODE       => $attributeGroup[MemberNames::TAB_GROUP_CODE]
            )
        );
    }

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttributeForAttributeGroup(array $attr)
    {
        return $attr;
    }

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttributeForEntityAttribute(array $attr)
    {
        return $attr;
    }

    /**
     * Return's the entity type for the passed code, of if no entity type code has
     * been passed, the default one from the configuration will be used.
     *
     * @param string|null $entityTypeCode The entity type code
     *
     * @return array The requested entity type
     * @throws \Exception Is thrown, if the entity type with the passed code is not available
     */
    protected function getEntityType($entityTypeCode = null)
    {
        return $this->getSubject()->getEntityType($entityTypeCode);
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
     * Return's the attribute groups for the passed attribute set ID, whereas the array
     * is prepared with the attribute group names as keys.
     *
     * @param mixed $attributeSetId The EAV attribute set ID to return the attribute groups for
     *
     * @return array|boolean The EAV attribute groups for the passed attribute ID
     */
    protected function loadAttributeGroupsByAttributeSetId($attributeSetId)
    {
        return $this->getAttributeSetBunchProcessor()->loadAttributeGroupsByAttributeSetId($attributeSetId);
    }

    /**
     * Returns the EAV entity attributes for the attribute group with the passed ID.
     *
     * @param integer $attributeGroupId The attribute group ID to load the EAV entity attributes for
     *
     * @return array|null The EAV attributes with for the passed attribute group ID
     */
    protected function loadEntityAttributesByAttributeGroupId($attributeGroupId)
    {
        return $this->getAttributeSetBunchProcessor()->loadEntityAttributesByAttributeGroupId($attributeGroupId);
    }

    /**
     * Persist the passed attribute group.
     *
     * @param array $attributeGroup The attribute group to persist
     *
     * @return void
     */
    protected function persistAttributeGroup(array $attributeGroup)
    {
        return $this->getAttributeSetBunchProcessor()->persistAttributeGroup($attributeGroup);
    }

    /**
     * Persist the passed entity attribute.
     *
     * @param array $entityAttribute The entity attribute to persist
     *
     * @return void
     */
    protected function persistEntityAttribute(array $entityAttribute)
    {
        return $this->getAttributeSetBunchProcessor()->persistEntityAttribute($entityAttribute);
    }
}
