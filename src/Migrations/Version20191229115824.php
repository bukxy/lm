<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191229115824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC4159CC7F4682');
        $this->addSql('DROP INDEX IDX_94EC4159CC7F4682 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory CHANGE b_tcategory_id bt_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC4159F16BCD22 FOREIGN KEY (bt_category_id) REFERENCES btcategory (id)');
        $this->addSql('CREATE INDEX IDX_94EC4159F16BCD22 ON boost_territory (bt_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC4159F16BCD22');
        $this->addSql('DROP INDEX IDX_94EC4159F16BCD22 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory CHANGE bt_category_id b_tcategory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC4159CC7F4682 FOREIGN KEY (b_tcategory_id) REFERENCES btcategory (id)');
        $this->addSql('CREATE INDEX IDX_94EC4159CC7F4682 ON boost_territory (b_tcategory_id)');
    }
}
