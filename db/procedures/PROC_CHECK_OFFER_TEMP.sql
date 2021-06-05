DELIMITER $$


DROP PROCEDURE IF EXISTS `PROC_SLS_CHECK_OFFER_TEMP`$$

CREATE  PROCEDURE `PROC_SLS_CHECK_OFFER_TEMP`(IN_BOOKING_PK_NO INTEGER)
    NO SQL
BLOCKPARENT: BEGIN

        DECLARE xF_BOOKING_NO       INT;
        DECLARE xF_BUNDLE_NO        INT DEFAULT 0;
        DECLARE xF_LIST_NO          INT DEFAULT 0;
        DECLARE xF_LIST_CHILD_NO    INT DEFAULT 0;
        DECLARE xIS_A_LIST          INT DEFAULT 0;
        DECLARE xF_PRD_VARIANT_NO   INT;
        DECLARE xREGULAR_PRICE      FLOAT(0);
        DECLARE xINSTALLMENT_PRICE  FLOAT(0);
        DECLARE xF_INV_STOCK_NO     INT;
        DECLARE var_IS_A_LIST       INT(1);
        DECLARE xINT_HAS_IN_LIST_A  INT DEFAULT 0;
        DECLARE xINT_HAS_IN_LIST_B  INT DEFAULT 0;
        DECLARE xLIST_NO            INT DEFAULT NULL;
        DECLARE xLIST_DTL_NO        INT DEFAULT NULL;
        DECLARE xLIST               VARCHAR(40) DEFAULT NULL;

        DECLARE vSLS_CHECK_OFFER_NO INT;
        DECLARE vF_BUNDLE_NO INT;
        DECLARE vF_BOOKING_NO INT;
        DECLARE vF_LIST_NO INT;
        DECLARE vF_LIST_CHILD_NO INT;
        DECLARE vIS_A_LIST INT;
        DECLARE vF_VARIANT_NO INT;
        DECLARE vREGULAR_PRICE FLOAT(0);
        DECLARE vINSTALLMENT_PRICE FLOAT(0);
        DECLARE vF_INV_STOCK_NO INT;
        DECLARE vLIST_TYPE VARCHAR(40) DEFAULT NULL;
        DECLARE vREGULAR_BUNDLE_PRICE FLOAT(0);
        DECLARE vINSTALLMENT_BUNDLE_PRICE FLOAT(0);
        DECLARE vIS_PROCESSED INT;
        DECLARE vSLS_BUNDLE_NO INT;
        DECLARE vCODE VARCHAR(40) DEFAULT NULL;
        DECLARE vCOUPON_CODE VARCHAR(40) DEFAULT NULL;
        DECLARE vBUNDLE_NAME VARCHAR(200) DEFAULT NULL;
        DECLARE vBUNDLE_NAME_PUBLIC VARCHAR(200) DEFAULT NULL;
        DECLARE vVALIDITY_FROM DATE DEFAULT NULL;
        DECLARE vVALIDITY_TO DATE DEFAULT NULL;
        DECLARE vF_A_LIST_NO INT;
        DECLARE vF_B_LIST_NO INT;
        DECLARE vF_BUNDLE_TYPE VARCHAR(40) DEFAULT NULL;
        DECLARE vP_AMOUNT FLOAT(0);
        DECLARE vP2_AMOUNT FLOAT(0);
        DECLARE vX1_QTY INT;
        DECLARE vX2_QTY INT;
        DECLARE vZA1 INT;
        DECLARE vZA2 INT;
        DECLARE vZA3 INT;
        DECLARE vR_AMOUNT FLOAT(0);
        DECLARE vR2_AMOUNT FLOAT(0);
        DECLARE vY1_QTY INT;
        DECLARE vY2_QTY INT;
        DECLARE vZB1 INT;
        DECLARE vZB2 INT;
        DECLARE vZB3 INT;
        DECLARE cvSLS_CHECK_OFFER_NO INT;
        DECLARE cvF_BUNDLE_NO INT;
        DECLARE cvF_BOOKING_NO INT;



        DECLARE int_row_count INT;
        DECLARE int_row_count2 INT;
        DECLARE int_row_count3 INT;
        DECLARE COUNTER1 INT DEFAULT 1;
        DECLARE COUNTER2 INT DEFAULT 1;
        DECLARE COUNTER3 INT DEFAULT 1;

