<?php

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201102751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cr_seee_search_configuration (id INT AUTO_INCREMENT NOT NULL, attribute_id INT DEFAULT NULL, option_id INT DEFAULT NULL, usedInGlobalSearch TINYINT(1) NOT NULL, searchable TINYINT(1) NOT NULL, filterable TINYINT(1) NOT NULL, facetType VARCHAR(255) DEFAULT NULL, filterOptions JSON DEFAULT NULL, INDEX IDX_5CF9E06EB6E62EFA (attribute_id), INDEX IDX_5CF9E06EA7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cr_seee_search_configuration_taxoninterface (searchconfiguration_id INT NOT NULL, taxoninterface_id INT NOT NULL, INDEX IDX_D5443B22D5940F5A (searchconfiguration_id), INDEX IDX_D5443B227E2DD0E0 (taxoninterface_id), PRIMARY KEY(searchconfiguration_id, taxoninterface_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cr_seee_search_configuration_channelinterface (searchconfiguration_id INT NOT NULL, channelinterface_id INT NOT NULL, INDEX IDX_A06F0783D5940F5A (searchconfiguration_id), INDEX IDX_A06F0783EC6CA45D (channelinterface_id), PRIMARY KEY(searchconfiguration_id, channelinterface_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cr_seee_search_configuration ADD CONSTRAINT FK_5CF9E06EB6E62EFA FOREIGN KEY (attribute_id) REFERENCES sylius_product_attribute (id)');
        $this->addSql('ALTER TABLE cr_seee_search_configuration ADD CONSTRAINT FK_5CF9E06EA7C41D6F FOREIGN KEY (option_id) REFERENCES sylius_product_option (id)');
        $this->addSql('ALTER TABLE cr_seee_search_configuration_taxoninterface ADD CONSTRAINT FK_D5443B22D5940F5A FOREIGN KEY (searchconfiguration_id) REFERENCES cr_seee_search_configuration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cr_seee_search_configuration_taxoninterface ADD CONSTRAINT FK_D5443B227E2DD0E0 FOREIGN KEY (taxoninterface_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cr_seee_search_configuration_channelinterface ADD CONSTRAINT FK_A06F0783D5940F5A FOREIGN KEY (searchconfiguration_id) REFERENCES cr_seee_search_configuration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cr_seee_search_configuration_channelinterface ADD CONSTRAINT FK_A06F0783EC6CA45D FOREIGN KEY (channelinterface_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cr_seee_search_configuration_taxoninterface DROP FOREIGN KEY FK_D5443B22D5940F5A');
        $this->addSql('ALTER TABLE cr_seee_search_configuration_channelinterface DROP FOREIGN KEY FK_A06F0783D5940F5A');
        $this->addSql('DROP TABLE cr_seee_search_configuration');
        $this->addSql('DROP TABLE cr_seee_search_configuration_taxoninterface');
        $this->addSql('DROP TABLE cr_seee_search_configuration_channelinterface');
    }
}
