<?php

namespace Abit\Blog\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * @inheritDoc
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $connection = $installer->getConnection();

        if (!$installer->tableExists('aw_blog')) {
            $table = $connection->newTable($installer->getTable('aw_blog'))
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    11,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'Post Id'
                )
                ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false], 'Title')
                ->addColumn('post_content', Table::TYPE_TEXT, ['nullable' => false], 'Post Content')
                ->addColumn('status', Table::TYPE_SMALLINT, 6, ['nullable' => false], 'Status')
                ->addColumn('identifier', Table::TYPE_TEXT, 255, ['nullable' => false], 'Identifier')
                ->addColumn('user', Table::TYPE_TEXT, 255, [], 'User')
                ->addColumn('update_user', Table::TYPE_TEXT, 255, ['nullable' => false], 'Update User')
                ->addColumn('meta_keywords', Table::TYPE_TEXT, ['nullable' => false], 'Meta Keywords')
                ->addColumn('meta_description', Table::TYPE_TEXT, ['nullable' => false], 'Meta Description')
                ->addColumn('comments', Table::TYPE_SMALLINT, 11, ['nullable' => false], 'Comments')
                ->addColumn(
                    'created_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['default' => Table::TIMESTAMP_INIT],
                    'Created Time'
                )
                ->addColumn(
                    'update_time]',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['default' => Table::TIMESTAMP_INIT],
                    'Update Time'
                )
                ->setComment('Post Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_comment')) {
            $table = $connection->newTable($installer->getTable('aw_blog_comment'))
                ->addColumn(
                    'comment_id',
                    Table::TYPE_INTEGER,
                    11,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'Comment Id'
                )
                ->addColumn(
                    'post_id',
                    Table::TYPE_SMALLINT,
                    11,
                    ['nullable' => false, 'unsigned' => true],
                    'Post Id'
                )
                ->addColumn('status', Table::TYPE_SMALLINT, 6, ['nullable' => false], 'Status')
                ->addColumn('comment', Table::TYPE_TEXT, ['nullable' => false], 'Comment')
                ->addColumn('user', Table::TYPE_TEXT, 255, ['nullable' => false], 'User')
                ->addColumn('email', Table::TYPE_TEXT, 255, [], 'Email')
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Comment Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_cat')) {
            $table = $connection->newTable($installer->getTable('aw_blog_cat'))
                ->addColumn(
                    'cat_id',
                    Table::TYPE_INTEGER,
                    11,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'Comment Id'
                )
                ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false], 'Title')
                ->addColumn('identifier', Table::TYPE_TEXT, 255, ['nullable' => false], 'Identifier')
                ->addColumn('sort_order', Table::TYPE_SMALLINT, 6, ['nullable' => false], 'Sort Order')
                ->addColumn('meta_keywords', Table::TYPE_TEXT, [], 'Meta Keywords')
                ->addColumn('meta_description', Table::TYPE_TEXT, [], 'Meta Description')
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Cat Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_store')) {
            $table = $connection->newTable($installer->getTable('aw_blog_store'))
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    6,
                    ['unsigned' => true],
                    'Post Id'
                )
                 ->addColumn(
                     'store_id',
                     Table::TYPE_INTEGER,
                     6,
                     ['unsigned' => true],
                     'Store Id'
                 )

                ->setComment('Store Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_cat_store')) {
            $table = $connection->newTable($installer->getTable('aw_blog_cat_store'))
                ->addColumn(
                    'cat_id',
                    Table::TYPE_INTEGER,
                    6,
                    ['unsigned' => true],
                    'Cat Id'
                )
                 ->addColumn(
                     'store_id',
                     Table::TYPE_INTEGER,
                     6,
                     ['unsigned' => true],
                     'Store Id'
                 )

                ->setComment('Cat-Store Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_post_cat')) {
            $table = $connection->newTable($installer->getTable('aw_blog_post_cat'))
                ->addColumn(
                    'cat_id',
                    Table::TYPE_INTEGER,
                    6,
                    ['unsigned' => true],
                    'Cat Id'
                )
                 ->addColumn(
                     'post_id',
                     Table::TYPE_INTEGER,
                     6,
                     ['unsigned' => true],
                     'Post Id'
                 )

                ->setComment('Post-Cat Table');

            $connection->createTable($table);
        }
        if (!$installer->tableExists('aw_blog_tags')) {
            $table = $connection->newTable($installer->getTable('aw_blog_tags'))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    6,
                    ['unsigned' => true],
                    'Tag Id'
                )
                ->addColumn('tag', Table::TYPE_TEXT, 255, ['nullable' => false], 'Tag')
                ->addColumn('tag_count', Table::TYPE_INTEGER, 11, ['nullable' => false], 'Tag Count')
                ->addColumn('store_id', Table::TYPE_SMALLINT, 4, ['nullable' => false], 'Store id')
                ->addIndex($installer->getIdxName('aw_blog_tags', ['tag']), 'tag')
                ->addIndex($installer->getIdxName('aw_blog_tags', ['tag_count']), 'tag_count')
                ->addIndex($installer->getIdxName('aw_blog_tags', ['store_id']), 'store_id')
                ->setComment('Store Table');

            $connection->createTable($table);
        }
        $installer->endSetup();
        // TODO: Implement install() method.
    }
}
