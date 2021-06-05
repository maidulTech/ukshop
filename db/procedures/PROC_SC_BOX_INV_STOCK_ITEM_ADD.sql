CREATE PROCEDURE PROC_SC_BOX_INV_STOCK_ITEM_ADD(IN_BOX_LABEL VarChar(20), IN_INV_BOXING_ARRAY VarChar(1024), IN_ROW_COUNT Integer, IN_COL_PARAMETERS Integer, IN_COLUMN_SEPARATOR VarChar(1), IN_ROW_SEPARATOR VarChar(1), USER_ID Integer, IS_UPDATE Integer, IN_WIDTH Integer, IN_LENGTH Integer, IN_HEIGHT Integer, IN_WEIGHT Float, OUT OUT_STATUS VarChar(20))
  NO SQL
Block1: BEGIN


/*CALL PROC_SC_BOX_INV_STOCK_ITEM_ADD(20100251,'101103111102~1~9|',1,3,'~','|',1,0,@OUT_STATUS);*/

    DECLARE int_HAS_cur_PROC_SC_BOX_INV_STOCK INT DEFAULT 1;
    DECLARE xPK_NO INT;
    DECLARE xLIMIT INT;
    DECLARE sPK_NO INT;
    DECLARE var_arrary_param1 VARCHAR(100);
    DECLARE var_arrary_param2 VARCHAR(100);
    DECLARE var_arrary_param3 INT;
    DECLARE var_arrary_row VARCHAR(200);
    DECLARE xCUSTOMER_PREFFERED_SHIPPING_METHOD VARCHAR(200);
    DECLARE var_arrary_row_part VARCHAR(200);
    DECLARE var_inv_stored_pk VARCHAR(20000) DEFAULT 0;
    DECLARE int_row_count INT;
    DECLARE int_row_count_cursor2 INT;
    DECLARE int_is_duplicate_box INT DEFAULT 1;
    DECLARE int_box_pk INT(11);
    DECLARE from_warehouse_no INT(11);
    DECLARE user_name VARCHAR(200);
    DECLARE int_count_updated_row INT DEFAULT 0;
    DECLARE i,j INT;
    DECLARE check_shipment_type VARCHAR(45);
    DECLARE ALL_SUCCESS INT DEFAULT 0;
    DECLARE ALL_SUCCESS_PART INT DEFAULT 1;

    DECLARE cur_PROC_SC_BOX_INV_STOCK
        CURSOR FOR
        SELECT
            PK_NO
            FROM INV_STOCK
            WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
            AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 AND PRODUCT_STATUS != 420)
            AND SKUID=var_arrary_param1
            AND FINAL_PREFFERED_SHIPPING_METHOD = check_shipment_type
            ORDER BY F_ORDER_NO DESC LIMIT var_arrary_param3;


        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0;

            DELETE FROM S;
            /*REBOXING*/



           /* IF IS_UPDATE = 1 THEN
              SELECT PK_NO INTO int_box_pk FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;
              SELECT FOUND_ROWS() into int_row_count ;
              INSERT INTO S VALUES(concat('DELETE FOR UPDATE ' , int_row_count));
              INSERT INTO S VALUES(int_row_count);
              IF int_row_count > 0 THEN
              UPDATE INV_STOCK
                     SET PRODUCT_STATUS = NULL,
                     BOX_BARCODE = NULL,
                     BOX_TYPE = NULL,
                     F_BOX_NO = NULL
              WHERE F_BOX_NO =  int_box_pk ;

              DELETE FROM SC_BOX_INV_STOCK WHERE F_BOX_NO = int_box_pk ;
                 INSERT INTO S VALUES(2);
              DELETE FROM SC_BOX WHERE PK_NO = int_box_pk;
              END IF;

            END IF;
        REBOXING End*/