Block1: BEGIN
        DECLARE COUNTER1 INT DEFAULT 1;
        DECLARE INT_HAS_CUR_PROC_SLS_BOOKING INT DEFAULT 1;
        /*Data tranfered to SLS_CHECK_OFFER */

        DECLARE CUR_PROC_SLS_BOOKING
            CURSOR FOR
                SELECT
                    SLS_BOOKING_DETAILS_TEMP.F_BOOKING_NO
                    ,SLS_BOOKING_DETAILS_TEMP.F_INV_STOCK_NO
                    ,SLS_BOOKING_DETAILS_TEMP.CURRENT_REGULAR_PRICE
                    ,SLS_BOOKING_DETAILS_TEMP.CURRENT_INSTALLMENT_PRICE
                    ,INV_STOCK.F_PRD_VARIANT_NO
                    ,SLS_BUNDLE_PRIMARY_SET.PK_NO AS LIST_NO
                    ,SLS_BUNDLE_PRIMARY_SET_DTL.PK_NO AS LIST_DTL_NO
                    ,SLS_BUNDLE.PK_NO AS BUNDLE_PK_NO
                    ,'A' AS LIST

                FROM
                    SLS_BOOKING_DETAILS_TEMP
                    ,INV_STOCK
                    ,SLS_BUNDLE_PRIMARY_SET_DTL
                    ,SLS_BUNDLE_PRIMARY_SET
                    ,SLS_BUNDLE

                WHERE SLS_BOOKING_DETAILS_TEMP.F_BOOKING_NO = IN_BOOKING_PK_NO
                    AND INV_STOCK.PK_NO = SLS_BOOKING_DETAILS_TEMP.F_INV_STOCK_NO
                    AND SLS_BUNDLE_PRIMARY_SET_DTL.F_PRD_VARIANT_NO = INV_STOCK.F_PRD_VARIANT_NO
                    AND SLS_BUNDLE_PRIMARY_SET.PK_NO = SLS_BUNDLE_PRIMARY_SET_DTL.F_SLS_BUNDLE_PRIMARY_SET_NO
                    AND SLS_BUNDLE.F_A_LIST_NO = SLS_BUNDLE_PRIMARY_SET.PK_NO
                    AND CURDATE() BETWEEN SLS_BUNDLE.VALIDITY_FROM AND SLS_BUNDLE.VALIDITY_TO
                    AND SLS_BUNDLE.STATUS = 1
                UNION

                SELECT
                    SLS_BOOKING_DETAILS_TEMP.F_BOOKING_NO
                    ,SLS_BOOKING_DETAILS_TEMP.F_INV_STOCK_NO
                    ,SLS_BOOKING_DETAILS_TEMP.CURRENT_REGULAR_PRICE
                    ,SLS_BOOKING_DETAILS_TEMP.CURRENT_INSTALLMENT_PRICE
                    ,INV_STOCK.F_PRD_VARIANT_NO
                    ,SLS_BUNDLE_SECONDARY_SET.PK_NO AS LIST_NO
                    ,SLS_BUNDLE_SECONDARY_SET_DTL.PK_NO AS LIST_DTL_NO
                    ,SLS_BUNDLE.PK_NO AS BUNDLE_PK_NO
                    ,'B' AS LIST

                FROM
                    SLS_BOOKING_DETAILS_TEMP
                    ,INV_STOCK
                    ,SLS_BUNDLE_SECONDARY_SET_DTL
                    ,SLS_BUNDLE_SECONDARY_SET
                    ,SLS_BUNDLE

                WHERE SLS_BOOKING_DETAILS_TEMP.F_BOOKING_NO = IN_BOOKING_PK_NO
                AND INV_STOCK.PK_NO = SLS_BOOKING_DETAILS_TEMP.F_INV_STOCK_NO
                AND SLS_BUNDLE_SECONDARY_SET_DTL.F_PRD_VARIANT_NO = INV_STOCK.F_PRD_VARIANT_NO
                AND SLS_BUNDLE_SECONDARY_SET.PK_NO = SLS_BUNDLE_SECONDARY_SET_DTL.F_SLS_BUNDLE_SECONDARY_SET_NO
                AND SLS_BUNDLE.F_B_LIST_NO = SLS_BUNDLE_SECONDARY_SET.PK_NO
                AND CURDATE() BETWEEN SLS_BUNDLE.VALIDITY_FROM AND SLS_BUNDLE.VALIDITY_TO
                AND SLS_BUNDLE.STATUS = 1
                ;


        DECLARE CONTINUE HANDLER

            FOR NOT FOUND SET INT_HAS_CUR_PROC_SLS_BOOKING = 0;
DELETE FROM SLS_CHECK_OFFER WHERE F_BOOKING_NO = IN_BOOKING_PK_NO;
DELETE FROM S;
-- INSERT INTO S VALUES('Line 26');

            OPEN CUR_PROC_SLS_BOOKING;
                SELECT FOUND_ROWS() INTO int_row_count ;

-- INSERT INTO S values ('Line 32');
-- INSERT INTO S values (concat('Found row ', int_row_count));

                IF int_row_count > 0 THEN

                    GET_PROC_SLS_BOOKING: LOOP
                        FETCH NEXT
                        FROM  CUR_PROC_SLS_BOOKING
                            INTO
                            xF_BOOKING_NO
                            ,xF_INV_STOCK_NO
                            ,xREGULAR_PRICE
                            ,xINSTALLMENT_PRICE
                            ,xF_PRD_VARIANT_NO
                            ,xLIST_NO
                            ,xLIST_DTL_NO
                            ,xF_BUNDLE_NO
                            ,xLIST
                            ;

                            IF INT_HAS_CUR_PROC_SLS_BOOKING = 0 THEN
                            LEAVE GET_PROC_SLS_BOOKING;
                            END IF;

