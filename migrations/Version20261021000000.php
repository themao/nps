<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Adapts the Symfony 2.8 / Sonata 3 schema to Sonata Media 4 and Sonata User 5. Non-destructive:
 * legacy FOSUser columns and tables are kept, they only get defaults so new rows can be inserted.
 */
final class Version20261021000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Sonata Media 4 / User 5 compatibility for the legacy schema';
    }

    public function up(Schema $schema): void
    {
        // Sonata Media 4 maps cdn_is_flushable as a non-null bool
        $this->addSql('UPDATE media__media SET cdn_is_flushable = 0 WHERE cdn_is_flushable IS NULL');
        $this->addSql('ALTER TABLE media__media MODIFY cdn_is_flushable TINYINT(1) NOT NULL DEFAULT 0');
        $this->addSql("UPDATE media__media SET provider_metadata = '[]' WHERE provider_metadata IS NULL");
        $this->addSql('ALTER TABLE media__media MODIFY content_size BIGINT DEFAULT NULL');

        // Columns Sonata User 5 no longer writes; new passwords have no salt
        $this->addSql('ALTER TABLE fos_user_user'
            .' MODIFY salt VARCHAR(255) DEFAULT NULL,'
            .' MODIFY locked TINYINT(1) NOT NULL DEFAULT 0,'
            .' MODIFY expired TINYINT(1) NOT NULL DEFAULT 0,'
            .' MODIFY credentials_expired TINYINT(1) NOT NULL DEFAULT 0');

        // Added by the seo-noindex change; may already exist where that was applied by hand
        if (!$schema->getTable('product_translations')->hasColumn('noindex')) {
            $this->addSql('ALTER TABLE product_translations ADD noindex TINYINT(1) NOT NULL DEFAULT 0');
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE media__media MODIFY cdn_is_flushable TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user_user'
            .' MODIFY locked TINYINT(1) NOT NULL,'
            .' MODIFY expired TINYINT(1) NOT NULL,'
            .' MODIFY credentials_expired TINYINT(1) NOT NULL');
    }
}
