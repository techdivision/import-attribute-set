<?php

/**
 * TechDivision\Import\Attribute\Set\Subjects\BunchSubjectInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Set\Subjects;

/**
 * The interface for subject implementations that handles the business logic to persist attribute sets.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
interface BunchSubjectInterface
{

    /**
     * Returns the default entity type code.
     *
     * @return string The default entity type code
     */
    public function getDefaultEntityTypeCode();

    /**
     * Return's the entity type for the passed code, of if no entity type code has
     * been passed, the default one from the configuration will be used.
     *
     * @param string|null $entityTypeCode The entity type code
     *
     * @return array The requested entity type
     * @throws \Exception Is thrown, if the entity type with the passed code is not available
     */
    public function getEntityType($entityTypeCode = null);

    /**
     * Queries whether or not the attribute set with the passed entity type code and attribute set
     * name has already been processed.
     *
     * @param string $entityTypeCode   The entity type code to check
     * @param string $attributeSetName The attribute set name to check
     *
     * @return boolean TRUE if the attribute set has been processed, else FALSE
     */
    public function hasBeenProcessed($entityTypeCode, $attributeSetName);

    /**
     * Map's the passed entity type code and attribute set name to the attribute set ID that has been created recently.
     *
     * @param string $entityTypeCode   The entity type code to map
     * @param string $attributeSetName The attribute set name to map
     *
     * @return void
     */
    public function addEntityTypeCodeAndAttributeSetNameIdMapping($entityTypeCode, $attributeSetName);

    /**
     * Return's the ID of the attribute set that has been created recently.
     *
     * @return integer The attribute set ID
     * @see \TechDivision\Import\Attribute\Set\Subjects\BunchSubject::getLastAttributeSetId()
     */
    public function getLastEntityId();

    /**
     * Return's the ID of the attribute set that has been created recently.
     *
     * @return integer The attribute set ID
     */
    public function getLastAttributeSetId();

    /**
     * Set's the attribute set that has been created recently.
     *
     * @param array $lastAttributeSet The attribute set
     *
     * @return void
     */
    public function setLastAttributeSet(array $lastAttributeSet);

    /**
     * Return's the attribute set that has been created recently.
     *
     * @return array The attribute set
     */
    public function getLastAttributeSet();
}
