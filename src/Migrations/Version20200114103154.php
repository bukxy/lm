<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114103154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E746B3544');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EC0F5A7BB');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5ECCD75221');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EDE62FDCF');
        $this->addSql('DROP INDEX IDX_8A34CA5EC0F5A7BB ON familiar');
        $this->addSql('DROP INDEX IDX_8A34CA5ECCD75221 ON familiar');
        $this->addSql('DROP INDEX IDX_8A34CA5E746B3544 ON familiar');
        $this->addSql('DROP INDEX IDX_8A34CA5EDE62FDCF ON familiar');
        $this->addSql('ALTER TABLE familiar DROP image_c1_id, DROP image_c2_id, DROP image_c3_id, DROP image_talent_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE familiar ADD image_c1_id INT DEFAULT NULL, ADD image_c2_id INT DEFAULT NULL, ADD image_c3_id INT DEFAULT NULL, ADD image_talent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E746B3544 FOREIGN KEY (image_c3_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EC0F5A7BB FOREIGN KEY (image_talent_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5ECCD75221 FOREIGN KEY (image_c2_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EDE62FDCF FOREIGN KEY (image_c1_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5EC0F5A7BB ON familiar (image_talent_id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5ECCD75221 ON familiar (image_c2_id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5E746B3544 ON familiar (image_c3_id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5EDE62FDCF ON familiar (image_c1_id)');
    }
}
