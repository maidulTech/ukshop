DELIMITER $$

DROP PROCEDURE IF EXISTS `PROC_SLS_BOOKING`$$

CREATE PROCEDURE `PROC_SLS_BOOKING`(IN_BOOKING_PK_NO INTEGER, IN_INV_BOOKING_ARRAY VARCHAR(1024), IN_ROW_COUNT INTEGER, IN_COL_PARAMETERS INTEGER, IN_COLUMN_SEPARATOR VARCHAR(1), IN_ROW_SEPARATOR VARCHAR(1), IN_BOOKING_TYPE VARCHAR(20), OUT OUT_STATUS VARCHAR(20))
    NO SQL
BEGIN
               /*101103111102,1,1,0,0;101103111102,1,1,0,0;
               1=>skuid,
               2=>house,
               3=>value,
               4=>ship type,
               5=>box type,
               6=>customer preferred,
               7=>price type
               8=>customer address type
               9=>Shipment No
               */

        DECLARE int_HAS_cur_PROC_SLS_BOOKING INT DEFAULT 1;
        DECLARE xPK_NO INT;
        DECLARE var_arrary_param1 VARCHAR(100);
        DECLARE var_arrary_param2 INT;
        DECLARE var_arrary_param3 INT;
        DECLARE var_arrary_param4 VARCHAR(100);
        DECLARE var_arrary_param5 VARCHAR(100);
        DECLARE var_arrary_param6 VARCHAR(100);
        DECLARE var_arrary_param7 VARCHAR(100);
        DECLARE var_arrary_param8 INT;
        DECLARE var_arrary_param9 INT;
        DECLARE is_freight INT DEFAULT 0;
        DECLARE var_arrary_row VARCHAR(200);
        DECLARE var_arrary_row_part VARCHAR(200);
        DECLARE is_regular INT;
        DECLARE int_row_count INT;
        DECLARE i,j INT;
        DECLARE ALL_SUCCESS INT DEFAULT 0;
        DECLARE VAR_SLS_BOOKING_DETAILS_TABLE VARCHAR(50);

        DECLARE cur_PROC_SLS_BOOKING
            CURSOR FOR
                SELECT
                    PK_NO
                    FROM INV_STOCK
                    WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
                    AND ((BOOKING_STATUS IS NULL OR BOOKING_STATUS = 0 OR BOOKING_STATUS = 90) AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS != 420))
                    AND SKUID=var_arrary_param1
                    AND
                    CASE
                        WHEN var_arrary_param2 = 1 THEN (
                        CASE
                             WHEN var_arrary_param4 = '0' THEN SHIPMENT_TYPE IS NULL
                                  ELSE SHIPMENT_TYPE = var_arrary_param4
                             END
                             AND
                        CASE
                             WHEN var_arrary_param5 = '0' THEN BOX_TYPE IS NULL
                                  ELSE BOX_TYPE = var_arrary_param5
                             END
                             AND
                        CASE
                             WHEN var_arrary_param9 = '0' THEN F_SHIPPMENT_NO IS NULL
                                  ELSE F_SHIPPMENT_NO = var_arrary_param9
                             END
                    )
                    ELSE PK_NO > 1
                    END
                    LIMIT var_arrary_param3 FOR UPDATE;


                    DECLARE CONTINUE HANDLER
                    FOR NOT FOUND SET int_HAS_cur_PROC_SLS_BOOKING = 0;

DELETE FROM R;
INSERT INTO R VALUES('Line 49');
INSERT INTO R VALUES(IN_ROW_COUNT);
                    SET i=1;
INSERT INTO R VALUES(i);

                WHILE i <= IN_ROW_COUNT DO

                    SELECT SUBSTRING_INDEX(IN_INV_BOOKING_ARRAY , IN_ROW_SEPARATOR , 1) INTO var_arrary_row;
INSERT INTO R VALUES (IN_INV_BOOKING_ARRAY);
INSERT INTO R VALUES (var_arrary_row);

                    SET var_arrary_row_part =  var_arrary_row;
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part , IN_COLUMN_SEPARATOR , 1) INTO var_arrary_param1;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param1)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param1) );

INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param2;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param2)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param2) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param3;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param3)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param3) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param4;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param4)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param4) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param5;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param5)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param5) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param6;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param6)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param6) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param7;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param7)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param7) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SELECT SUBSTRING_INDEX(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param8;
                    SET var_arrary_row_part=SUBSTRING(var_arrary_row_part , LENGTH(var_arrary_param8)+2 , LENGTH(var_arrary_row_part) - LENGTH(var_arrary_param8) );
INSERT INTO R VALUES (var_arrary_row_part);

                    SET var_arrary_param9 = var_arrary_row_part;

INSERT INTO R VALUES('Line 73.');

                    SET IN_INV_BOOKING_ARRAY = SUBSTRING(IN_INV_BOOKING_ARRAY , LENGTH(var_arrary_row)+2 , LENGTH(IN_INV_BOOKING_ARRAY) - LENGTH(var_arrary_row) );
INSERT INTO R VALUES(CONCAT('IN_INV_BOOKING_ARRAY ', IN_INV_BOOKING_ARRAY));
INSERT INTO R VALUES(CONCAT('loop i val ', i));
                    SET int_HAS_cur_PROC_SLS_BOOKING = 1;

                OPEN cur_PROC_SLS_BOOKING;
                    SELECT FOUND_ROWS() INTO int_row_count ;

INSERT INTO R VALUES ('Line 75');
INSERT INTO R VALUES (CONCAT('Found row ', int_row_count));
INSERT INTO R VALUES (var_arrary_row);
INSERT INTO R VALUES (var_arrary_param1);
INSERT INTO R VALUES (var_arrary_param2);
INSERT INTO R VALUES (var_arrary_param3);
INSERT INTO R VALUES (var_arrary_param4);
INSERT INTO R VALUES (var_arrary_param5);
INSERT INTO R VALUES (var_arrary_param6);
INSERT INTO R VALUES (var_arrary_param9);

                    IF int_row_count  != 0 THEN

                    SET ALL_SUCCESS = ALL_SUCCESS + 1;

                    INSERT INTO R VALUES (CONCAT('ALL SUCCESS VAL ', ALL_SUCCESS));
                    /*SET j = 0;

INSERT INTO R VALUES(concat('init j val ', j));*/

                    get_PROC_SLS_BOOKING: LOOP
                        FETCH NEXT FROM  cur_PROC_SLS_BOOKING INTO xPK_NO;
                        IF int_HAS_cur_PROC_SLS_BOOKING = 0 THEN
                                LEAVE get_PROC_SLS_BOOKING;
                        END IF;

INSERT INTO R VALUES('line 89');
INSERT INTO R VALUES(CONCAT('xPK_NO val ', xPK_NO) );
INSERT INTO R VALUES(CONCAT('j<var_arrary_param3 ', var_arrary_param3) );
/*INSERT INTO R VALUES(concat('loop j val ', j));*/
                    /*    IF var_arrary_param7 = 'regular' THEN
                           SET is_regular = 1;
                        ELSE
                           SET is_regular = 0;
                        END IF;
                        */
                    IF IN_BOOKING_TYPE != 'temp' THEN

                        IF var_arrary_param5 = '0' THEN
                           UPDATE INV_STOCK
                            SET F_BOOKING_NO = IN_BOOKING_PK_NO,
                            CUSTOMER_PREFFERED_SHIPPING_METHOD = var_arrary_param6,
                            FINAL_PREFFERED_SHIPPING_METHOD = var_arrary_param6,
                            BOOKING_STATUS = 10
                            WHERE PK_NO =  xPK_NO;
                        ELSE
                           UPDATE INV_STOCK
                            SET F_BOOKING_NO = IN_BOOKING_PK_NO,
                            BOOKING_STATUS = 10
                            WHERE PK_NO =  xPK_NO;
                        END IF;

                    END IF;

                        INSERT INTO R VALUES(CONCAT('var_arrary_param4 val ', var_arrary_param4) );
                        INSERT INTO R VALUES(CONCAT('var_arrary_param5 val ', var_arrary_param5) );
                        INSERT INTO R VALUES(CONCAT('var_arrary_param6 val ', var_arrary_param6) );
                        IF var_arrary_param4 = '0' AND var_arrary_param5 = '0' AND var_arrary_param2 = 1 THEN
                           IF var_arrary_param6 = 'AIR' THEN
                              SET is_freight = 1;
                           END IF;

                           IF var_arrary_param6 = 'SEA' THEN
                              SET is_freight = 2;
                           END IF;

                        ELSE
                           SET is_freight = 0;
                        END IF;
                        INSERT INTO R VALUES(CONCAT('is_freight val ', is_freight) );
                        IF IN_BOOKING_TYPE = 'temp' THEN

                            INSERT INTO SLS_BOOKING_DETAILS_TEMP(
                                F_BOOKING_NO
                                ,F_INV_STOCK_NO
                                ,F_DELIVERY_ADDRESS
                                ,CURRENT_F_DELIVERY_ADDRESS
                                ,IS_FREIGHT
                                ,CURRENT_IS_FREIGHT
                                ,IS_REGULAR
                                ,CURRENT_IS_REGULAR
                                ,ARRIVAL_NOTIFICATION_FLAG
                                ,SS_CREATED_ON
                                ) VALUES (
                                IN_BOOKING_PK_NO
                                ,xPK_NO
                                ,var_arrary_param8
                                ,var_arrary_param8
                                ,is_freight
                                ,is_freight
                                ,var_arrary_param7
                                ,var_arrary_param7
                                ,var_arrary_param2
                                ,NOW()
                                );

                        ELSE
                             INSERT INTO SLS_BOOKING_DETAILS(
                                F_BOOKING_NO
                                ,F_INV_STOCK_NO
                                ,F_DELIVERY_ADDRESS
                                ,CURRENT_F_DELIVERY_ADDRESS
                                ,IS_FREIGHT
                                ,CURRENT_IS_FREIGHT
                                ,IS_REGULAR
                                ,CURRENT_IS_REGULAR
                                ,ARRIVAL_NOTIFICATION_FLAG
                                ,SS_CREATED_ON
                                ) VALUES (
                                IN_BOOKING_PK_NO
                                ,xPK_NO
                                ,var_arrary_param8
                                ,var_arrary_param8
                                ,is_freight
                                ,is_freight
                                ,var_arrary_param7
                                ,var_arrary_param7
                                ,var_arrary_param2
                                ,NOW()
                                );

                        END IF;

                                                /*  SET j = j + 1;*/
                          SET is_freight = 0;

                    END LOOP get_PROC_SLS_BOOKING;

                    END IF;

                CLOSE cur_PROC_SLS_BOOKING;

                SET i = i + 1;

                END WHILE;

                IF ALL_SUCCESS = IN_ROW_COUNT THEN
                    SET OUT_STATUS = 'success';
                ELSE
                    SET OUT_STATUS = 'failed';
                    /*UPDATE INV_STOCK
                        SET BOOKING_STATUS = NULL,
                            F_BOOKING_NO = NULL
                        WHERE F_BOOKING_NO = IN_BOOKING_PK_NO ;

                    DELETE FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = IN_BOOKING_PK_NO;  */

                END IF;
INSERT INTO R VALUES('122');

INSERT INTO R VALUES(CONCAT('End of Procedure with status ', OUT_STATUS));




END$$

DELIMITER ;