-- INSERT INTO S VALUES('line 48');


                            INSERT INTO SLS_CHECK_OFFER(
                            F_BOOKING_NO
                            ,F_BUNDLE_NO
                            ,F_LIST_NO
                            ,F_LIST_CHILD_NO
                            ,LIST_TYPE
                            ,F_VARIANT_NO
                            ,REGULAR_PRICE
                            ,INSTALLMENT_PRICE
                            ,F_INV_STOCK_NO
                            ,IS_TEMP
                            )
                            VALUES (
                            xF_BOOKING_NO
                            ,xF_BUNDLE_NO
                            ,xLIST_NO
                            ,xLIST_DTL_NO
                            ,xLIST
                            ,xF_PRD_VARIANT_NO
                            ,xREGULAR_PRICE
                            ,xINSTALLMENT_PRICE
                            ,xF_INV_STOCK_NO
                            ,1
                            );



                    END LOOP GET_PROC_SLS_BOOKING;

                END IF;

            CLOSE CUR_PROC_SLS_BOOKING;

END Block1;

Block2: BEGIN
            DECLARE COUNTER2 INT DEFAULT 1;
            DECLARE INT_HAS_CUR_SLS_CHECK_OFFER_RESULT INT DEFAULT 1;

            /* OFFER RESULT  */
            DECLARE CUR_SLS_CHECK_OFFER_RESULT
                CURSOR FOR
                SELECT
                    SLS_CHECK_OFFER.PK_NO AS SLS_CHECK_OFFER_NO
                    ,SLS_CHECK_OFFER.F_BUNDLE_NO
                    ,SLS_CHECK_OFFER.F_BOOKING_NO
                    ,SLS_CHECK_OFFER.F_LIST_NO
                    ,SLS_CHECK_OFFER.F_LIST_CHILD_NO
                    ,SLS_CHECK_OFFER.IS_A_LIST
                    ,SLS_CHECK_OFFER.F_VARIANT_NO
                    ,SLS_CHECK_OFFER.REGULAR_PRICE
                    ,SLS_CHECK_OFFER.INSTALLMENT_PRICE
                    ,SLS_CHECK_OFFER.F_INV_STOCK_NO
                    ,SLS_CHECK_OFFER.LIST_TYPE
                    ,SLS_CHECK_OFFER.REGULAR_BUNDLE_PRICE
                    ,SLS_CHECK_OFFER.INSTALLMENT_BUNDLE_PRICE
                    ,SLS_CHECK_OFFER.IS_PROCESSED
                    ,SLS_BUNDLE.CODE
                    ,SLS_BUNDLE.COUPON_CODE
                    ,SLS_BUNDLE.BUNDLE_NAME
                    ,SLS_BUNDLE.BUNDLE_NAME_PUBLIC
                    ,SLS_BUNDLE.VALIDITY_FROM
                    ,SLS_BUNDLE.VALIDITY_TO
                    ,SLS_BUNDLE.F_A_LIST_NO
                    ,SLS_BUNDLE.F_B_LIST_NO
                    ,SLS_BUNDLE.F_BUNDLE_TYPE
                    ,SLS_BUNDLE.P_AMOUNT
                    ,SLS_BUNDLE.P2_AMOUNT
                    ,SLS_BUNDLE.X1_QTY
                    ,SLS_BUNDLE.X2_QTY
                    ,SLS_BUNDLE.ZA1
                    ,SLS_BUNDLE.ZA2
                    ,SLS_BUNDLE.ZA3
                    ,SLS_BUNDLE.R_AMOUNT
                    ,SLS_BUNDLE.R2_AMOUNT
                    ,SLS_BUNDLE.Y1_QTY
                    ,SLS_BUNDLE.Y2_QTY
                    ,SLS_BUNDLE.ZB1
                    ,SLS_BUNDLE.ZB2
                    ,SLS_BUNDLE.ZB3
                FROM SLS_CHECK_OFFER
                    ,SLS_BUNDLE
                WHERE SLS_CHECK_OFFER.F_BOOKING_NO = IN_BOOKING_PK_NO
                    AND SLS_CHECK_OFFER.F_BUNDLE_NO = SLS_BUNDLE.PK_NO
                GROUP BY SLS_CHECK_OFFER.F_BUNDLE_NO
                 ;


                DECLARE CONTINUE HANDLER

                FOR NOT FOUND SET INT_HAS_CUR_SLS_CHECK_OFFER_RESULT = 0;

DELETE FROM S;
-- INSERT INTO S VALUES('Line 125');

                OPEN CUR_SLS_CHECK_OFFER_RESULT;
                    SELECT FOUND_ROWS() INTO int_row_count2 ;

