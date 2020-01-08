<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108100512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE familiar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_id INT DEFAULT NULL, image_head_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, competence1 VARCHAR(255) NOT NULL, competence2 VARCHAR(255) NOT NULL, competence3 VARCHAR(255) NOT NULL, talent VARCHAR(255) DEFAULT NULL, INDEX IDX_8A34CA5EA76ED395 (user_id), UNIQUE INDEX UNIQ_8A34CA5E3DA5256D (image_id), UNIQUE INDEX UNIQ_8A34CA5E610A3642 (image_head_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE familiar_cat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D298A89CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E610A3642 FOREIGN KEY (image_head_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar_cat ADD CONSTRAINT FK_D298A89CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE familiar');
        $this->addSql('DROP TABLE familiar_cat');
    }
}