INSERT INTO S VALUES('Start Procedre');

            SELECT SUBSTRING(IN_BOX_LABEL, 1, 1) INTO check_shipment_type;

            INSERT INTO S VALUES(concat('SC BOX label ' , IN_BOX_LABEL));
            INSERT INTO S VALUES(concat('First_Box ' , check_shipment_type));

            IF check_shipment_type = '1' THEN
               SET check_shipment_type = 'AIR';
            ELSE
               SET check_shipment_type = 'SEA';
            END IF;

            SELECT PK_NO, COUNT(BOX_NO) INTO int_box_pk, int_is_duplicate_box FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;

            -- SELECT CONCAT(first_name, ' ', last_name) AS user_name_concate INTO user_name FROM admin_users WHERE auth_id = USER_ID;
DELETE FROM S;
INSERT INTO S VALUES(concat('SC BOX Pk ' , int_box_pk));
INSERT INTO S VALUES(concat('Duplicate Box Flag ', int_is_duplicate_box));
INSERT INTO S VALUES(concat('Shipment Type ' , check_shipment_type));

        IF int_is_duplicate_box != 0 THEN

        create temporary table temp2_inv_pk_no
               ( inv_pk_no int );

        UPDATE SC_BOX SET WIDTH_CM = IN_WIDTH, LENGTH_CM = IN_LENGTH, HEIGHT_CM = IN_HEIGHT, WEIGHT_KG = IN_WEIGHT WHERE BOX_NO = IN_BOX_LABEL;
            -- SELECT F_INV_WAREHOUSE_NO INTO from_warehouse_no FROM SS_INV_USER_MAP WHERE F_USER_NO = USER_ID;
            INSERT INTO S VALUES(concat('IN_BOX_LABEL ' , IN_BOX_LABEL));
            INSERT INTO S VALUES(concat('USER_ID ' , USER_ID));
            -- INSERT INTO S VALUES(concat('user_name ' , user_name));
            -- INSERT INTO S VALUES(concat('INV house ' , from_warehouse_no));
            -- INSERT INTO SC_BOX (BOX_NO,F_BOX_USER_NO,USER_NAME,BOX_STATUS,F_INV_WAREHOUSE_NO) VALUES(IN_BOX_LABEL,USER_ID,user_name,10,from_warehouse_no);
            -- SELECT LAST_INSERT_ID() INTO int_box_pk;

INSERT INTO S VALUES(concat('Inserted SC Box Pk ', int_box_pk));
insert into S values (concat('Parameter Array ',IN_INV_BOXING_ARRAY));

            SET i=1;


            WHILE i <= IN_ROW_COUNT DO
                INSERT INTO S VALUES(concat('loop i val ', i));

                SELECT substring_index(IN_INV_BOXING_ARRAY , IN_ROW_SEPARATOR , 1) INTO var_arrary_row;

insert into S values (concat('Row data ', var_arrary_row));

                SET var_arrary_row_part =  var_arrary_row;



                SELECT substring_index(var_arrary_row_part , IN_COLUMN_SEPARATOR , 1) INTO var_arrary_param1;
                SET var_arrary_row_part = substring(var_arrary_row_part , length(var_arrary_param1)+2 , length(var_arrary_row_part) - length(var_arrary_param1) );


                SELECT substring_index(var_arrary_row_part,IN_COLUMN_SEPARATOR,1) INTO var_arrary_param2;
                SET var_arrary_row_part = substring(var_arrary_row_part , length(var_arrary_param2)+2 , length(var_arrary_row_part) - length(var_arrary_param2) );


                SET  var_arrary_param3 = var_arrary_row_part;

                SET IN_INV_BOXING_ARRAY = substring(IN_INV_BOXING_ARRAY , length(var_arrary_row)+2 , length(IN_INV_BOXING_ARRAY) - length(var_arrary_row) );




insert into S values (concat('Param 1   ', var_arrary_param1));
insert into S values (concat('Param 2   ', var_arrary_param2));
insert into S values (concat('Param 3   ', var_arrary_param3));


                SET int_HAS_cur_PROC_SC_BOX_INV_STOCK = 1;
                SET int_count_updated_row = 0;
                insert into S values (concat('Updated Row Count ', int_count_updated_row));
                OPEN cur_PROC_SC_BOX_INV_STOCK;
                SELECT FOUND_ROWS() into int_row_count ;

                insert into S values (concat('Found row before Loop ', int_row_count));

                    IF int_row_count != 0 && int_row_count <= var_arrary_param3 THEN

                    SET ALL_SUCCESS = ALL_SUCCESS + 1;


                    insert into S values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));
                       /* SET j=0;


INSERT INTO S VALUES(concat('init j val ', j));*/

                    get_PROC_SC_BOX_INV_STOCK:LOOP
                        FETCH NEXT FROM  cur_PROC_SC_BOX_INV_STOCK INTO xPK_NO;

