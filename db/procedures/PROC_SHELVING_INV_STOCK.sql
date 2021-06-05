CREATE PROCEDURE PROC_SHELVING_INV_STOCK(shelve_label VarChar(20), IN_INV_SHELVING_ARRAY VarChar(1024), IN_ROW_COUNT Integer, IN_COL_PARAMETERS Integer, IN_COLUMN_SEPARATOR VarChar(1), IN_ROW_SEPARATOR VarChar(1), USER_ID Integer, IS_UPDATE Integer, OUT OUT_STATUS VarChar(20))
  NO SQL
BEGIN



/*10101010~10~5|10101011~9~3|10101012~10~1|*/
  DECLARE int_HAS_cur_PROC_SHELVING_INV_STOCK INT DEFAULT 1;
    DECLARE xPK_NO INT;
    DECLARE var_arrary_param1 VARCHAR(100);
    DECLARE var_arrary_param2 VARCHAR(100);
    DECLARE var_arrary_param3 INT;
    DECLARE var_arrary_row VARCHAR(200);
    DECLARE var_arrary_row_part VARCHAR(200);
    DECLARE int_row_count INT;
    DECLARE int_is_duplicate_box INT DEFAULT 1;
    DECLARE int_shelve_pk INT(11);
    DECLARE from_warehouse_no INT(11);
    DECLARE user_name VARCHAR(200);
    DECLARE i,j INT;
    DECLARE item_count_warehouse INT(11);
    DECLARE ALL_SUCCESS INT DEFAULT 0;

    DECLARE cur_PROC_SHELVING_INV_STOCK
        CURSOR FOR
        SELECT
            PK_NO
            FROM INV_STOCK
            WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
            /*AND (PRODUCT_STATUS = 60 )  */
            AND (F_INV_ZONE_NO IS NULL)
            AND SKUID=var_arrary_param1 LIMIT var_arrary_param3;

        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SHELVING_INV_STOCK = 0;

DELETE FROM R;
INSERT INTO R VALUES('Start Procedre');

 SELECT PK_NO,ITEM_COUNT INTO int_shelve_pk,item_count_warehouse FROM INV_WAREHOUSE_ZONES WHERE ZONE_BARCODE = shelve_label;
 INSERT INTO R VALUES(concat('item_count val ', item_count_warehouse));
 INSERT INTO R VALUES(concat('Zone PK_NO val ', int_shelve_pk));
 INSERT INTO R VALUES(concat('shelve_label val ', shelve_label));
 insert into R values (concat('Parameter Array ',IN_INV_SHELVING_ARRAY));


            SELECT USERNAME INTO user_name FROM SA_USER WHERE PK_NO = USER_ID;
            SET i=1;

            WHILE i <= IN_ROW_COUNT DO
                INSERT INTO R VALUES(concat('loop i val ', i));

                SELECT substring_index(IN_INV_SHELVING_ARRAY , IN_ROW_SEPARATOR , 1) INTO var_arrary_row;

insert into R values (concat('Row data ', var_arrary_row));

                SET var_arrary_row_part =  var_arrary_row;

                SELECT substring_index(var_arrary_row_part , IN_COLUMN_SEPARATOR , 1) INTO var_arrary_param1;
                SET var_arrary_row_part = substring(var_arrary_row_part , length(var_arrary_param1)+2 , length(var_arrary_row_part) - length(var_arrary_param1) );


                SELECT substring_index(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param2;
                SET var_arrary_row_part = substring(var_arrary_row_part , length(var_arrary_param2)+2 , length(var_arrary_row_part) - length(var_arrary_param2) );


                SET  var_arrary_param3 = var_arrary_row_part;

                SET IN_INV_SHELVING_ARRAY = substring(IN_INV_SHELVING_ARRAY , length(var_arrary_row)+2 , length(IN_INV_SHELVING_ARRAY) - length(var_arrary_row) );


insert into R values (concat('Param 1   ', var_arrary_param1));
insert into R values (concat('Param 2   ', var_arrary_param2));
insert into R values (concat('Param 3   ', var_arrary_param3));


                SET int_HAS_cur_PROC_SHELVING_INV_STOCK = 1;

                OPEN cur_PROC_SHELVING_INV_STOCK;
                SELECT FOUND_ROWS() into int_row_count ;

                insert into R values (concat('Found row before Loop ', int_row_count));


                    IF int_row_count  != 0 && int_row_count = var_arrary_param3 THEN

                    SET ALL_SUCCESS = ALL_SUCCESS + 1;

                    insert into R values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));
                       /* SET j=0;


INSERT INTO R VALUES(concat('init j val ', j));*/

                    get_PROC_SHELVING_INV_STOCK: LOOP
                        FETCH NEXT FROM  cur_PROC_SHELVING_INV_STOCK INTO xPK_NO;

INSERT INTO R VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SHELVING_INV_STOCK));

                        IF int_HAS_cur_PROC_SHELVING_INV_STOCK = 0 THEN
                                LEAVE get_PROC_SHELVING_INV_STOCK;
                            END IF;


INSERT INTO R VALUES(concat('INV Stock PK_NO ', xPK_NO) );
/*INSERT INTO R VALUES(concat('loop j val ', j));   */

                        UPDATE INV_STOCK
                            SET F_INV_ZONE_NO = int_shelve_pk
                            ,INV_ZONE_BARCODE = shelve_label
                            ,ZONE_CHECK_IN_BY_NAME= user_name
                            ,ZONE_CHECK_IN_BY = USER_ID
                            WHERE PK_NO =  xPK_NO;
                        INSERT INTO INV_WAREHOUSE_ZONE_STOCK_ITEM( F_INV_STOCK_NO, F_INV_WAREHOUSE_ZONE_NO) VALUES ( xPK_NO, int_shelve_pk );
                          /*  SET j = j + 1;*/
                        INSERT INTO R VALUES(concat('item_count val ', item_count_warehouse));
                        SET item_count_warehouse = item_count_warehouse + 1;

                    END LOOP get_PROC_SHELVING_INV_STOCK;

                    INSERT INTO R VALUES(concat('item_count val ', item_count_warehouse));
                     UPDATE INV_WAREHOUSE_ZONES
                            SET ITEM_COUNT = item_count_warehouse
                            WHERE ZONE_BARCODE =  shelve_label;

                    END IF;

                CLOSE cur_PROC_SHELVING_INV_STOCK;

                set i = i + 1;

            END WHILE;

                  IF ALL_SUCCESS = IN_ROW_COUNT THEN
                     SET OUT_STATUS = 'success';
                   ELSE
                     SET OUT_STATUS = 'exeeded';
                  /*  SELECT PK_NO INTO int_shelve_pk FROM INV_WAREHOUSE_ZONES WHERE ZONE_BARCODE = shelve_label;
                    UPDATE INV_STOCK
                           SET F_INV_ZONE_NO = NULL,
                               INV_ZONE_BARCODE = NULL
                           WHERE F_INV_ZONE_NO =  int_shelve_pk ;

                    DELETE FROM INV_WAREHOUSE_ZONE_STOCK_ITEM WHERE F_INV_WAREHOUSE_ZONE_NO = int_shelve_pk ;
                    */
                   END IF;

INSERT INTO R VALUES(concat('End of Procedure with status ', OUT_STATUS));

END