-- INSERT INTO S values ('Line 130');
-- INSERT INTO S values (concat('Found row parent ', int_row_count2));

                    IF int_row_count2 > 0 THEN

                        GET_CUR_SLS_CHECK_OFFER_RESULT: LOOP
                            FETCH NEXT
                                FROM  CUR_SLS_CHECK_OFFER_RESULT
                                    INTO
                                vSLS_CHECK_OFFER_NO
                                ,vF_BUNDLE_NO
                                ,vF_BOOKING_NO
                                ,vF_LIST_NO
                                ,vF_LIST_CHILD_NO
                                ,vIS_A_LIST
                                ,vF_VARIANT_NO
                                ,vREGULAR_PRICE
                                ,vINSTALLMENT_PRICE
                                ,vF_INV_STOCK_NO
                                ,vLIST_TYPE
                                ,vREGULAR_BUNDLE_PRICE
                                ,vINSTALLMENT_BUNDLE_PRICE
                                ,vIS_PROCESSED
                                ,vCODE
                                ,vCOUPON_CODE
                                ,vBUNDLE_NAME
                                ,vBUNDLE_NAME_PUBLIC
                                ,vVALIDITY_FROM
                                ,vVALIDITY_TO
                                ,vF_A_LIST_NO
                                ,vF_B_LIST_NO
                                ,vF_BUNDLE_TYPE
                                ,vP_AMOUNT
                                ,vP2_AMOUNT
                                ,vX1_QTY
                                ,vX2_QTY
                                ,vZA1
                                ,vZA2
                                ,vZA3
                                ,vR_AMOUNT
                                ,vR2_AMOUNT
                                ,vY1_QTY
                                ,vY2_QTY
                                ,vZB1
                                ,vZB2
                                ,vZB3
                                ;

                                IF INT_HAS_CUR_SLS_CHECK_OFFER_RESULT = 0 THEN
                                    LEAVE GET_CUR_SLS_CHECK_OFFER_RESULT;
                                END IF;

        Block3: BEGIN
            DECLARE COUNTER3 INT DEFAULT 1;
            DECLARE COUNTER9 INT DEFAULT 1;
            DECLARE COUNTER10 INT DEFAULT 1;
            DECLARE INT_HAS_CUR_SLS_CHECK_OFFER_RESULT_ROW INT DEFAULT 1;

            DECLARE CUR_SLS_CHECK_OFFER_RESULT_ROW
            CURSOR FOR
                SELECT
                SLS_CHECK_OFFER.PK_NO AS SLS_CHECK_OFFER_NO
                ,SLS_CHECK_OFFER.F_BUNDLE_NO
                ,SLS_CHECK_OFFER.F_BOOKING_NO
                --    ,SLS_CHECK_OFFER.F_LIST_NO
                --  ,SLS_CHECK_OFFER.F_LIST_CHILD_NO
                --  ,SLS_CHECK_OFFER.IS_A_LIST
                --  ,SLS_CHECK_OFFER.F_VARIANT_NO
                --  ,SLS_CHECK_OFFER.REGULAR_PRICE
                --  ,SLS_CHECK_OFFER.INSTALLMENT_PRICE
                --  ,SLS_CHECK_OFFER.F_INV_STOCK_NO
                --  ,SLS_CHECK_OFFER.LIST_TYPE
                -- ,SLS_CHECK_OFFER.REGULAR_BUNDLE_PRICE
                --  ,SLS_CHECK_OFFER.INSTALLMENT_BUNDLE_PRICE
                -- ,SLS_CHECK_OFFER.IS_PROCESSED

                FROM SLS_CHECK_OFFER
                WHERE SLS_CHECK_OFFER.F_BUNDLE_NO = vF_BUNDLE_NO
                AND SLS_CHECK_OFFER.F_BOOKING_NO = vF_BOOKING_NO;


                DECLARE CONTINUE HANDLER
                FOR NOT FOUND SET INT_HAS_CUR_SLS_CHECK_OFFER_RESULT_ROW = 0;


-- INSERT INTO S VALUES('Line 224');

                OPEN CUR_SLS_CHECK_OFFER_RESULT_ROW;

                    SELECT FOUND_ROWS() INTO int_row_count3 ;

-- INSERT INTO S values ('Line 229');
-- INSERT INTO S values (concat('Found row ', int_row_count3));

                    IF int_row_count3 > 0 THEN

-- INSERT INTO S values ('Line 2331');
-- INSERT INTO S values (INT_HAS_CUR_SLS_CHECK_OFFER_RESULT_ROW);

                        GET_CUR_SLS_CHECK_OFFER_RESULT_ROW: LOOP
                            FETCH NEXT
                                FROM  CUR_SLS_CHECK_OFFER_RESULT_ROW
                                    INTO
                                    cvSLS_CHECK_OFFER_NO
                                    ,cvF_BUNDLE_NO
                                    ,cvF_BOOKING_NO

                                ;
