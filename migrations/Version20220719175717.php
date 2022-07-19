<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719175717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box_products DROP quantity');
        $this->addSql('ALTER TABLE eliquid_products ADD brand_id INT DEFAULT NULL, DROP brand');
        $this->addSql('ALTER TABLE eliquid_products ADD CONSTRAINT FK_D98ED36C44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D98ED36C44F5D008 ON eliquid_products (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box_products ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE eliquid_products DROP FOREIGN KEY FK_D98ED36C44F5D008');
        $this->addSql('DROP INDEX UNIQ_D98ED36C44F5D008 ON eliquid_products');
        $this->addSql('ALTER TABLE eliquid_products ADD brand VARCHAR(255) NOT NULL, DROP brand_id');
    }
}
