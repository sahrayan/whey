<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103004022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choose (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contain (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4BEFF7C8CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flavor_ingredient (flavor_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_E8A400E8FDDA6450 (flavor_id), INDEX IDX_E8A400E8933FE08C (ingredient_id), PRIMARY KEY(flavor_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contain ADD CONSTRAINT FK_4BEFF7C8CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE flavor_ingredient ADD CONSTRAINT FK_E8A400E8FDDA6450 FOREIGN KEY (flavor_id) REFERENCES flavor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flavor_ingredient ADD CONSTRAINT FK_E8A400E8933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flavor ADD choose_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flavor ADD CONSTRAINT FK_BC2534542F3F124E FOREIGN KEY (choose_id) REFERENCES choose (id)');
        $this->addSql('CREATE INDEX IDX_BC2534542F3F124E ON flavor (choose_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE product ADD choose_id INT DEFAULT NULL, ADD category_id INT NOT NULL, ADD contain_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2F3F124E FOREIGN KEY (choose_id) REFERENCES choose (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD92B58A10 FOREIGN KEY (contain_id) REFERENCES contain (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD2F3F124E ON product (choose_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD92B58A10 ON product (contain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flavor DROP FOREIGN KEY FK_BC2534542F3F124E');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2F3F124E');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD92B58A10');
        $this->addSql('ALTER TABLE contain DROP FOREIGN KEY FK_4BEFF7C8CFFE9AD6');
        $this->addSql('ALTER TABLE flavor_ingredient DROP FOREIGN KEY FK_E8A400E8FDDA6450');
        $this->addSql('ALTER TABLE flavor_ingredient DROP FOREIGN KEY FK_E8A400E8933FE08C');
        $this->addSql('DROP TABLE choose');
        $this->addSql('DROP TABLE contain');
        $this->addSql('DROP TABLE flavor_ingredient');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD2F3F124E ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD92B58A10 ON product');
        $this->addSql('ALTER TABLE product DROP choose_id, DROP category_id, DROP contain_id');
        $this->addSql('DROP INDEX IDX_BC2534542F3F124E ON flavor');
        $this->addSql('ALTER TABLE flavor DROP choose_id');
    }
}
