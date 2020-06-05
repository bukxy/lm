<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200605143113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hunt (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, hunt_image_id INT DEFAULT NULL, hunt_head_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_21FA5947A76ED395 (user_id), INDEX IDX_21FA5947EF01552A (hunt_image_id), INDEX IDX_21FA59475DEFDBB8 (hunt_head_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hunt ADD CONSTRAINT FK_21FA5947A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hunt ADD CONSTRAINT FK_21FA5947EF01552A FOREIGN KEY (hunt_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE hunt ADD CONSTRAINT FK_21FA59475DEFDBB8 FOREIGN KEY (hunt_head_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE hunt');
    }
}
