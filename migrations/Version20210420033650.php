<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420033650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_boutique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_boutique_boutique (categorie_boutique_id INT NOT NULL, boutique_id INT NOT NULL, INDEX IDX_71BE5D7774995DEF (categorie_boutique_id), INDEX IDX_71BE5D77AB677BE6 (boutique_id), PRIMARY KEY(categorie_boutique_id, boutique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercant (id INT AUTO_INCREMENT NOT NULL, boutique_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_ECB4268FAB677BE6 (boutique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, jour VARCHAR(255) NOT NULL, heure_debut_matin INT NOT NULL, heure_fin_matin INT NOT NULL, heure_debut_apres_midi INT NOT NULL, heure_fin_apres_midi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_boutique (horaire_id INT NOT NULL, boutique_id INT NOT NULL, INDEX IDX_25ABB4D558C54515 (horaire_id), INDEX IDX_25ABB4D5AB677BE6 (boutique_id), PRIMARY KEY(horaire_id, boutique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, boutique_id INT DEFAULT NULL, commercant_id INT DEFAULT NULL, lien VARCHAR(255) NOT NULL, INDEX IDX_C53D045FAB677BE6 (boutique_id), INDEX IDX_C53D045F83FA6DD0 (commercant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_boutique_boutique ADD CONSTRAINT FK_71BE5D7774995DEF FOREIGN KEY (categorie_boutique_id) REFERENCES categorie_boutique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_boutique_boutique ADD CONSTRAINT FK_71BE5D77AB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commercant ADD CONSTRAINT FK_ECB4268FAB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('ALTER TABLE horaire_boutique ADD CONSTRAINT FK_25ABB4D558C54515 FOREIGN KEY (horaire_id) REFERENCES horaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horaire_boutique ADD CONSTRAINT FK_25ABB4D5AB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAB677BE6 FOREIGN KEY (boutique_id) REFERENCES commercant (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F83FA6DD0 FOREIGN KEY (commercant_id) REFERENCES commercant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_boutique_boutique DROP FOREIGN KEY FK_71BE5D77AB677BE6');
        $this->addSql('ALTER TABLE commercant DROP FOREIGN KEY FK_ECB4268FAB677BE6');
        $this->addSql('ALTER TABLE horaire_boutique DROP FOREIGN KEY FK_25ABB4D5AB677BE6');
        $this->addSql('ALTER TABLE categorie_boutique_boutique DROP FOREIGN KEY FK_71BE5D7774995DEF');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAB677BE6');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F83FA6DD0');
        $this->addSql('ALTER TABLE horaire_boutique DROP FOREIGN KEY FK_25ABB4D558C54515');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE categorie_boutique');
        $this->addSql('DROP TABLE categorie_boutique_boutique');
        $this->addSql('DROP TABLE commercant');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE horaire_boutique');
        $this->addSql('DROP TABLE image');
    }
}
