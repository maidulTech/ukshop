CREATE PROCEDURE PROC_SLS_BOOKING_CHECK_EXPIRE(OUT OUT_STATUS VarChar(20))
  NO SQL
BEGIN

    DECLARE int_HAS_cur_PROC_SLS_BOOKING_CHECK_EXPIRE INT DEFAULT 1;
    DECLARE x_pk_no INT;
    DECLARE int_row_count INT;
    DECLARE booking_time DATETIME;
    DECLARE expired_time DATETIME;
    DECLARE current_time_ DATETIME;
    DECLARE extented_expired_time DATETIME;
    DECLARE OUT_STATUS VarChar(20);
    DECLARE ALL_SUCCESS INT DEFAULT 0;

    DECLARE cur_PROC_SLS_BOOKING_CHECK_EXPIRE
        CURSOR FOR
        SELECT
            PK_NO,BOOKING_TIME,EXPIERY_DATE_TIME,REBOOKING_TIME
            FROM SLS_BOOKING;


        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SLS_BOOKING_CHECK_EXPIRE = 0;

        /*DELETING EXISTING VALUE*/

            /*IF IS_UPDATE = 1 THEN
              SELECT PK_NO INTO package_pk_no FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO LIMIT 1;
              SELECT FOUND_ROWS() into int_row_count ;
              INSERT INTO R VALUES(int_row_count);
              IF int_row_count > 0 THEN
                DELETE FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO ;
              END IF;

              SELECT PK_NO INTO package_pk_no FROM SC_PACKING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO LIMIT 1;
              SELECT FOUND_ROWS() into int_row_count ;
              INSERT INTO R VALUES(int_row_count);
              IF int_row_count > 0 THEN
                DELETE FROM SC_PACKING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO ;
              END IF;
            END IF;*/
        /*DELETING EXISTING VALUE End*/


/* DELETE FROM R; */
INSERT INTO R VALUES('Start Procedre');

                SET int_HAS_cur_PROC_SLS_BOOKING_CHECK_EXPIRE = 1;

                OPEN cur_PROC_SLS_BOOKING_CHECK_EXPIRE;
                SELECT FOUND_ROWS() into int_row_count ;

                insert into R values (concat('Found row before Loop ', int_row_count));

                    IF int_row_count  != 0 THEN

                    get_PROC_SLS_BOOKING_CHECK_EXPIRE: LOOP
                        FETCH NEXT FROM  cur_PROC_SLS_BOOKING_CHECK_EXPIRE INTO x_pk_no,booking_time,expired_time,extented_expired_time;

INSERT INTO R VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SLS_BOOKING_CHECK_EXPIRE));

                        IF int_HAS_cur_PROC_SLS_BOOKING_CHECK_EXPIRE = 0 THEN
                                LEAVE get_PROC_SLS_BOOKING_CHECK_EXPIRE;
                            END IF;

                            SELECT CURRENT_TIMESTAMP INTO current_time_;

INSERT INTO R VALUES(concat('Current Date ', current_time_) );
INSERT INTO R VALUES(concat('Expired Date ', expired_time) );

                            IF current_time_ > expired_time THEN

                                UPDATE SLS_BOOKING
                                    SET IS_ACTIVE = 0
                                    WHERE PK_NO = x_pk_no;

                            END IF;

                            IF (extented_expired_time IS NOT NULL) THEN
                                IF current_time_ > extented_expired_time THEN
                                    DELETE FROM SLS_BOOKING_DETAILS WHERE F_BOOKING_NO = x_pk_no;
                                    DELETE FROM SLS_BOOKING WHERE PK_NO = x_pk_no;
                                    UPDATE INV_STOCK SET F_BOOKING_NO = NULL,BOOKING_STATUS = NULL WHERE F_BOOKING_NO = x_pk_no;
                                END IF;
                            END IF;


                    SET ALL_SUCCESS = ALL_SUCCESS + 1;

                    insert into R values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));

                    END LOOP get_PROC_SLS_BOOKING_CHECK_EXPIRE;

                    END IF;

                CLOSE cur_PROC_SLS_BOOKING_CHECK_EXPIRE;

                    IF ALL_SUCCESS = int_row_count THEN
                        SET OUT_STATUS = 'success';
                    ELSE
                        SET OUT_STATUS = 'failed';
                    END IF;


INSERT INTO R VALUES(concat('End of Procedure with status ', OUT_STATUS));

END
