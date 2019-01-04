<?php

/**
 * TechDivision\Import\Attribute\Set\Subjects\BunchSubject
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

namespace TechDivision\Import\Attribute\Set\Subjects;

use TechDivision\Import\Attribute\Utils\RegistryKeys;
use TechDivision\Import\Subjects\AbstractEavSubject;

/**
 * The subject implementation that handles the business logic to persist attribute sets.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class BunchSubject extends AbstractEavSubject implements BunchSubjectInterface
{

    /**
     * The ID of the attribute set that has been created recently.
     *
     * @var integer
     */
    protected $lastAttributeSetId;

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
        $status = $this->getRegistryProcessor()->getAttribute($serial);

        // load the global data we've prepared initially
        $this->entityTypes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::ENTITY_TYPES];

        // initialize the default entity type code with the value from the configuration
        $this->defaultEntityTypeCode = $this->entityTypeCodeMappings[$this->getConfiguration()->getConfiguration()->getEntityTypeCode()];

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
     * @see \TechDivision\Import\Attribute\Set\Subjects\BunchSubject::getLastAttributeId()
     */
    public function getLastEntityId()
    {
        return $this->getLastAttributeSetId();
    }

    /**
     * Set's the ID of the attribute set that has been created recently.
     *
     * @param integer $lastAttributeSetId The attribute set ID
     *
     * @return void
     */
    public function setLastAttributeSetId($lastAttributeSetId)
    {
        $this->lastAttributeSetId = $lastAttributeSetId;
    }

    /**
     * Return's the ID of the attribute set that has been created recently.
     *
     * @return integer The attribute set ID
     */
    public function getLastAttributeSetId()
    {
        return $this->lastAttributeSetId;
    }
}
