<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200109090841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar ADD image_background_id INT DEFAULT NULL, ADD image_head_id INT DEFAULT NULL, DROP image, DROP image_head');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E8D338BE1 FOREIGN KEY (image_background_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E610A3642 FOREIGN KEY (image_head_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5E8D338BE1 ON familiar (image_background_id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5E610A3642 ON familiar (image_head_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E8D338BE1');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E610A3642');
        $this->addSql('DROP INDEX IDX_8A34CA5E8D338BE1 ON familiar');
        $this->addSql('DROP INDEX IDX_8A34CA5E610A3642 ON familiar');
        $this->addSql('ALTER TABLE familiar ADD image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD image_head VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP image_background_id, DROP image_head_id');
    }
}
