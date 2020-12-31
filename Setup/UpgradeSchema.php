<?php

namespace Abit\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer  = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $tableName = $installer->getTable('aw_blog');
            if ($connection->tableColumnExists($tableName, 'short_content') === false) {
                $connection
                    ->addColumn(
                        $tableName,
                        'short_content',
                        [
                            'type' => Table::TYPE_TEXT,
                            'nullable' => true,
                            'comment' => 'Short Content'
                        ]
                    );
            }
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $tableName = $installer->getTable('aw_blog');

            if ($connection->tableColumnExists($tableName, 'filename') === false) {
                $connection
                    ->addColumn(
                        $tableName,
                        'filename',
                        [
                            'type' => Table::TYPE_TEXT,
                            'nullable' => true,
                            'comment' => 'Featured Image'
                        ]
                    );
            }
            if ($connection->tableColumnExists($tableName, 'featured') === false) {
                $connection
                    ->addColumn(
                        $tableName,
                        'featured',
                        [
                            'type' => Table::TYPE_INTEGER,
                            'nullable' => true,
                            'comment' => 'Featured Post'
                        ]
                    );
            }
            $connection->addIndex($tableName, $installer->getIdxName('aw_blog', ['post_id']), ['post_id']);
            $connection->addIndex($tableName, $installer->getIdxName('aw_blog', ['title'], AdapterInterface::INDEX_TYPE_FULLTEXT), ['title'], AdapterInterface::INDEX_TYPE_FULLTEXT);
        }

        $installer->endSetup();
    }
}