-- INSERT INTO S values ('Line 251');
                                IF INT_HAS_CUR_SLS_CHECK_OFFER_RESULT_ROW = 0 THEN
                                    LEAVE GET_CUR_SLS_CHECK_OFFER_RESULT_ROW;
                                END IF;


-- INSERT INTO S values (concat('when_', vP_AMOUNT));
-- INSERT INTO S values (concat('when1_', vX1_QTY));
-- INSERT INTO S values (concat('when2_', vZA1));


                            IF vP_AMOUNT = 0 AND vX1_QTY = 0  AND vZA1 = 0 THEN
                            -- universal false
                                UPDATE SLS_CHECK_OFFER
                                    SET
                                    REGULAR_BUNDLE_PRICE = vREGULAR_BUNDLE_PRICE
                                    ,INSTALLMENT_BUNDLE_PRICE = vINSTALLMENT_BUNDLE_PRICE
                                    ,IS_PROCESSED = 1
                                    ,CON = 1
                                WHERE PK_NO = cvSLS_CHECK_OFFER_NO AND IS_PROCESSED = 0 AND F_BOOKING_NO = IN_BOOKING_PK_NO ;
INSERT INTO S VALUES (CONCAT('con 1_',cvSLS_CHECK_OFFER_NO));

                            ELSEIF vP_AMOUNT = 0 AND vX1_QTY = 0 AND vZA1 > 0 THEN
                             -- Buy any item at 20%;
INSERT INTO S VALUES (CONCAT('con 2_',cvSLS_CHECK_OFFER_NO));
-- INSERT INTO S values (CONCAT('con IP',xREGULAR_PRICE));
-- INSERT INTO S values (CONCAT('con RP',xINSTALLMENT_PRICE));

                                UPDATE SLS_CHECK_OFFER
                                    SET
                                    REGULAR_BUNDLE_PRICE = xREGULAR_PRICE - (xREGULAR_PRICE/100)*vZA1
                                    ,INSTALLMENT_BUNDLE_PRICE = xINSTALLMENT_PRICE - (xINSTALLMENT_PRICE/100)*vZA1
                                    ,IS_PROCESSED = 1
                                    ,SEQUENC = COUNTER2
                                    ,CON = 2
                                WHERE SLS_CHECK_OFFER.PK_NO = cvSLS_CHECK_OFFER_NO
                                AND IS_PROCESSED = 0
                                AND LIST_TYPE = 'A'
                                AND F_BUNDLE_NO = vF_BUNDLE_NO
                                AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                ;

                                SET COUNTER2 = COUNTER2+1;

                            ELSEIF vP_AMOUNT = 0 AND vX1_QTY > 0 AND vZA1 = 0 THEN
                            -- buy 1 get 1, buy 2 get 1, buy 1 get 2, buy 1 get 1 half price from A list
INSERT INTO S VALUES (CONCAT('con 3_',cvSLS_CHECK_OFFER_NO));
                                SELECT COUNT(*) INTO @ALIST FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ;

                                    IF @ALIST >= vX1_QTY THEN
        --  INSERT INTO S values (CONCAT('LINE_',422));
        --  INSERT INTO S values (CONCAT('RR',@ALIST));
        --  INSERT INTO S values (CONCAT('SS',vX1_QTY));
                                        SELECT COUNT(*) INTO @BLIST FROM SLS_CHECK_OFFER
                                            WHERE IS_PROCESSED = 0
                                            AND LIST_TYPE = 'B'
                                            AND F_BUNDLE_NO = vF_BUNDLE_NO
                                            AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                            ;

                                            IF @BLIST >= vY1_QTY THEN

                                                UPDATE SLS_CHECK_OFFER
                                                    SET
                                                    REGULAR_BUNDLE_PRICE = xREGULAR_PRICE
                                                    ,INSTALLMENT_BUNDLE_PRICE = xINSTALLMENT_PRICE
                                                    ,IS_PROCESSED = 1
                                                    ,SEQUENC = COUNTER1
                                                    ,CON = 31
                                                    WHERE IS_PROCESSED = 0
                                                    AND LIST_TYPE = 'A'
                                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                                    LIMIT vX1_QTY
                                                    ;

                                                UPDATE SLS_CHECK_OFFER
                                                    SET REGULAR_BUNDLE_PRICE = xREGULAR_PRICE - (xREGULAR_PRICE/100)*vZB1
                                                    ,INSTALLMENT_BUNDLE_PRICE = xINSTALLMENT_PRICE - (xINSTALLMENT_PRICE/100)*vZB1
                                                    ,IS_PROCESSED = 1
                                                    ,SEQUENC = COUNTER1
                                                    ,CON = 32
                                                    WHERE IS_PROCESSED = 0
                                                    AND LIST_TYPE = 'B'
                                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                                    LIMIT vY1_QTY ;



                                                 SET COUNTER1 = COUNTER1+1;

                                            END IF;


                                    END IF;


                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY = 0 AND vZA1 = 0 THEN
                            -- Buy min 500 amt from A list get 2 free from B list, buy min 500 amt get 1 half price;

