<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220100000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (number_plate VARCHAR(255) NOT NULL, model_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, INDEX IDX_773DE69D7975B7E7 (model_id), INDEX IDX_773DE69D9395C3F3 (customer_id), PRIMARY KEY(number_plate)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engineer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, wage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_job (id INT AUTO_INCREMENT NOT NULL, amount_of_time_slots INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_jobs_spare_parts (maintenance_job_id INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_2D0AA0B211D78A0 (maintenance_job_id), INDEX IDX_2D0AA0B49B7A72 (spare_part_id), PRIMARY KEY(maintenance_job_id, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scheduled_maintenance_job (id INT AUTO_INCREMENT NOT NULL, car_number_plate VARCHAR(255) DEFAULT NULL, engineer_id INT DEFAULT NULL, job_id INT DEFAULT NULL, time_slot_id INT DEFAULT NULL, INDEX IDX_DFA05AD5930EEB7B (car_number_plate), INDEX IDX_DFA05AD5F8D8CDF1 (engineer_id), INDEX IDX_DFA05AD5BE04EA9 (job_id), INDEX IDX_DFA05AD5D62B0FA (time_slot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spare_part (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price_in_cents INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE models_spare_parts (spare_part_id INT NOT NULL, model_id INT NOT NULL, INDEX IDX_AFC669549B7A72 (spare_part_id), INDEX IDX_AFC66957975B7E7 (model_id), PRIMARY KEY(spare_part_id, model_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_slot (id INT AUTO_INCREMENT NOT NULL, unix_timestamp INT NOT NULL, amount_of_time_slots INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE maintenance_jobs_spare_parts ADD CONSTRAINT FK_2D0AA0B211D78A0 FOREIGN KEY (maintenance_job_id) REFERENCES maintenance_job (id)');
        $this->addSql('ALTER TABLE maintenance_jobs_spare_parts ADD CONSTRAINT FK_2D0AA0B49B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5930EEB7B FOREIGN KEY (car_number_plate) REFERENCES car (number_plate)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5F8D8CDF1 FOREIGN KEY (engineer_id) REFERENCES engineer (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5BE04EA9 FOREIGN KEY (job_id) REFERENCES maintenance_job (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5D62B0FA FOREIGN KEY (time_slot_id) REFERENCES time_slot (id)');
        $this->addSql('ALTER TABLE models_spare_parts ADD CONSTRAINT FK_AFC669549B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id)');
        $this->addSql('ALTER TABLE models_spare_parts ADD CONSTRAINT FK_AFC66957975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5930EEB7B');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9395C3F3');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5F8D8CDF1');
        $this->addSql('ALTER TABLE maintenance_jobs_spare_parts DROP FOREIGN KEY FK_2D0AA0B211D78A0');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5BE04EA9');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE models_spare_parts DROP FOREIGN KEY FK_AFC66957975B7E7');
        $this->addSql('ALTER TABLE maintenance_jobs_spare_parts DROP FOREIGN KEY FK_2D0AA0B49B7A72');
        $this->addSql('ALTER TABLE models_spare_parts DROP FOREIGN KEY FK_AFC669549B7A72');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5D62B0FA');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE engineer');
        $this->addSql('DROP TABLE maintenance_job');
        $this->addSql('DROP TABLE maintenance_jobs_spare_parts');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE scheduled_maintenance_job');
        $this->addSql('DROP TABLE spare_part');
        $this->addSql('DROP TABLE models_spare_parts');
        $this->addSql('DROP TABLE time_slot');
    }
}
