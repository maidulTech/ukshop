CREATE PROCEDURE PROC_SC_PACKAGING_LIST_INV_STOCK(SHIPMENT_NO Integer, IS_UPDATE Integer, OUT OUT_STATUS VarChar(20))
  NO SQL
Block1: BEGIN

    DECLARE int_HAS_cur_PROC_SC_PACKAGING_LIST_INV_STOCK INT DEFAULT 1;
    DECLARE int_is_duplicate_shipment INT DEFAULT 1;
    DECLARE package_pk_no INT;
    DECLARE box_serial_no INT;
    DECLARE box_no INT;
    DECLARE shipment_name INT;
    DECLARE int_row_count INT;
    DECLARE int_box_row_count INT;
    DECLARE int_row_count_cursor2 INT;
    DECLARE int_row_count_cursor3 INT;
    DECLARE int_width INT;
    DECLARE int_length INT;
    DECLARE int_height INT;
    DECLARE int_weight FLOAT;
    DECLARE int_product_count INT;
    DECLARE int_count_price FLOAT;
    DECLARE variant_no INT;
    DECLARE invoice_no VarChar(255);
    DECLARE invoice_pk_no VarChar(255) DEFAULT '0';
    DECLARE int_product_count_invoice INT;
    DECLARE int_prc_no INT;
    DECLARE vendor_name VarChar(255);
    DECLARE invoice_date VarChar(255);
    DECLARE var_hs_code VarChar(255);
    DECLARE var_ig_code VarChar(255);
    DECLARE sku_id INT;
    DECLARE sub_cat_name VarChar(255);
    DECLARE var_invoice_name VarChar(255);
    DECLARE unit_price FLOAT;
    DECLARE var_invoice_details VarChar(4000) DEFAULT '0';
    DECLARE var_invoice_details_part VarChar(4000);
    DECLARE OUT_STATUS_2 VarChar(20);
    DECLARE OUT_STATUS_3 VarChar(20);
    DECLARE ALL_SUCCESS INT DEFAULT 0;
    DECLARE ALL_SUCCESS_2 INT DEFAULT 0;
    DECLARE ALL_SUCCESS_3 INT DEFAULT 0;

    DECLARE cur_PROC_SC_PACKAGING_LIST_INV_STOCK
        CURSOR FOR
        SELECT
            BOX_SERIAL,F_BOX_NO
            FROM SC_SHIPMENT_BOX
            WHERE F_SHIPMENT_NO=SHIPMENT_NO;


        DECLARE CONTINUE HANDLER
            FOR NOT FOUND SET int_HAS_cur_PROC_SC_PACKAGING_LIST_INV_STOCK = 0;

            /*DELETING EXISTING VALUE*/

            IF IS_UPDATE = 1 THEN
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
            END IF;
        /*DELETING EXISTING VALUE End*/


/* DELETE FROM R; */
INSERT INTO R VALUES('Start Procedre');
INSERT INTO R VALUES(concat('SHIPMENT_NO ', SHIPMENT_NO));
            SELECT COUNT(F_SHIPMENT_NO) INTO int_is_duplicate_shipment FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;
            SELECT COUNT(F_BOX_NO) INTO int_box_row_count FROM SC_SHIPMENT_BOX WHERE F_SHIPMENT_NO = SHIPMENT_NO;
INSERT INTO R VALUES(concat('Duplicate package Flag ', int_is_duplicate_shipment));

        IF int_is_duplicate_shipment = 0 THEN

            SELECT CODE INTO shipment_name FROM SC_SHIPMENT WHERE PK_NO = SHIPMENT_NO;

INSERT INTO R VALUES(concat('SHIPMENT_NAME ', shipment_name));

                SET int_HAS_cur_PROC_SC_PACKAGING_LIST_INV_STOCK = 1;

                OPEN cur_PROC_SC_PACKAGING_LIST_INV_STOCK;
                SELECT FOUND_ROWS() into int_row_count ;

                insert into R values (concat('Found row before Loop ', int_row_count));


                    IF int_row_count  != 0 THEN

                    get_PROC_SC_PACKAGING_LIST_INV_STOCK:LOOP
                        FETCH NEXT FROM  cur_PROC_SC_PACKAGING_LIST_INV_STOCK INTO box_serial_no,box_no;

                        SELECT IFNULL(WIDTH_CM,46),IFNULL(LENGTH_CM,46),IFNULL(HEIGHT_CM,78),IFNULL(WEIGHT_KG,30) INTO int_width,int_length,int_height,int_weight FROM SC_BOX WHERE PK_NO = box_no;
INSERT INTO R VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SC_PACKAGING_LIST_INV_STOCK));

                        IF int_HAS_cur_PROC_SC_PACKAGING_LIST_INV_STOCK = 0 THEN
                                LEAVE get_PROC_SC_PACKAGING_LIST_INV_STOCK;
                            END IF;