INSERT INTO S VALUES (CONCAT('con 4_',COUNTER1));

                                SELECT SUM(REGULAR_PRICE), SUM(INSTALLMENT_PRICE)
                                    INTO @TOTAL_P_AMOUNT, @TOTAL_P2_AMOUNT
                                    FROM SLS_CHECK_OFFER
                                WHERE IS_PROCESSED = 0
                                AND LIST_TYPE = 'A'
                                AND F_BUNDLE_NO = vF_BUNDLE_NO
                                AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                ;

                                IF @TOTAL_P_AMOUNT >= vP_AMOUNT THEN

                                    SELECT COUNT(*) INTO @TOTAL_FREE_QTY_FOR_vP_AMOUNT FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'B'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ;

                                    IF @TOTAL_FREE_QTY_FOR_vP_AMOUNT > 0  THEN
                                            UPDATE SLS_CHECK_OFFER
                                                SET
                                                REGULAR_BUNDLE_PRICE = REGULAR_BUNDLE_PRICE
                                                ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_BUNDLE_PRICE
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = 1
                                                ,CON = 41
                                            WHERE IS_PROCESSED = 0
                                            AND LIST_TYPE = 'A'
                                            AND F_BUNDLE_NO = vF_BUNDLE_NO
                                            AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                            ;

                                            UPDATE SLS_CHECK_OFFER
                                                SET REGULAR_BUNDLE_PRICE = xREGULAR_PRICE - (xREGULAR_PRICE/100)*vZB1
                                                ,INSTALLMENT_BUNDLE_PRICE = xINSTALLMENT_PRICE - (xINSTALLMENT_PRICE/100)*vZB1
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = 1
                                                ,CON = 42
                                            WHERE IS_PROCESSED = 0
                                            AND LIST_TYPE = 'B'
                                            AND F_BUNDLE_NO = vF_BUNDLE_NO
                                            AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                            LIMIT vY1_QTY ;

                                    END IF;

                                    IF vZA1 > 0 THEN
                                        -- buy 500amt or above from A list and get 20% discount
                                        UPDATE SLS_CHECK_OFFER
                                            SET REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA1
                                            ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA1
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = 1
                                            ,CON = 43
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ;

                                    END IF;


                                END IF;



                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY > 0 AND vZA1 > 0 THEN

                            -- not possible
 INSERT INTO S VALUES (CONCAT('con 5_',cvSLS_CHECK_OFFER_NO));

                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY > 0 AND vZA1 = 0 AND vX2_QTY = 0 AND vR_AMOUNT = 0 AND vY1_QTY = 0 THEN
                            -- buy any lowest priced 6 item from A list at 800 amt;
                            -- buy any lowest priced 6 item A list at 800 amt more item at 50% discount;

                                IF vZA2 > 0 THEN
                            -- buy any lowest priced 6 item A list at 800 amt more item at 50% discount;
INSERT INTO S VALUES (CONCAT('con 6_A',cvSLS_CHECK_OFFER_NO));
                                    SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY
                                        INTO @TOTAL_P_AMOUNT_CON6, @TOTAL_X1_QTY_CON6
                                        FROM SLS_CHECK_OFFER
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC
                                        LIMIT vX1_QTY ;

                                    IF @TOTAL_P_AMOUNT_CON6 >= vP_AMOUNT AND @TOTAL_X1_QTY_CON6 >= vX1_QTY THEN

                                        UPDATE SLS_CHECK_OFFER
                                            SET REGULAR_BUNDLE_PRICE = REGULAR_PRICE
                                                ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = 1
                                                ,CON = 61
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC
                                        LIMIT  vX1_QTY;

                                        UPDATE SLS_CHECK_OFFER
                                            SET REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA2
                                                ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA2
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = 1
                                                ,CON = 62
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ;




                                    END IF;

                                ELSE
                                -- buy any lowest priced 6 from A list item at 800 amt;

INSERT INTO S VALUES (CONCAT('con 6_B',cvSLS_CHECK_OFFER_NO));
                                    SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY
                                        INTO @TOTAL_P_AMOUNT_CON6, @TOTAL_X1_QTY_CON6
                                        FROM SLS_CHECK_OFFER
                                        WHERE
                                        IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC
                                        LIMIT vX1_QTY ;

                                    IF @TOTAL_P_AMOUNT_CON6 >= vP_AMOUNT AND @TOTAL_X1_QTY_CON6 >= vX1_QTY THEN
INSERT INTO S VALUES (CONCAT('con 6_B',612));
                                        UPDATE SLS_CHECK_OFFER
                                            SET REGULAR_BUNDLE_PRICE = vP_AMOUNT/vX1_QTY
                                                ,INSTALLMENT_BUNDLE_PRICE = vP2_AMOUNT/vX1_QTY
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = COUNTER3
                                                ,CON = 63
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC
                                        LIMIT  vX1_QTY;



                                        SET COUNTER3 = COUNTER3+1;
                                    END IF;

                                END IF;






                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY > 0 AND vZA1 = 0 AND vX2_QTY > 0 AND vY1_QTY = 0 THEN
                            -- buy any lowest priced 6item at 800amt and more item at 50% discount ;
                            -- buy any lowest priced 6item at 800amt and more item at 50% discount and more item at 20% discount;

