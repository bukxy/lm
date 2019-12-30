<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191229175259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC41593DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_94EC41593DA5256D ON boost_territory (image_id)');
        $this->addSql('ALTER TABLE image ADD alt VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC41593DA5256D');
        $this->addSql('DROP INDEX IDX_94EC41593DA5256D ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory DROP image_id');
        $this->addSql('ALTER TABLE image DROP alt');
    }
}
