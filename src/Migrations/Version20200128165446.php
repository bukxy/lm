<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200128165446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D649116B3934, ADD INDEX IDX_8D93D649116B3934 (activation_id)');
        $this->addSql('ALTER TABLE user_account_activation DROP FOREIGN KEY FK_4CB77428A76ED395');
        $this->addSql('DROP INDEX UNIQ_4CB77428A76ED395 ON user_account_activation');
        $this->addSql('ALTER TABLE user_account_activation DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP INDEX IDX_8D93D649116B3934, ADD UNIQUE INDEX UNIQ_8D93D649116B3934 (activation_id)');
        $this->addSql('ALTER TABLE user_account_activation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_account_activation ADD CONSTRAINT FK_4CB77428A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CB77428A76ED395 ON user_account_activation (user_id)');
    }
}