INSERT INTO S VALUES (CONCAT('con 7_',vX1_QTY));

                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON7, @TOTAL_X1_QTY_CON7 FROM SLS_CHECK_OFFER
                                WHERE IS_PROCESSED = 0
                                AND LIST_TYPE = 'A'
                                AND F_BUNDLE_NO = vF_BUNDLE_NO
                                AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                ORDER BY REGULAR_PRICE ASC
                                ;

                                IF @TOTAL_X1_QTY_CON7 >= vX1_QTY THEN

                                    UPDATE SLS_CHECK_OFFER
                                        SET
                                        REGULAR_BUNDLE_PRICE = REGULAR_PRICE
                                        ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE
                                        ,IS_PROCESSED = 1
                                        ,SEQUENC = 1
                                        ,CON = 71
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC LIMIT vX1_QTY;


                                    IF @TOTAL_X1_QTY_CON7 > vX1_QTY THEN

                                        UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA2
                                            ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA2
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = 1
                                            ,CON = 72
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC LIMIT vX2_QTY;

                                    END IF;

                                    SELECT  COUNT(*) AS TOTAL_QTY  INTO @TOTAL_X1_QTY_CON7C FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC ;

                                    IF @TOTAL_X1_QTY_CON7C > 0 AND vZA3 > 0 THEN

                                        UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA3
                                            ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA3
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = 1
                                            ,CON = 73
                                            WHERE IS_PROCESSED = 0
                                            AND LIST_TYPE = 'A'
                                            AND F_BUNDLE_NO = vF_BUNDLE_NO
                                            AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                            ORDER BY REGULAR_PRICE ASC ;

                                    END IF;



                                END IF;


                            ELSEIF vP_AMOUNT = 0 AND vX1_QTY > 0 AND vZA1 > 0 AND vY1_QTY = 0 THEN
                                -- Buy lowest 6 item at 50% discount, next 2 at 30% (and remaining at 10 discount) if remaining qty and more item at 20% discount jodi thake;
    INSERT INTO S VALUES (CONCAT('con 8_',vX1_QTY));

                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON8, @TOTAL_X1_QTY_CON8 FROM SLS_CHECK_OFFER
                                WHERE IS_PROCESSED = 0
                                AND LIST_TYPE = 'A'
                                AND F_BUNDLE_NO = vF_BUNDLE_NO
                                AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                ORDER BY REGULAR_PRICE ASC
                                ;
                                IF @TOTAL_X1_QTY_CON8 >= vX1_QTY THEN
                                    UPDATE SLS_CHECK_OFFER
                                        SET
                                        REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA1
                                        ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA1
                                        ,IS_PROCESSED = 1
                                        ,SEQUENC = 1
                                        ,CON = 81
                                    WHERE IS_PROCESSED = 0 AND
                                    LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC LIMIT vX1_QTY;

                                    IF vP_AMOUNT = 0 AND vX1_QTY > 0 AND vZA1 > 0 AND vX2_QTY > 0 AND vZA2  THEN
                                        -- next 2 qty 30% discount

                                        SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON8A, @TOTAL_X1_QTY_CON8A FROM SLS_CHECK_OFFER
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        ORDER BY REGULAR_PRICE ASC
                                        ;

                                        IF @TOTAL_X1_QTY_CON8A > 0 THEN

                                            UPDATE SLS_CHECK_OFFER
                                                SET
                                                REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA2
                                                ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA2
                                                ,IS_PROCESSED = 1
                                                ,SEQUENC = 1
                                                ,CON = 82
                                            WHERE IS_PROCESSED = 0
                                            AND LIST_TYPE = 'A'
                                            AND F_BUNDLE_NO = vF_BUNDLE_NO
                                            AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                            ORDER BY REGULAR_PRICE ASC LIMIT vX2_QTY;

                                            IF vP_AMOUNT = 0 AND vX1_QTY > 0 AND vZA1 > 0 AND vX2_QTY > 0 AND vZA2 AND vZA3 > 0 THEN
                                                -- next remaining qty qty 20% discount
                                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON8B, @TOTAL_X1_QTY_CON8B FROM SLS_CHECK_OFFER
                                                WHERE IS_PROCESSED = 0
                                                AND LIST_TYPE = 'A'
                                                AND F_BUNDLE_NO = vF_BUNDLE_NO
                                                AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                                ORDER BY REGULAR_PRICE ASC
                                                ;

                                                    IF @TOTAL_X1_QTY_CON8B > 0 THEN

                                                        UPDATE SLS_CHECK_OFFER
                                                            SET
                                                            REGULAR_BUNDLE_PRICE = REGULAR_PRICE - (REGULAR_PRICE/100)*vZA3
                                                            ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_PRICE - (INSTALLMENT_PRICE/100)*vZA3
                                                            ,IS_PROCESSED = 1
                                                            ,SEQUENC = 1
                                                            ,CON = 83
                                                        WHERE IS_PROCESSED = 0
                                                        AND LIST_TYPE = 'A'
                                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                                        ORDER BY REGULAR_PRICE ASC ;

                                                    END IF;
                                                    -- end next remaining qty qty 20% discount
                                            END IF;


                                        END IF;

                                    END IF;
                                END IF;

                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY > 0 AND vZA1 = 0 AND vX2_QTY = 0 AND vR_AMOUNT > 0 AND vY1_QTY > 0 THEN
                            -- buy 1 qty from A list at 100 taka get 1 qty from B list at 20 taka
