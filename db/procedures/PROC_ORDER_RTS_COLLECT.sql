CREATE PROCEDURE PROC_ORDER_RTS_COLLECT(IN_ORDER_ID_ARRAY VarChar(1024), IN_ROW_COUNT Integer, IN_COLUMN_SEPARATOR VarChar(1), OUT OUT_STATUS VarChar(20))
  NO SQL
BEGIN


    DECLARE var_arrary_param1 INT;
    DECLARE var_arrary_row VARCHAR(200);
    DECLARE var_arrary_row_part VARCHAR(200);
    DECLARE PICKUP_ID_ INT;
    DECLARE LAST_INSERT_PK_NO INT;
    DECLARE i,j INT;
    DECLARE ALL_SUCCESS INT DEFAULT 0;

DELETE FROM R;
INSERT INTO R VALUES('Start Procedre');

 insert into R values (concat('Parameter Array ',IN_ORDER_ID_ARRAY));
 insert into R values (concat('IN_ROW_COUNT ',IN_ROW_COUNT));

            create temporary table temp_order_id_no
               ( order_pk_no int );

            SET var_arrary_row_part =  IN_ORDER_ID_ARRAY;

            SET i=1;

            WHILE i <= IN_ROW_COUNT DO
                INSERT INTO R VALUES(concat('loop i val ', i));

--                 SELECT substring_index(IN_ORDER_ID_ARRAY , IN_ROW_SEPARATOR , 1) INTO var_arrary_row;

                -- SET var_arrary_row      =  IN_ORDER_ID_ARRAY;

                SELECT substring_index(var_arrary_row_part , IN_COLUMN_SEPARATOR , 1) INTO var_arrary_param1;

                SET var_arrary_row_part = substring(var_arrary_row_part , length(var_arrary_param1)+2 , length(var_arrary_row_part) - length(var_arrary_param1) );

                -- SET IN_ORDER_ID_ARRAY = substring(IN_ORDER_ID_ARRAY , length(var_arrary_row)+2 , length(IN_ORDER_ID_ARRAY) - length(var_arrary_row) );

insert into R values (concat('ROW PART   ', var_arrary_row_part));
insert into R values (concat('Param 1   ', var_arrary_param1));

                    SET ALL_SUCCESS = ALL_SUCCESS + 1;

                    insert into R values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));

                    INSERT INTO temp_order_id_no( order_pk_no) VALUES ( var_arrary_param1 );

                set i = i + 1;

            END WHILE;

                IF ALL_SUCCESS = IN_ROW_COUNT THEN
                    SET OUT_STATUS = 'success';
                    SELECT RTS_BATCH_NO INTO PICKUP_ID_ FROM SLS_BATCH_LIST ORDER BY PK_NO DESC LIMIT 1;
                    SET PICKUP_ID_ = PICKUP_ID_ + 1;
                    INSERT INTO SLS_BATCH_LIST (RTS_BATCH_NO) VALUES (PICKUP_ID_);
                    SELECT LAST_INSERT_ID() INTO LAST_INSERT_PK_NO;
                    UPDATE SLS_ORDER SET PICKUP_ID = LAST_INSERT_PK_NO WHERE PK_NO IN (select order_pk_no from temp_order_id_no);

                ELSE
                    SET OUT_STATUS = 'failed';
                END IF;

drop temporary table if exists temp_order_id_no;

INSERT INTO R VALUES(concat('End of Procedure with status ', OUT_STATUS));

END
