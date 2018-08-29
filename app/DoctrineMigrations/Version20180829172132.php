<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180829172132 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DC6C98E06');
        $this->addSql('DROP INDEX IDX_268B9C9DC6C98E06 ON agent');
        $this->addSql('ALTER TABLE agent CHANGE service_provider_id sp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D8A6FD1BC FOREIGN KEY (sp_id) REFERENCES service_provider (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D8A6FD1BC ON agent (sp_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D8A6FD1BC');
        $this->addSql('DROP INDEX IDX_268B9C9D8A6FD1BC ON agent');
        $this->addSql('ALTER TABLE agent CHANGE sp_id service_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DC6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9DC6C98E06 ON agent (service_provider_id)');
    }
}
