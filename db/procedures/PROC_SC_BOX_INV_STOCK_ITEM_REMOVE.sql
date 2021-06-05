CREATE PROCEDURE PROC_SC_BOX_INV_STOCK_ITEM_REMOVE(IN_BOX_LABEL VarChar(20), IN_INV_BOXING_ARRAY VarChar(1024), IN_ROW_COUNT Integer, IN_COL_PARAMETERS Integer, IN_COLUMN_SEPARATOR VarChar(1), IN_ROW_SEPARATOR VarChar(1), USER_ID Integer, IS_UPDATE Integer, IN_WIDTH Integer, IN_LENGTH Integer, IN_HEIGHT Integer, IN_WEIGHT Float, OUT OUT_STATUS VarChar(20))
  NO SQL
Block1: BEGIN


/*CALL PROC_SC_BOX_INV_STOCK_ITEM_ADD(20100251,'101103111102~1~9|',1,3,'~','|',1,0,@OUT_STATUS);*/

    DECLARE int_HAS_cur_PROC_SC_BOX_INV_STOCK INT DEFAULT 1;
    DECLARE xPK_NO INT;
    DECLARE var_arrary_param1 VARCHAR(100);
    DECLARE var_arrary_param2 INT DEFAULT 0;
    DECLARE var_arrary_param3 INT;
    DECLARE var_arrary_row VARCHAR(200);
    DECLARE var_arrary_row_part VARCHAR(200);
    DECLARE var_inv_stored_pk VARCHAR(20000) DEFAULT 0;
    DECLARE int_row_count INT;
    DECLARE int_box_pk INT(11);
    DECLARE from_warehouse_no INT(11);
    DECLARE int_count_updated_row INT DEFAULT 0;
    DECLARE i,j INT;
    DECLARE ALL_SUCCESS INT DEFAULT 0;
    DECLARE ALL_SUCCESS_PART INT DEFAULT 1;

    DECLARE cur_PROC_SC_BOX_INV_STOCK
        CURSOR FOR
        SELECT
            PK_NO
            FROM INV_STOCK
            WHERE F_INV_WAREHOUSE_NO=var_arrary_param2
            AND SKUID=var_arrary_param1
            AND F_BOX_NO=int_box_pk
            ORDER BY F_ORDER_NO ASC LIMIT var_arrary_param3;

        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0;

DELETE FROM S;
INSERT INTO S VALUES('Start Procedre Item Remove');
            SELECT PK_NO INTO int_box_pk FROM SC_BOX WHERE BOX_NO = IN_BOX_LABEL;

            INSERT INTO S VALUES(concat('IN_BOX_LABEL ' , IN_BOX_LABEL));
            INSERT INTO S VALUES(concat('int_box_pk ' , int_box_pk));

insert into S values (concat('Parameter Array ',IN_INV_BOXING_ARRAY));

            IF int_box_pk IS NOT NULL OR int_box_pk > 0 THEN

               create temporary table temp_inv_pk_no
               ( inv_pk_no int );

            UPDATE SC_BOX SET WIDTH_CM = IN_WIDTH, LENGTH_CM = IN_LENGTH, HEIGHT_CM = IN_HEIGHT, WEIGHT_KG = IN_WEIGHT WHERE BOX_NO = IN_BOX_LABEL;

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

                    IF int_row_count != 0 && int_row_count = var_arrary_param3 THEN

                        SET ALL_SUCCESS = ALL_SUCCESS + 1;

                        insert into S values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));

                    get_PROC_SC_BOX_INV_STOCK: LOOP
                        FETCH NEXT FROM  cur_PROC_SC_BOX_INV_STOCK INTO xPK_NO;

INSERT INTO S VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SC_BOX_INV_STOCK));

                        IF int_HAS_cur_PROC_SC_BOX_INV_STOCK = 0 THEN
                                LEAVE get_PROC_SC_BOX_INV_STOCK;
                        END IF;


INSERT INTO S VALUES(concat('INV Stock PK_NO ', xPK_NO) );

                        SET int_count_updated_row = int_count_updated_row + 1;

                        insert into temp_inv_pk_no(inv_pk_no) values (xPK_NO);
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

                    IF int_count_updated_row != var_arrary_param3 THEN
                        SET ALL_SUCCESS_PART = 0;
                    END IF;

                set i = i + 1;

            END WHILE;

                  /* IF ALL_SUCCESS_PART = 0 THEN
                    SET OUT_STATUS = 'failed-partial';
                  ELSE */
                  INSERT INTO S VALUES(concat('ALL_SUCCESS_PART ', ALL_SUCCESS_PART) );
                  INSERT INTO S VALUES(concat('ALL_SUCCESS ', ALL_SUCCESS) );
                  INSERT INTO S VALUES(concat('IN_ROW_COUNT ', IN_ROW_COUNT) );
                  INSERT INTO S VALUES(concat('var_inv_stored_pk ', var_inv_stored_pk) );
                  IF ALL_SUCCESS = IN_ROW_COUNT AND ALL_SUCCESS_PART = 1 THEN
                        SET OUT_STATUS = 'success';
                        UPDATE INV_STOCK
                            SET F_BOX_NO = NULL,
                                PRODUCT_STATUS = NULL,
                                BOX_BARCODE = NULL,
                                BOX_TYPE = NULL
                            WHERE PK_NO IN (select inv_pk_no from temp_inv_pk_no);

                        DELETE FROM SC_BOX_INV_STOCK
                        WHERE F_INV_STOCK_NO IN (select inv_pk_no from temp_inv_pk_no);

                  drop temporary table if exists temp_inv_pk_no;

                  ELSE
                    SET OUT_STATUS = 'failed';

                   END IF;


        ELSE
           SET OUT_STATUS = 'box-not-found';

        END IF;

INSERT INTO S VALUES(concat('End of Procedure with status ', OUT_STATUS));

END Block1
/
