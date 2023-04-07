<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407142345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(50) NOT NULL, pseudo VARCHAR(50) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe CHANGE name name VARCHAR(50) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE create_at create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_23D2FF14943GE18D');
        $this->addSql('ALTER TABLE recipe_ingredient ADD PRIMARY KEY (recipe_id, ingredient_id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient RENAME INDEX fk_22d1fe1359d8a214 TO IDX_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient RENAME INDEX fk_23d2ff1450d9a315 TO IDX_22D1FE13933FE08C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE recipe CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_520_ci`, CHANGE description description TEXT NOT NULL COLLATE `utf8mb4_unicode_520_ci`, CHANGE create_at create_at DATETIME NOT NULL COMMENT \'	(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'	(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('DROP INDEX `primary` ON recipe_ingredient');
        $this->addSql('ALTER TABLE recipe_ingredient RENAME INDEX idx_22d1fe1359d8a214 TO FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient RENAME INDEX idx_22d1fe13933fe08c TO FK_23D2FF1450D9A315');
    }
}