INSERT INTO S VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SC_BOX_INV_STOCK));

                        IF int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0 THEN
                                LEAVE get_PROC_SC_BOX_INV_STOCK;
                        END IF;


INSERT INTO S VALUES(concat('INV Stock PK_NO ', xPK_NO) );

                         UPDATE INV_STOCK
                            SET F_BOX_NO = int_box_pk, PRODUCT_STATUS = 20,BOX_BARCODE = IN_BOX_LABEL,BOX_TYPE=check_shipment_type
                            WHERE PK_NO =  xPK_NO;
                        INSERT INTO SC_BOX_INV_STOCK( F_BOX_NO, F_INV_STOCK_NO) VALUES ( int_box_pk, xPK_NO );
                        /*  SET j = j + 1;*/
                        SET int_count_updated_row = int_count_updated_row + 1;
                        insert into temp2_inv_pk_no(inv_pk_no) values (xPK_NO);
                        /*if var_inv_stored_pk = 0 THEN
                            SET var_inv_stored_pk = xPK_NO;
                        ELSE
                            SET var_inv_stored_pk = CONCAT(var_inv_stored_pk,',',xPK_NO);
                        END IF;
                        */
                    INSERT INTO S VALUES(concat('var_inv_stored_pk ', var_inv_stored_pk) );

                    END LOOP get_PROC_SC_BOX_INV_STOCK;

                    END IF;

                CLOSE cur_PROC_SC_BOX_INV_STOCK;
                INSERT INTO S VALUES(concat('Updated Rows ', int_count_updated_row) );
                INSERT INTO S VALUES(concat('var_arrary_param3 ', var_arrary_param3) );
                SET xLIMIT = var_arrary_param3 - int_count_updated_row;
                INSERT INTO S VALUES(concat('LIMIT VALUE ', xLIMIT) );

                IF int_count_updated_row < var_arrary_param3 THEN

                /*-------------------------BLOCK 2 BEGINS ------------------------------*/
                Block2: BEGIN
                    DECLARE int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK INT DEFAULT 1;

                    DECLARE cur_PROC_SC_BOXING_LIST_INV_STOCK
                    CURSOR FOR
                    SELECT
                        PK_NO,CUSTOMER_PREFFERED_SHIPPING_METHOD
                        FROM INV_STOCK
                        WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
                        AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS = 0 OR PRODUCT_STATUS = 90 AND PRODUCT_STATUS != 420)
                        AND SKUID=var_arrary_param1;


                    DECLARE CONTINUE HANDLER
                        FOR NOT FOUND SET int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK = 0;

                OPEN cur_PROC_SC_BOXING_LIST_INV_STOCK;
                    SELECT FOUND_ROWS() into int_row_count_cursor2 ;
                    insert into S values (concat('Found row2 before Loop ', int_row_count_cursor2));

                    IF int_row_count_cursor2 != 0 THEN
                       IF int_count_updated_row = 0 THEN
                          SET ALL_SUCCESS = ALL_SUCCESS + 1;
                       END IF;

                        INSERT INTO S VALUES(concat('ALL_SUCCESS LINE 223 ', ALL_SUCCESS) );
                        get_PROC_SC_BOX_INV_STOCK_TOP:LOOP

                            FETCH NEXT FROM cur_PROC_SC_BOXING_LIST_INV_STOCK  INTO xPK_NO,xCUSTOMER_PREFFERED_SHIPPING_METHOD;

                            INSERT INTO S VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK));
                            INSERT INTO S VALUES(concat('Cus Preferred ', xCUSTOMER_PREFFERED_SHIPPING_METHOD));

                                        IF int_count_updated_row = var_arrary_param3 OR int_HAS_cur_PROC_SC_BOXING_LIST_INV_STOCK = 0 THEN

                                                LEAVE get_PROC_SC_BOX_INV_STOCK_TOP;
                                        END IF;

                            INSERT INTO S VALUES(concat('INV Stock TOP PK_NO ', xPK_NO) );

                            IF xCUSTOMER_PREFFERED_SHIPPING_METHOD IS NULL OR xCUSTOMER_PREFFERED_SHIPPING_METHOD = check_shipment_type THEN

                                UPDATE INV_STOCK
                                    SET F_BOX_NO = int_box_pk, PRODUCT_STATUS = 20,BOX_BARCODE = IN_BOX_LABEL,BOX_TYPE=check_shipment_type
                                    WHERE PK_NO =  xPK_NO;
                                INSERT INTO SC_BOX_INV_STOCK( F_BOX_NO, F_INV_STOCK_NO) VALUES ( int_box_pk, xPK_NO );
                                /*  SET j = j + 1;*/
                                SET int_count_updated_row = int_count_updated_row + 1;
                                insert into temp2_inv_pk_no(inv_pk_no) values (xPK_NO);
                                /*if var_inv_stored_pk = 0 THEN
                                    SET var_inv_stored_pk = xPK_NO;
                                ELSE
                                    SET var_inv_stored_pk = CONCAT(var_inv_stored_pk,',',xPK_NO);
                                END IF;
                                */
                                INSERT INTO S VALUES(concat('var_inv_stored_pk ', var_inv_stored_pk) );

                                INSERT INTO S VALUES(concat('Updated Rows ', int_count_updated_row) );

                            END IF;


                        END LOOP get_PROC_SC_BOX_INV_STOCK_TOP;
                    END IF;

                CLOSE cur_PROC_SC_BOXING_LIST_INV_STOCK;

                END Block2;
                /*-------------------------BLOCK 2 ENDS ------------------------------*/

                   IF int_count_updated_row != var_arrary_param3 THEN
                     /*UPDATE INV_STOCK
                         SET PRODUCT_STATUS = NULL,
                             BOX_BARCODE = NULL,
                             BOX_TYPE = NULL,
                             F_BOX_NO = NULL
                         WHERE SKUID=var_arrary_param1
                         AND F_BOX_NO =  int_box_pk;*/

                     SET ALL_SUCCESS_PART = 0;
                   END IF;

                END IF;

                set i = i + 1;

            END WHILE;

                  /* IF ALL_SUCCESS_PART = 0 THEN
                    SET OUT_STATUS = 'failed-partial';

                  ELSE */
                  INSERT INTO S VALUES(concat('ALL_SUCCESS_PART ', ALL_SUCCESS_PART) );
                  INSERT INTO S VALUES(concat('ALL_SUCCESS ', ALL_SUCCESS) );
                  INSERT INTO S VALUES(concat('IN_ROW_COUNT ', IN_ROW_COUNT) );
                  IF ALL_SUCCESS = IN_ROW_COUNT AND ALL_SUCCESS_PART = 1 THEN
                     SET OUT_STATUS = 'success';

                  ELSE
                    SET OUT_STATUS = 'failed';
                    INSERT INTO S VALUES(concat('var_inv_stored_pk ', var_inv_stored_pk) );
                    SELECT PK_NO INTO int_box_pk FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;
                    UPDATE INV_STOCK
                           SET F_BOX_NO = NULL,
                               PRODUCT_STATUS = NULL,
                               BOX_BARCODE = NULL,
                               BOX_TYPE = NULL
                           WHERE PK_NO IN (select inv_pk_no from temp2_inv_pk_no);

                    DELETE FROM SC_BOX_INV_STOCK
                    WHERE F_INV_STOCK_NO IN (select inv_pk_no from temp2_inv_pk_no) ;


                    -- DELETE FROM SC_BOX WHERE PK_NO = int_box_pk;

                   END IF;

        drop temporary table if exists temp2_inv_pk_no;
        ELSE
           SET OUT_STATUS = 'box-not-found';

        END IF;

INSERT INTO S VALUES(concat('End of Procedure with status ', OUT_STATUS));

END Block1
/
