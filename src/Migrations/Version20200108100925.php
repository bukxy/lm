<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108100925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E3DA5256D');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E610A3642');
        $this->addSql('DROP INDEX UNIQ_8A34CA5E610A3642 ON familiar');
        $this->addSql('DROP INDEX UNIQ_8A34CA5E3DA5256D ON familiar');
        $this->addSql('ALTER TABLE familiar ADD image VARCHAR(255) DEFAULT NULL, ADD image_head VARCHAR(255) DEFAULT NULL, DROP image_id, DROP image_head_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar ADD image_id INT DEFAULT NULL, ADD image_head_id INT DEFAULT NULL, DROP image, DROP image_head');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E610A3642 FOREIGN KEY (image_head_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A34CA5E610A3642 ON familiar (image_head_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A34CA5E3DA5256D ON familiar (image_id)');
    }
}
