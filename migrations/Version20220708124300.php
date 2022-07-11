<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708124300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2246507BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket_eliquid_products (basket_id INT NOT NULL, eliquid_products_id INT NOT NULL, INDEX IDX_AD23A72F1BE1FB52 (basket_id), INDEX IDX_AD23A72F8799CF56 (eliquid_products_id), PRIMARY KEY(basket_id, eliquid_products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket_box_products (basket_id INT NOT NULL, box_products_id INT NOT NULL, INDEX IDX_AC35633D1BE1FB52 (basket_id), INDEX IDX_AC35633D4E37969B (box_products_id), PRIMARY KEY(basket_id, box_products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE box_products (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, brand VARCHAR(255) NOT NULL, date_of_creation DATETIME NOT NULL, date_of_update DATETIME NOT NULL, stock INT NOT NULL, quantity INT NOT NULL, img VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_E27D98FEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eliquid_products (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, flavor VARCHAR(255) NOT NULL, size INT NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, stock INT NOT NULL, date_of_creation DATE NOT NULL, date_of_update DATE NOT NULL, img VARCHAR(255) DEFAULT NULL, INDEX IDX_D98ED36CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE basket_eliquid_products ADD CONSTRAINT FK_AD23A72F1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_eliquid_products ADD CONSTRAINT FK_AD23A72F8799CF56 FOREIGN KEY (eliquid_products_id) REFERENCES eliquid_products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_box_products ADD CONSTRAINT FK_AC35633D1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_box_products ADD CONSTRAINT FK_AC35633D4E37969B FOREIGN KEY (box_products_id) REFERENCES box_products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE box_products ADD CONSTRAINT FK_E27D98FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eliquid_products ADD CONSTRAINT FK_D98ED36CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket_eliquid_products DROP FOREIGN KEY FK_AD23A72F1BE1FB52');
        $this->addSql('ALTER TABLE basket_box_products DROP FOREIGN KEY FK_AC35633D1BE1FB52');
        $this->addSql('ALTER TABLE basket_box_products DROP FOREIGN KEY FK_AC35633D4E37969B');
        $this->addSql('ALTER TABLE basket_eliquid_products DROP FOREIGN KEY FK_AD23A72F8799CF56');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE basket_eliquid_products');
        $this->addSql('DROP TABLE basket_box_products');
        $this->addSql('DROP TABLE box_products');
        $this->addSql('DROP TABLE eliquid_products');
    }
}