INSERT INTO S VALUES (CONCAT('con 9_', cvSLS_CHECK_OFFER_NO));

                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON9, @TOTAL_X1_QTY_CON9 FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC
                                ;

                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_R_AMOUNT_CON9, @TOTAL_Y1_QTY_CON9 FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'B'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC
                                ;

                            IF @TOTAL_X1_QTY_CON9 >= vX1_QTY AND @TOTAL_Y1_QTY_CON9 >= vY1_QTY THEN
INSERT INTO S VALUES (CONCAT('con 9_','YES'));

                                    UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = vP_AMOUNT/vX1_QTY
                                            ,INSTALLMENT_BUNDLE_PRICE = vP2_AMOUNT/vX1_QTY
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = COUNTER9
                                            ,CON = 91
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        LIMIT vX1_QTY;

                                    UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = vR_AMOUNT/vY1_QTY
                                            ,INSTALLMENT_BUNDLE_PRICE = vR2_AMOUNT/vY1_QTY
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = COUNTER9
                                            ,CON = 91
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'B'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        LIMIT vY1_QTY;
                                SET COUNTER9 = COUNTER9+1;

                                END IF;


                            ELSEIF vP_AMOUNT > 0 AND vX1_QTY > 0 AND vZA1 = 0 AND vX2_QTY = 0 AND vR_AMOUNT = 0 AND vY1_QTY > 0 AND vZB1 > 0 THEN
                            -- get 1 qty from A list by 100 taka discount from B list
INSERT INTO S VALUES (CONCAT('con 10_',cvSLS_CHECK_OFFER_NO));

                            SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_P_AMOUNT_CON10, @TOTAL_X1_QTY_CON10 FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'A'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC
                                ;

                                SELECT SUM(REGULAR_PRICE), COUNT(*) AS TOTAL_QTY  INTO @TOTAL_R_AMOUNT_CON10, @TOTAL_Y1_QTY_CON10 FROM SLS_CHECK_OFFER
                                    WHERE IS_PROCESSED = 0
                                    AND LIST_TYPE = 'B'
                                    AND F_BUNDLE_NO = vF_BUNDLE_NO
                                    AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                    ORDER BY REGULAR_PRICE ASC
                                ;

                            IF @TOTAL_X1_QTY_CON10 >= vX1_QTY AND @TOTAL_Y1_QTY_CON10 >= vY1_QTY THEN
INSERT INTO S VALUES (CONCAT('con 10_','YES'));

                                    UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = vP_AMOUNT/vX1_QTY
                                            ,INSTALLMENT_BUNDLE_PRICE = vP2_AMOUNT/vX1_QTY
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = COUNTER10
                                            ,CON = 101
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'A'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        LIMIT vX1_QTY;

                                    UPDATE SLS_CHECK_OFFER
                                            SET
                                            REGULAR_BUNDLE_PRICE = REGULAR_BUNDLE_PRICE - (REGULAR_BUNDLE_PRICE/100)*vZB1
                                            ,INSTALLMENT_BUNDLE_PRICE = INSTALLMENT_BUNDLE_PRICE - (INSTALLMENT_BUNDLE_PRICE/100)*vZB1
                                            ,IS_PROCESSED = 1
                                            ,SEQUENC = COUNTER10
                                            ,CON = 91
                                        WHERE IS_PROCESSED = 0
                                        AND LIST_TYPE = 'B'
                                        AND F_BUNDLE_NO = vF_BUNDLE_NO
                                        AND F_BOOKING_NO = IN_BOOKING_PK_NO
                                        LIMIT vY1_QTY;

                                SET COUNTER10 = COUNTER10+1;

                                END IF;




                            END IF; -- last if
                        END LOOP GET_CUR_SLS_CHECK_OFFER_RESULT_ROW;
                    END IF;



        CLOSE CUR_SLS_CHECK_OFFER_RESULT_ROW;

        END Block3;






                        END LOOP GET_CUR_SLS_CHECK_OFFER_RESULT;

                    END IF;

                CLOSE CUR_SLS_CHECK_OFFER_RESULT;






END Block2;

END BLOCKPARENT$$

DELIMITER ;
