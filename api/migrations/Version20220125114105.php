<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125114105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates `user_contact_request` and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `user_contact_request` (
                id CHAR(36) NOT NULL PRIMARY KEY,
                email VARCHAR(100) NOT NULL,
                owner_id CHAR(36) NOT NULL,
                active TINYINT(1) DEFAULT 0,
                contact_reason VARCHAR(255) DEFAULT NULL,
                message VARCHAR(500) DEFAULT NULL,
                requiered_skills VARCHAR(255) DEFAULT NULL,
                join_my_team TINYINT(1) DEFAULT 0,
                order_project TINYINT(1) DEFAULT 0,
                meeting_date DATETIME DEFAULT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX IDX_contact_request_owner_id (owner_id),
                CONSTRAINT FK_contact_request_owner_id FOREIGN KEY (owner_id) REFERENCES `user` (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user_contact_request`');
    }
}
