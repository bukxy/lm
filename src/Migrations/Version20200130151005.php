<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130151005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC4159B2D16740');
        $this->addSql('DROP INDEX IDX_94EC4159B2D16740 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory CHANGE boost_territory_cat_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC415912469DE2 FOREIGN KEY (category_id) REFERENCES boost_territory_cat (id)');
        $this->addSql('CREATE INDEX IDX_94EC415912469DE2 ON boost_territory (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC415912469DE2');
        $this->addSql('DROP INDEX IDX_94EC415912469DE2 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory CHANGE category_id boost_territory_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC4159B2D16740 FOREIGN KEY (boost_territory_cat_id) REFERENCES boost_territory_cat (id)');
        $this->addSql('CREATE INDEX IDX_94EC4159B2D16740 ON boost_territory (boost_territory_cat_id)');
    }
}
