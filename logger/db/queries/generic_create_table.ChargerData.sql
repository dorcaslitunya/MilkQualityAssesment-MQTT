CREATE TABLE
    NewTableName(
        `entry_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
        `create_timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Create Time',
        `update_time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        `update_by` varchar(128) NULL DEFAULT NULL,
        `data_dump_TxnID` varchar(128) NULL DEFAULT NULL,
        `data_dump_Contact` varchar(128) NULL DEFAULT NULL,
        `data_dump_card` varchar(128) NULL DEFAULT NULL,
        `data_dump_Amount` varchar(128) NULL DEFAULT NULL,
        `data_dump_initialise` JSON NULL DEFAULT NULL,
        `data_dump_initialise_status` BOOL NULL DEFAULT NULL,
        `data_dump_request` JSON NULL DEFAULT NULL,
        `data_dump_request_status` BOOL NULL DEFAULT NULL,
        `data_dump_confirm` JSON NULL DEFAULT NULL,
        `data_dump_confirm_status` BOOL NULL DEFAULT NULL,
        `data_dump_consume` JSON NULL DEFAULT NULL,
        `data_dump_consume_status` BOOL NULL DEFAULT NULL,
        PRIMARY KEY (`entry_id`),
        UNIQUE KEY `data_dump_TxnID` (`data_dump_TxnID`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci