<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130092733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F49B0F78B');
        $this->addSql('DROP INDEX IDX_C53D045F49B0F78B ON image');
        $this->addSql('ALTER TABLE image CHANGE image_cat_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F12469DE2 FOREIGN KEY (category_id) REFERENCES image_cat (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F12469DE2 ON image (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F12469DE2');
        $this->addSql('DROP INDEX IDX_C53D045F12469DE2 ON image');
        $this->addSql('ALTER TABLE image CHANGE category_id image_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F49B0F78B FOREIGN KEY (image_cat_id) REFERENCES image_cat (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F49B0F78B ON image (image_cat_id)');
    }
}