INSERT INTO R VALUES(concat('Box Serial ', box_serial_no) );
INSERT INTO R VALUES(concat('Box No ', box_no) );
                    SET ALL_SUCCESS = ALL_SUCCESS + 1;

                    insert into R values (concat('ALL SUCCESS VAL ', ALL_SUCCESS));




            /*-------------------------BLOCK 3 BEGINS ------------------------------*/
            Block3: BEGIN
                    DECLARE int_HAS_cur_PRC_STOCK_INING_LIST_INV_STOCK INT DEFAULT 1;

                    DECLARE cur_PROC_PRC_STOCK_IN_INV_STOCK
                    CURSOR FOR
                    SELECT p.VENDOR_NAME,p.INVOICE_DATE,p.INVOICE_NO,INV_STOCK.F_PRC_STOCK_IN_NO AS prc_no,
                    (SELECT COUNT(*)FROM  INV_STOCK where F_BOX_NO = box_no and F_PRC_STOCK_IN_NO = prc_no) AS PRODUCT_COUNT
                    FROM PRC_STOCK_IN AS p
                    JOIN INV_STOCK ON p.PK_NO=INV_STOCK.F_PRC_STOCK_IN_NO
                    WHERE INV_STOCK.F_BOX_NO=box_no
                    group by F_PRC_STOCK_IN_NO;


                    DECLARE CONTINUE HANDLER
                        FOR NOT FOUND SET int_HAS_cur_PRC_STOCK_INING_LIST_INV_STOCK = 0;

                    OPEN cur_PROC_PRC_STOCK_IN_INV_STOCK;
                        SELECT FOUND_ROWS() into int_row_count_cursor3 ;
                        insert into R values (concat('Found row3 before Loop ', int_row_count_cursor3));
                            IF int_row_count_cursor3 != 0 THEN

                                get_PROC_PRC_STOCK_IN_INV_STOCK:LOOP
                                    FETCH NEXT FROM  cur_PROC_PRC_STOCK_IN_INV_STOCK INTO vendor_name,invoice_date,invoice_no,int_prc_no,int_product_count_invoice;

                                INSERT INTO R VALUES(concat('Loop Control var ', int_HAS_cur_PRC_STOCK_INING_LIST_INV_STOCK));

                                            IF int_HAS_cur_PRC_STOCK_INING_LIST_INV_STOCK = 0 THEN

                                                    LEAVE get_PROC_PRC_STOCK_IN_INV_STOCK;
                                            END IF;


                                INSERT INTO R VALUES(concat('product count ', int_product_count_invoice) );
                                        SET ALL_SUCCESS_3 = ALL_SUCCESS_3 + 1;

                                        insert into R values (concat('ALL SUCCESS_2 VAL ', ALL_SUCCESS_3));

                                        SELECT concat(vendor_name,' ',invoice_date,' ',invoice_no,'(',int_product_count_invoice,')') INTO var_invoice_details_part;

                                        insert into R values (concat('var_invoice_details_part ', var_invoice_details_part));
                                        insert into R values (concat('var_invoice_details b_IF ', var_invoice_details));
                                        IF var_invoice_details = '0' THEN
                                           SET var_invoice_details = var_invoice_details_part;
                                           SET invoice_pk_no = int_prc_no;
                                           insert into R values (concat('var_invoice_details is 0 ', var_invoice_details));

                                        ELSE

                                           SELECT concat(var_invoice_details,', ',var_invoice_details_part) INTO var_invoice_details;
                                           SELECT concat(invoice_pk_no,', ',int_prc_no) INTO invoice_pk_no;
                                           insert into R values (concat('var_invoice_details_part ', var_invoice_details_part));
                                           insert into R values (concat('var_invoice_details ', var_invoice_details));
                                        END IF;



                                END LOOP get_PROC_PRC_STOCK_IN_INV_STOCK;

                            END IF;


                    CLOSE cur_PROC_PRC_STOCK_IN_INV_STOCK;

                    insert into R values (concat('OUT_STATUS_3 VAL ', ALL_SUCCESS_3));
                    insert into R values (concat('Row count 3 VAL ', int_row_count_cursor3));
                    IF ALL_SUCCESS_3 = int_row_count_cursor3 THEN
                        SET OUT_STATUS_3 = 'success';
                        INSERT INTO SC_PACKAGING_LIST( F_SHIPMENT_NO, SHIPMENT_NAME, BOX_SERIAL_NO, F_BOX_NO, WIDTH_CM, LENGTH_CM, HEIGHT_CM, WEIGHT_KG,INVOICE_DETAILS,INVOICE_NO) VALUES ( SHIPMENT_NO, shipment_name, box_serial_no, box_no, int_width, int_length, int_height, int_weight,var_invoice_details,invoice_pk_no );
                        SET var_invoice_details = '0';
                        SET invoice_pk_no = '0';
                    ELSE
                        SET OUT_STATUS_3 = 'failed';
                        SET ALL_SUCCESS = 99;
                        DELETE FROM SC_PACKING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;
                        DELETE FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;

                    END IF;
                    SET ALL_SUCCESS_3 = 0;

            END Block3;

            /*-------------------------BLOCK 3 ENDS ------------------------------*/



            /*-------------------------BLOCK 2 BEGINS ------------------------------*/
            Block2: BEGIN
                    DECLARE int_HAS_cur_PROC_SC_PACKING_LIST_INV_STOCK INT DEFAULT 1;

                    DECLARE cur_PROC_SC_PACKING_LIST_INV_STOCK
                    CURSOR FOR
                    SELECT
                        F_PRD_VARIANT_NO,HS_CODE,SKUID,IG_CODE,SUB_CATEGORY_NAME,INVOICE_NAME,SUM(PRODUCT_PURCHASE_PRICE_GBP) AS int_count_price,COUNT(PK_NO) AS int_product_count
                        FROM INV_STOCK
                        WHERE F_BOX_NO=box_no
                        GROUP BY SKUID;


                    DECLARE CONTINUE HANDLER
                        FOR NOT FOUND SET int_HAS_cur_PROC_SC_PACKING_LIST_INV_STOCK = 0;

                    OPEN cur_PROC_SC_PACKING_LIST_INV_STOCK;
                        SELECT FOUND_ROWS() into int_row_count_cursor2 ;
                        insert into R values (concat('Found row2 before Loop ', int_row_count_cursor2));
                            IF int_row_count_cursor2  != 0 THEN

                                get_PROC_SC_PACKING_LIST_INV_STOCK:LOOP
                                    FETCH NEXT FROM  cur_PROC_SC_PACKING_LIST_INV_STOCK INTO variant_no,var_hs_code,sku_id,var_ig_code,sub_cat_name,var_invoice_name,int_count_price,int_product_count;

                                INSERT INTO R VALUES(concat('Loop Control var ', int_HAS_cur_PROC_SC_PACKING_LIST_INV_STOCK));

                                            IF int_HAS_cur_PROC_SC_PACKING_LIST_INV_STOCK = 0 THEN

                                                    LEAVE get_PROC_SC_PACKING_LIST_INV_STOCK;
                                            END IF;


                                INSERT INTO R VALUES(concat('Price ', int_count_price) );
                                INSERT INTO R VALUES(concat('Product Count ', int_product_count) );
                                        SET ALL_SUCCESS_2 = ALL_SUCCESS_2 + 1;

                                        SET unit_price = int_count_price/int_product_count;

                                        insert into R values (concat('ALL SUCCESS_2 VAL ', ALL_SUCCESS_2));

                                        INSERT INTO SC_PACKING_LIST( F_SHIPMENT_NO, SHIPMENT_NAME, BOX_SERIAL_NO, F_BOX_NO, PRD_VARINAT_NO, HS_CODE, SKU_ID, IG_CODE, SUBCATEGORY_NAME, PRC_INV_NAME, QTY, UNIT_PRICE, TOTAL_PRICE) VALUES ( SHIPMENT_NO, shipment_name, box_serial_no, box_no, variant_no, var_hs_code, sku_id, var_ig_code, sub_cat_name, var_invoice_name, int_product_count, unit_price, int_count_price );


                                END LOOP get_PROC_SC_PACKING_LIST_INV_STOCK;

                            END IF;


                    CLOSE cur_PROC_SC_PACKING_LIST_INV_STOCK;

                    insert into R values (concat('OUT_STATUS_2 VAL ', ALL_SUCCESS_2));
                    insert into R values (concat('Row count 2 VAL ', int_row_count_cursor2));
                    IF ALL_SUCCESS_2 = int_row_count_cursor2 THEN
                        SET OUT_STATUS_2 = 'success';
                    ELSE
                        SET OUT_STATUS_2 = 'failed';
                        SET ALL_SUCCESS = 99;
                        DELETE FROM SC_PACKING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;
                        DELETE FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;

                    END IF;
                    SET ALL_SUCCESS_2 = 0;

            END Block2;

                    END LOOP get_PROC_SC_PACKAGING_LIST_INV_STOCK;

                    END IF;

                CLOSE cur_PROC_SC_PACKAGING_LIST_INV_STOCK;

                  IF ALL_SUCCESS = int_box_row_count AND OUT_STATUS_2 = 'success' AND OUT_STATUS_3 = 'success' THEN
                     SET OUT_STATUS = 'success';
                   ELSE
                     SET OUT_STATUS = 'failed';
                     DELETE FROM SC_PACKAGING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;
                     DELETE FROM SC_PACKING_LIST WHERE F_SHIPMENT_NO = SHIPMENT_NO;
                   END IF;


        ELSE
           SET OUT_STATUS = 'duplicate-shipment';

        END IF;

INSERT INTO R VALUES(concat('End of Procedure with status ', OUT_STATUS));

END Block1
/
