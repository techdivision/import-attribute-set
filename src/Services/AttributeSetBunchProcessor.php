<?php

/**
 * TechDivision\Import\Attribute\Services\AttributeSetBunchProcessor
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

namespace TechDivision\Import\Attribute\Set\Services;

use TechDivision\Import\Connection\ConnectionInterface;
use TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface;
use TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface;
use TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface;
use TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface;

/**
 * The attribute set bunch processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute-set
 * @link      http://www.techdivision.com
 */
class AttributeSetBunchProcessor implements AttributeSetBunchProcessorInterface
{

    /**
     * A connection to use.
     *
     * @var \TechDivision\Import\Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * The EAV attribute set repository instance.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface
     */
    protected $eavAttributeSetRepository;

    /**
     * The EAV attribute set repository instance.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface
     */
    protected $eavAttributeGroupRepository;

    /**
     * The attribute set action instance.
     *
     * @var \TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface
     */
    protected $eavAttributeSetAction;

    /**
     * The attribute group action instance.
     *
     * @var \TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface
     */
    protected $eavAttributeGroupAction;

    /**
     * Initialize the processor with the necessary repository and action instances.
     *
     * @param \TechDivision\Import\Connection\ConnectionInterface                         $connection                  The connection to use
     * @param \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface        $eavAttributeSetRepository   The EAV attribute set repository instance
     * @param \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface      $eavAttributeGroupRepository The EAV attribute group repository instance
     * @param \TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface   $eavAttributeSetAction       The EAV attribute set action instance
     * @param \TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface $eavAttributeGroupAction     The EAV attribute gropu action instance
     */
    public function __construct(
        ConnectionInterface $connection,
        EavAttributeSetRepositoryInterface $eavAttributeSetRepository,
        EavAttributeGroupRepositoryInterface $eavAttributeGroupRepository,
        EavAttributeSetActionInterface $eavAttributeSetAction,
        EavAttributeGroupActionInterface $eavAttributeGroupAction
    ) {
        $this->setConnection($connection);
        $this->setEavAttributeSetRepository($eavAttributeSetRepository);
        $this->setEavAttributeGroupRepository($eavAttributeGroupRepository);
        $this->setEavAttributeSetAction($eavAttributeSetAction);
        $this->setEavAttributeGroupAction($eavAttributeGroupAction);
    }

    /**
     * Set's the passed connection.
     *
     * @param \TechDivision\Import\Connection\ConnectionInterface $connection The connection to set
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return \TechDivision\Import\Connection\ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling ProductProcessor::commit().
     * Calling ProductProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * ProductProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by ProductProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the attribute set repository instance.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface $eavAttributeSetRepository The attribute set repository instance
     *
     * @return void
     */
    public function setEavAttributeSetRepository(EavAttributeSetRepositoryInterface $eavAttributeSetRepository)
    {
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
    }

    /**
     * Return's the attribute set repository instance.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeSetRepositoryInterface The attribute set repository instance
     */
    public function getEavAttributeSetRepository()
    {
        return $this->eavAttributeSetRepository;
    }

    /**
     * Set's the attribute group repository instance.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface $eavAttributeGroupRepository The attribute group repository instance
     *
     * @return void
     */
    public function setEavAttributeGroupRepository(EavAttributeGroupRepositoryInterface $eavAttributeGroupRepository)
    {
        $this->eavAttributeGroupRepository = $eavAttributeGroupRepository;
    }

    /**
     * Return's the attribute group repository instance.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeGroupRepositoryInterface The attribute group repository instance
     */
    public function getEavAttributeGroupRepository()
    {
        return $this->eavAttributeGroupRepository;
    }

    /**
     * Set's the EAV attribute set action instance.
     *
     * @param \TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface $eavAttributeSetAction The attribute set action instance
     *
     * @return void
     */
    public function setEavAttributeSetAction(EavAttributeSetActionInterface $eavAttributeSetAction)
    {
        $this->eavAttributeSetAction = $eavAttributeSetAction;
    }

    /**
     * Return's the attribute set action instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Actions\EavAttributeSetActionInterface The attribute set action instance
     */
    public function getEavAttributeSetAction()
    {
        return $this->eavAttributeSetAction;
    }

    /**
     * Set's the EAV attribute group action instance.
     *
     * @param \TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface $eavAttributeGroupAction The attribute gropu action instance
     *
     * @return void
     */
    public function setEavAttributeGroupAction(EavAttributeGroupActionInterface $eavAttributeGroupAction)
    {
        $this->eavAttributeGroupAction = $eavAttributeGroupAction;
    }

    /**
     * Return's the attribute group action instance.
     *
     * @return \TechDivision\Import\Attribute\Set\Actions\EavAttributeGroupActionInterface The attribute group action instance
     */
    public function getEavAttributeGroupAction()
    {
        return $this->eavAttributeGroupAction;
    }

    /**
     * Load's and return's the EAV attribute set with the passed entity type code and attribute set name.
     *
     * @param string $entityTypeCode   The entity type code of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    public function loadAttributeSetByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName)
    {
        return $this->getEavAttributeSetRepository()->findOneByEntityTypeCodeAndAttributeSetName($entityTypeCode, $attributeSetName);
    }

    /**
     * Load's and return's the EAV attribute set with the passed entity type ID and attribute set name.
     *
     * @param string $entityTypeId     The entity type ID of the EAV attribute set to load
     * @param string $attributeSetName The attribute set name of the EAV attribute set to return
     *
     * @return array The EAV attribute set
     */
    public function loadAttributeSetByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName)
    {
        return $this->getEavAttributeSetRepository()->findOneByEntityTypeIdAndAttributeSetName($entityTypeId, $attributeSetName);
    }

    /**
     * Return's the EAV attribute group with the passed entity type code, attribute set and attribute group name.
     *
     * @param string $entityTypeCode     The entity type code of the EAV attribute group to return
     * @param string $attributeSetName   The attribute set name of the EAV attribute group to return
     * @param string $attributeGroupName The attribute group name of the EAV attribute group to return
     *
     * @return array The EAV attribute group
     */
    public function loadAttributeGroupByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName)
    {
        return $this->getEavAttributeGroupRepository()->findOneByEntityTypeCodeAndAttributeSetNameAndAttributeGroupName($entityTypeCode, $attributeSetName, $attributeGroupName);
    }

    /**
     * Persist's the passed EAV attribute set data and return's the ID.
     *
     * @param array       $attributeSet The attribute set data to persist
     * @param string|null $name         The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted attribute set
     */
    public function persistAttributeSet(array $attributeSet, $name = null)
    {
        return $this->getEavAttributeSetAction()->persist($attributeSet);
    }

    /**
     * Persist the passed EAV attribute group.
     *
     * @param array       $attributeGroup The attribute group to persist
     * @param string|null $name           The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistAttributeGroup(array $attributeGroup, $name = null)
    {
        $this->getEavAttributeGroupAction()->persist($attributeGroup);
    }

    /**
     * Delete's the EAV attribute set with the passed attributes.
     *
     * @param array       $row  The attributes of the EAV attribute group to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteAttributeSet($row, $name = null)
    {
        $this->getEavAttributeSetAction()->delete($row, $name);
    }
}
