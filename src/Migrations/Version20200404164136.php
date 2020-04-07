<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200404164136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ad (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, introduction LONGTEXT NOT NULL, contenu LONGTEXT NOT NULL, cover_image VARCHAR(255) NOT NULL, rooms INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_hotel (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_room (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, category_hotel_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_3535ED985393F63 (category_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, ad_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, INDEX IDX_C53D045F4F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, category_room_id INT NOT NULL, number INT NOT NULL, area INT NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_729F519B93CF30ED (category_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED985393F63 FOREIGN KEY (category_hotel_id) REFERENCES category_hotel (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B93CF30ED FOREIGN KEY (category_room_id) REFERENCES category_room (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4F34D596');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED985393F63');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B93CF30ED');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE category_hotel');
        $this->addSql('DROP TABLE category_room');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
    }
}