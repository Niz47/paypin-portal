<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180827064544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, sp_id INT DEFAULT NULL, user_id INT DEFAULT NULL, agent_id BIGINT NOT NULL, api_key VARCHAR(150) NOT NULL, status TINYINT(1) NOT NULL, created_date_time DATETIME NOT NULL, updated_date_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_268B9C9D8A6FD1BC (sp_id), UNIQUE INDEX UNIQ_268B9C9DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_provider (id INT AUTO_INCREMENT NOT NULL, service_provider_id BIGINT NOT NULL, service_provider_name VARCHAR(50) NOT NULL, created_date_time DATETIME NOT NULL, updated_date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D8A6FD1BC FOREIGN KEY (sp_id) REFERENCES service_provider (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D8A6FD1BC');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DA76ED395');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE service_provider');
    }
}
