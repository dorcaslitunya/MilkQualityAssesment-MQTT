-- Active: 1677714185654@@127.0.0.1@3306@kiri_entitee

CREATE TABLE
    `kiri_entitee`.`chargers_summary`(
        entry_id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
        create_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() COMMENT 'Create Time',
        update_time_stamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        update_by VARCHAR(128),
        unit_serial VARCHAR(256) NOT NULL UNIQUE,
        unit_id VARCHAR(256) NOT NULL UNIQUE,
        unit_status BOOLEAN NOT NULL DEFAULT 1,
        unit_kyc JSON
    ) COMMENT '';