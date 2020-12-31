<?php

namespace Abit\Blog\Setup;

use Magento\Framework\Setup\SetupInterface;

class UpdateSchema implements \Magento\Framework\Setup\SchemaSetupInterface
{

    /**
     * @inheritDoc
     */
    public function getIdxName($tableName, $fields, $indexType = '')
    {
        // TODO: Implement getIdxName() method.
    }

    /**
     * @inheritDoc
     */
    public function getFkName($priTableName, $priColumnName, $refTableName, $refColumnName)
    {
        // TODO: Implement getFkName() method.
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        // TODO: Implement getConnection() method.
    }

    /**
     * @inheritDoc
     */
    public function setTable($tableName, $realTableName)
    {
        // TODO: Implement setTable() method.
    }

    /**
     * @inheritDoc
     */
    public function getTable($tableName)
    {
        // TODO: Implement getTable() method.
    }

    /**
     * @inheritDoc
     */
    public function getTablePlaceholder($tableName)
    {
        // TODO: Implement getTablePlaceholder() method.
    }

    /**
     * @inheritDoc
     */
    public function tableExists($table)
    {
        // TODO: Implement tableExists() method.
    }

    /**
     * @inheritDoc
     */
    public function run($sql)
    {
        // TODO: Implement run() method.
    }

    /**
     * @inheritDoc
     */
    public function startSetup()
    {
        // TODO: Implement startSetup() method.
    }

    /**
     * @inheritDoc
     */
    public function endSetup()
    {
        // TODO: Implement endSetup() method.
    }
}
