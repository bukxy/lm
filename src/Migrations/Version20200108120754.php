<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108120754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar ADD familiar_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EA42A9E1 FOREIGN KEY (familiar_cat_id) REFERENCES familiar_cat (id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5EA42A9E1 ON familiar (familiar_cat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EA42A9E1');
        $this->addSql('DROP INDEX IDX_8A34CA5EA42A9E1 ON familiar');
        $this->addSql('ALTER TABLE familiar DROP familiar_cat_id');
    }
}
