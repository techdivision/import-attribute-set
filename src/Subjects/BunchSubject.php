<?php

/**
 * TechDivision\Import\Attribute\Set\Subjects\BunchSubject
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

use TechDivision\Import\Subjects\AbstractEavSubject;
use TechDivision\Import\Attribute\Utils\RegistryKeys;
use TechDivision\Import\Attribute\Set\Utils\MemberNames;
use TechDivision\Import\Attribute\Set\Utils\ConfigurationKeys;
use TechDivision\Import\Subjects\CleanUpColumnsSubjectInterface;

/**
 * The subject implementation that handles the business logic to persist attribute sets.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class BunchSubject extends AbstractEavSubject implements BunchSubjectInterface, CleanUpColumnsSubjectInterface
{

    /**
     * The attribute set that has been processed recently.
     *
     * @var array
     */
    protected $lastAttributeSet = array();

    /**
     * The array with the available entity types.
     *
     * @var array
     */
    protected $entityTypes = array();

    /**
     * The default entity type code.
     *
     * @var string
     */
    protected $defaultEntityTypeCode;

    /**
     * The array with the entity type code + attribute set name => ID mapping.
     *
     * @var array
     */
    protected $entityTypeCodeAndAttributeSetNameIdMapping = array();

    /**
     * Intializes the previously loaded global data for exactly one bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // load the status of the actual import
        $status = $this->getRegistryProcessor()->getAttribute(RegistryKeys::STATUS);

        // load the global data we've prepared initially
        $this->entityTypes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::ENTITY_TYPES];

        // initialize the default entity type code with the value from the configuration
        $this->defaultEntityTypeCode = $this->getEntityTypeCode();

        // prepare the callbacks
        parent::setUp($serial);
    }

    /**
     * Returns the default entity type code.
     *
     * @return string The default entity type code
     */
    public function getDefaultEntityTypeCode()
    {
        return $this->defaultEntityTypeCode;
    }

    /**
     * Returns the entity type with the passed ID.
     *
     * @param integer $entityTypeId The ID of the entity type to return
     *
     * @return array|null The entity type
     */
    public function getEntityTypeByEntityTypeId($entityTypeId)
    {

        // try to find the entity type with the passed ID and return it, if available
        foreach ($this->entityTypes as $entityType) {
            if ($entityType[MemberNames::ENTITY_TYPE_ID] === $entityTypeId) {
                return $entityType;
            }
        }
    }

    /**
     * Return's the entity type code to be used.
     *
     * @return string The entity type code to be used
     */
    public function getEntityTypeCode()
    {

        // initialize the entity type
        $entityType = null;

        // query wether or not we already have an attribute set
        if ($this->lastAttributeSet) {
            $entityType = $this->getEntityTypeByEntityTypeId($this->lastAttributeSet[MemberNames::ENTITY_TYPE_ID]);
        }

        // load the entity type code from the configuration
        return  $entityType ? $entityType[MemberNames::ENTITY_TYPE_CODE] : parent::getEntityTypeCode();
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
    public function getEntityType($entityTypeCode = null)
    {

        // set the default entity type code, if non has been passed
        if ($entityTypeCode === null) {
            $entityTypeCode = $this->getDefaultEntityTypeCode();
        }

        // query whether or not, the entity type with the passed code is available
        if (isset($this->entityTypes[$entityTypeCode])) {
            return $this->entityTypes[$entityTypeCode];
        }

        // throw an exception, if not
        throw new \Exception(
            sprintf(
                'Can\'t find entity type with code %s in file %s on line %d',
                $entityTypeCode,
                $this->getFilename(),
                $this->getLineNumber()
            )
        );
    }

    /**
     * Queries whether or not the attribute set with the passed entity type code and attribute set
     * name has already been processed.
     *
     * @param string $entityTypeCode   The entity type code to check
     * @param string $attributeSetName The attribute set name to check
     *
     * @return boolean TRUE if the attribute set has been processed, else FALSE
     */
    public function hasBeenProcessed($entityTypeCode, $attributeSetName)
    {
        return isset($this->entityTypeCodeAndAttributeSetNameIdMapping[$entityTypeCode][$attributeSetName]);
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
        $this->entityTypeCodeAndAttributeSetNameIdMapping[$entityTypeCode][$attributeSetName] = $this->getLastEntityId();
    }

    /**
     * Return's the ID of the attribute set that has been created recently.
     *
     * @return integer The attribute set ID
     * @see \TechDivision\Import\Attribute\Set\Subjects\BunchSubject::getLastAttributeSetId()
     */
    public function getLastEntityId()
    {
        return $this->getLastAttributeSetId();
    }

    /**
     * Return's the ID of the attribute set that has been created recently.
     *
     * @return integer The attribute set ID
     */
    public function getLastAttributeSetId()
    {
        return $this->lastAttributeSet[MemberNames::ATTRIBUTE_SET_ID];
    }

    /**
     * Set's the attribute set that has been created recently.
     *
     * @param array $lastAttributeSet The attribute set
     *
     * @return void
     */
    public function setLastAttributeSet(array $lastAttributeSet)
    {
        $this->lastAttributeSet = $lastAttributeSet;
    }

    /**
     * Return's the attribute set that has been created recently.
     *
     * @return array The attribute set
     */
    public function getLastAttributeSet()
    {
        return $this->lastAttributeSet;
    }

    /**
     * Merge the columns from the configuration with all image type columns to define which
     * columns should be cleaned-up.
     *
     * @return array The columns that has to be cleaned-up
     */
    public function getCleanUpColumns()
    {

        // initialize the array for the columns that has to be cleaned-up
        $cleanUpColumns = array();

        // query whether or not an array has been specified in the configuration
        if ($this->getConfiguration()->hasParam(ConfigurationKeys::CLEAN_UP_EMPTY_COLUMNS)) {
            $cleanUpColumns = $this->getConfiguration()->getParam(ConfigurationKeys::CLEAN_UP_EMPTY_COLUMNS);
        }

        // return the array with the column names
        return $cleanUpColumns;
    }
}
