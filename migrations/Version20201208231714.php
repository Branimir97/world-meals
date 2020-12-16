<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208231714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_meal (ingredient_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_C0A73E0A933FE08C (ingredient_id), INDEX IDX_C0A73E0A639666D6 (meal_id), PRIMARY KEY(ingredient_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_meal ADD CONSTRAINT FK_C0A73E0A933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_meal ADD CONSTRAINT FK_C0A73E0A639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_meal DROP FOREIGN KEY FK_C0A73E0A933FE08C');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_meal');
    }
}
