<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123112723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE familiar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_background_id INT DEFAULT NULL, image_head_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, competence1 VARCHAR(255) DEFAULT NULL, competence2 VARCHAR(255) DEFAULT NULL, competence3 VARCHAR(255) DEFAULT NULL, competence1_desc LONGTEXT DEFAULT NULL, competence2_desc LONGTEXT NOT NULL, competence3_desc LONGTEXT DEFAULT NULL, talent VARCHAR(255) DEFAULT NULL, talent_desc LONGTEXT DEFAULT NULL, INDEX IDX_8A34CA5EA76ED395 (user_id), INDEX IDX_8A34CA5E8D338BE1 (image_background_id), INDEX IDX_8A34CA5E610A3642 (image_head_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E8D338BE1 FOREIGN KEY (image_background_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E610A3642 FOREIGN KEY (image_head_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE familiar');
    }
}
