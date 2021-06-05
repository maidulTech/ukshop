CREATE PROCEDURE PROC_CUSTOMER_PAYMENT_VERIFY(IN_BANK_TXN_PK_NO Integer(11), IN_BANK_TXN_STATEMENT_PK_NO Integer(11))
  NO SQL
BEGIN
  -- UPDATE ACC_BANK_TXN BALANCE_ACTUAL (INCREMENT)
    -- UPDATE ACC_PAYMENT_BANK_ACC CUSTOMER_BALANCE_ACTUAL (INCREMENT)
    -- UPDATE SLS_CUSTOMERS CUSTOMER_BALANCE_ACTUAL (INCREMENT)
    -- UPDATE SLS_ORDER ORDER_ACTUAL_TOPUP
    -- UPDATE ACC_BANK_TXN_STATEMENT F_ACC_BANK_TXN_NO, IS_MATCHED




        DECLARE VAR_F_CUSTOMER_PAYMENT_NO INT DEFAULT 0;
        DECLARE VAR_F_RESELLER_PAYMENT_NO INT DEFAULT 0;
        DECLARE VAR_F_ACC_PAYMENT_BANK_NO INT DEFAULT 0;
        DECLARE VAR_F_CUSTOMER_NO INT DEFAULT 0;
        DECLARE VAR_F_RESELLER_NO INT DEFAULT 0;
        DECLARE VAR_IS_CUS_RESELLER_BANK_RECONCILATION INT DEFAULT 0;
        DECLARE VAR_PAYMENT_CONFIRMED_STATUS INT DEFAULT 0;
        DECLARE VAR_PAYMENT_REMAINING_MR FLOAT DEFAULT 0;
        DECLARE VAR_MR_AMOUNT FLOAT DEFAULT 0;
        DECLARE VAR_CUSTOMER_BALANCE_ACTUAL FLOAT DEFAULT 0;
        DECLARE VAR_CUM_BALANCE_ACTUAL FLOAT DEFAULT 0;
        DECLARE VAR_TOTAL_PAYMENT_REMAINING_MR FLOAT DEFAULT 0;

        DECLARE int_row_count INT DEFAULT 0;
        DECLARE int_row_count2 INT DEFAULT 0;

        DECLARE xORDER_PAYMENT_PK_NO INT DEFAULT 0;
        DECLARE xORDER_NO INT DEFAULT 0;
        DECLARE xPAYMENT_AMOUNT FLOAT DEFAULT 0;

        DECLARE xNET_DUE FLOAT DEFAULT 0;
        DECLARE xNET_VALUE FLOAT DEFAULT 0;
        DECLARE xBOOKING_DETAILS_PK_NO FLOAT DEFAULT 0;
        DECLARE xINV_STOCK_PK_NO INT DEFAULT 0;







    SELECT F_CUSTOMER_PAYMENT_NO,F_RESELLER_PAYMENT_NO, F_ACC_PAYMENT_BANK_NO, F_CUSTOMER_NO, F_RESELLER_NO, IS_CUS_RESELLER_BANK_RECONCILATION INTO VAR_F_CUSTOMER_PAYMENT_NO, VAR_F_RESELLER_PAYMENT_NO, VAR_F_ACC_PAYMENT_BANK_NO, VAR_F_CUSTOMER_NO, VAR_F_RESELLER_NO, VAR_IS_CUS_RESELLER_BANK_RECONCILATION
        FROM ACC_BANK_TXN WHERE PK_NO = IN_BANK_TXN_PK_NO;


    /*###################### CUSTOMER PAYMENT ############################*/
    IF VAR_IS_CUS_RESELLER_BANK_RECONCILATION = 1 THEN

        SELECT PAYMENT_CONFIRMED_STATUS, PAYMENT_REMAINING_MR, MR_AMOUNT INTO VAR_PAYMENT_CONFIRMED_STATUS, VAR_PAYMENT_REMAINING_MR, VAR_MR_AMOUNT  FROM ACC_CUSTOMER_PAYMENTS WHERE PK_NO = VAR_F_CUSTOMER_PAYMENT_NO ;

        UPDATE ACC_CUSTOMER_PAYMENTS SET PAYMENT_CONFIRMED_STATUS = 1 WHERE PK_NO = VAR_F_CUSTOMER_PAYMENT_NO ;

        SELECT SUM(PAYMENT_REMAINING_MR), IFNULL(SUM(MR_AMOUNT),0) INTO VAR_TOTAL_PAYMENT_REMAINING_MR,VAR_CUSTOMER_BALANCE_ACTUAL
            FROM ACC_CUSTOMER_PAYMENTS WHERE F_CUSTOMER_NO = VAR_F_CUSTOMER_NO AND PAYMENT_CONFIRMED_STATUS = 1;

            /* CURSOR FOR UPDATE ACC_ORDER_PAYMENT AND SLS_ORDER */
            Block1: BEGIN
                DECLARE INT_HAS_CUR_ROW INT DEFAULT 1;
                DECLARE CUR_ACC_ORDER_PAYMENT
                    CURSOR FOR
                        SELECT PK_NO, ORDER_NO, PAYMENT_AMOUNT
                            FROM ACC_ORDER_PAYMENT
                            WHERE
                            -- IS_PAYMENT_FROM_BALANCE = 0 AND
                            F_ACC_CUSTOMER_PAYMENT_NO = VAR_F_CUSTOMER_PAYMENT_NO ;

                            DECLARE CONTINUE HANDLER
                                FOR NOT FOUND SET INT_HAS_CUR_ROW = 0;

        INSERT INTO R VALUES('Start Procedre');
                                OPEN CUR_ACC_ORDER_PAYMENT;
                                    SELECT FOUND_ROWS() INTO int_row_count ;

        INSERT INTO R VALUES ('Line 52');
                                    IF int_row_count > 0 THEN

                                        GET_CUR_ACC_ORDER_PAYMENT: LOOP
                                            FETCH NEXT
                                            FROM CUR_ACC_ORDER_PAYMENT
                                            INTO
                                            xORDER_PAYMENT_PK_NO
                                            ,xORDER_NO
                                            ,xPAYMENT_AMOUNT
                                            ;

                                            IF INT_HAS_CUR_ROW = 0 THEN
                                                LEAVE GET_CUR_ACC_ORDER_PAYMENT;
                                            END IF;
        INSERT INTO S VALUES('line 70');

                                            UPDATE SLS_ORDER SET ORDER_ACTUAL_TOPUP = ORDER_ACTUAL_TOPUP + xPAYMENT_AMOUNT WHERE PK_NO = xORDER_NO;

                                            /* UPDATE ORDER_STATUS = 60 */
                                                Block2: BEGIN
                                                    DECLARE INT_HAS_CUR_ROW2 INT DEFAULT 1;
                                                    DECLARE CUR_UPDATE_ORDER_SATUS
                                                    CURSOR FOR
                                                    SELECT
                                                   -- SLS_ORDER.PK_NO AS ORDER
                                                   -- ,SLS_ORDER.ORDER_ACTUAL_TOPUP
                                                   -- ,SLS_BOOKING.TOTAL_PRICE
                                                   -- ,SLS_BOOKING.DISCOUNT
                                                    SUM(SLS_BOOKING.TOTAL_PRICE - SLS_BOOKING.DISCOUNT) AS NET_VALUE
                                                    ,SUM(SLS_BOOKING.TOTAL_PRICE - SLS_BOOKING.DISCOUNT - SLS_ORDER.ORDER_ACTUAL_TOPUP) AS NET_DUE
                                                   -- ,SLS_ORDER.F_BOOKING_NO
                                                    ,SLS_BOOKING_DETAILS.PK_NO AS BOOKING_DETAILS_PK_NO
                                                    ,INV_STOCK.PK_NO AS INV_STOCK_PK_NO
                                                   -- ,SLS_BOOKING_DETAILS.ORDER_STATUS
                                                   -- ,INV_STOCK.ORDER_STATUS AS INV_ORDER_STATUS
                                                    FROM SLS_ORDER
                                                    JOIN SLS_BOOKING ON SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO
                                                    JOIN SLS_BOOKING_DETAILS ON SLS_BOOKING_DETAILS.F_BOOKING_NO = SLS_BOOKING.PK_NO
                                                    JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
                                                    WHERE SLS_ORDER.PK_NO = xORDER_NO GROUP BY SLS_BOOKING_DETAILS.PK_NO ;


                                                    DECLARE CONTINUE HANDLER
                                                    FOR NOT FOUND SET INT_HAS_CUR_ROW2 = 0;

INSERT INTO R VALUES('Start Procedre109');
                                                    OPEN CUR_UPDATE_ORDER_SATUS;
                                                        SELECT FOUND_ROWS() INTO int_row_count2 ;

                                                        IF int_row_count2 > 0 THEN

                                                            GET_CUR_UPDATE_ORDER_SATUS: LOOP

                                                            FETCH NEXT
                                                            FROM CUR_UPDATE_ORDER_SATUS
                                                            INTO
                                                            xNET_VALUE
                                                            ,xNET_DUE
                                                            ,xBOOKING_DETAILS_PK_NO
                                                            ,xINV_STOCK_PK_NO
                                                            ;

                                                            IF INT_HAS_CUR_ROW2 = 0 THEN
                                                            LEAVE GET_CUR_UPDATE_ORDER_SATUS;
                                                            END IF;

                                                            IF xNET_DUE <= 0  THEN

                                                                UPDATE SLS_BOOKING_DETAILS SET ORDER_STATUS = 60
                                                                WHERE PK_NO = xBOOKING_DETAILS_PK_NO;

                                                                UPDATE INV_STOCK SET ORDER_STATUS = 60
                                                                WHERE PK_NO = xINV_STOCK_PK_NO;

                                                                UPDATE SLS_ORDER SET ORDER_BALANCE_USED = xNET_VALUE, DEFAULT_AT = null, DEFAULT_TYPE = 0
                                                                WHERE PK_NO = xORDER_NO;

                                                            END IF;

                                                            END LOOP GET_CUR_UPDATE_ORDER_SATUS;

                                                        END IF;
                                                    CLOSE CUR_UPDATE_ORDER_SATUS;
                                                END Block2;

                                        /* END SECOND CURSOR */




                                        END LOOP GET_CUR_ACC_ORDER_PAYMENT;

                                    END IF;

                                CLOSE CUR_ACC_ORDER_PAYMENT;
            END Block1;
            /* END CURSOR FOR UPDATE ACC_ORDER_PAYMENT AND SLS_ORDER */


            UPDATE ACC_BANK_TXN SET AMOUNT_ACTUAL = AMOUNT_ACTUAL + VAR_MR_AMOUNT, IS_MATCHED = 1, MATCHED_ON = NOW() WHERE PK_NO = IN_BANK_TXN_PK_NO;

            UPDATE ACC_PAYMENT_BANK_ACC SET BALANCE_ACTUAL = BALANCE_ACTUAL + VAR_MR_AMOUNT WHERE PK_NO = VAR_F_ACC_PAYMENT_BANK_NO;

            UPDATE SLS_CUSTOMERS SET CUSTOMER_BALANCE_ACTUAL = VAR_CUSTOMER_BALANCE_ACTUAL, CUM_BALANCE = VAR_TOTAL_PAYMENT_REMAINING_MR WHERE PK_NO = VAR_F_CUSTOMER_NO ;

            UPDATE ACC_BANK_TXN_STATEMENT SET F_ACC_BANK_TXN_NO = IN_BANK_TXN_PK_NO, IS_MATCHED = 1, MATCHED_ON = NOW() WHERE PK_NO = IN_BANK_TXN_STATEMENT_PK_NO;

    END IF;



     /*###################### RESELLER PAYMENT ############################*/
    IF VAR_IS_CUS_RESELLER_BANK_RECONCILATION = 2 THEN

        SELECT PAYMENT_CONFIRMED_STATUS, PAYMENT_REMAINING_MR, MR_AMOUNT INTO VAR_PAYMENT_CONFIRMED_STATUS, VAR_PAYMENT_REMAINING_MR, VAR_MR_AMOUNT  FROM ACC_RESELLER_PAYMENTS WHERE PK_NO = VAR_F_RESELLER_PAYMENT_NO ;

            UPDATE ACC_RESELLER_PAYMENTS SET PAYMENT_CONFIRMED_STATUS = 1 WHERE PK_NO = VAR_F_RESELLER_PAYMENT_NO ;

              SELECT SUM(PAYMENT_REMAINING_MR), IFNULL(SUM(MR_AMOUNT),0) INTO VAR_TOTAL_PAYMENT_REMAINING_MR, VAR_CUM_BALANCE_ACTUAL
            FROM ACC_RESELLER_PAYMENTS WHERE F_RESELLER_NO = VAR_F_RESELLER_NO AND PAYMENT_CONFIRMED_STATUS = 1;

            /* CURSOR FOR UPDATE ACC_ORDER_PAYMENT AND SLS_ORDER */
            Block1: BEGIN
                DECLARE INT_HAS_CUR_ROW INT DEFAULT 1;
                DECLARE CUR_ACC_ORDER_PAYMENT
                    CURSOR FOR
                        SELECT PK_NO, ORDER_NO, PAYMENT_AMOUNT
                            FROM ACC_ORDER_PAYMENT
                            WHERE
                            -- IS_PAYMENT_FROM_BALANCE = 0 AND
                            F_ACC_RESELLER_PAYMENT_NO = VAR_F_RESELLER_PAYMENT_NO ;

                            DECLARE CONTINUE HANDLER
                                FOR NOT FOUND SET INT_HAS_CUR_ROW = 0;

        INSERT INTO R VALUES('Start Procedre');
                                OPEN CUR_ACC_ORDER_PAYMENT;
                                    SELECT FOUND_ROWS() INTO int_row_count ;

        INSERT INTO R VALUES ('Line 52');
                                    IF int_row_count > 0 THEN

                                        GET_CUR_ACC_ORDER_PAYMENT: LOOP
                                            FETCH NEXT
                                            FROM CUR_ACC_ORDER_PAYMENT
                                            INTO
                                            xORDER_PAYMENT_PK_NO
                                            ,xORDER_NO
                                            ,xPAYMENT_AMOUNT
                                            ;

                                            IF INT_HAS_CUR_ROW = 0 THEN
                                                LEAVE GET_CUR_ACC_ORDER_PAYMENT;
                                            END IF;
        INSERT INTO S VALUES('line 70');

                                            UPDATE SLS_ORDER SET ORDER_ACTUAL_TOPUP = ORDER_ACTUAL_TOPUP + xPAYMENT_AMOUNT WHERE PK_NO = xORDER_NO;

                                            /* UPDATE ORDER_STATUS = 60 */
                                                Block2: BEGIN
                                                    DECLARE INT_HAS_CUR_ROW2 INT DEFAULT 1;
                                                    DECLARE CUR_UPDATE_ORDER_SATUS
                                                    CURSOR FOR
                                                    SELECT
                                                   -- SLS_ORDER.PK_NO AS ORDER
                                                   -- ,SLS_ORDER.ORDER_ACTUAL_TOPUP
                                                   -- ,SLS_BOOKING.TOTAL_PRICE
                                                   -- ,SLS_BOOKING.DISCOUNT
                                                    SUM(SLS_BOOKING.TOTAL_PRICE - SLS_BOOKING.DISCOUNT) AS NET_VALUE
                                                    ,SUM(SLS_BOOKING.TOTAL_PRICE - SLS_BOOKING.DISCOUNT - SLS_ORDER.ORDER_ACTUAL_TOPUP) AS NET_DUE
                                                   -- ,SLS_ORDER.F_BOOKING_NO
                                                    ,SLS_BOOKING_DETAILS.PK_NO AS BOOKING_DETAILS_PK_NO
                                                    ,INV_STOCK.PK_NO AS INV_STOCK_PK_NO
                                                   -- ,SLS_BOOKING_DETAILS.ORDER_STATUS
                                                   -- ,INV_STOCK.ORDER_STATUS AS INV_ORDER_STATUS
                                                    FROM SLS_ORDER
                                                    JOIN SLS_BOOKING ON SLS_BOOKING.PK_NO = SLS_ORDER.F_BOOKING_NO
                                                    JOIN SLS_BOOKING_DETAILS ON SLS_BOOKING_DETAILS.F_BOOKING_NO = SLS_BOOKING.PK_NO
                                                    JOIN INV_STOCK ON INV_STOCK.PK_NO = SLS_BOOKING_DETAILS.F_INV_STOCK_NO
                                                    WHERE SLS_ORDER.PK_NO = xORDER_NO
                                                    GROUP BY SLS_BOOKING_DETAILS.PK_NO ;


                                                    DECLARE CONTINUE HANDLER
                                                    FOR NOT FOUND SET INT_HAS_CUR_ROW2 = 0;

INSERT INTO R VALUES('Start Procedre109');
                                                    OPEN CUR_UPDATE_ORDER_SATUS;
                                                        SELECT FOUND_ROWS() INTO int_row_count2 ;

                                                        IF int_row_count2 > 0 THEN

                                                            GET_CUR_UPDATE_ORDER_SATUS: LOOP

                                                            FETCH NEXT
                                                            FROM CUR_UPDATE_ORDER_SATUS
                                                            INTO
                                                            xNET_VALUE
                                                            ,xNET_DUE
                                                            ,xBOOKING_DETAILS_PK_NO
                                                            ,xINV_STOCK_PK_NO
                                                            ;

                                                            IF INT_HAS_CUR_ROW2 = 0 THEN
                                                            LEAVE GET_CUR_UPDATE_ORDER_SATUS;
                                                            END IF;

                                                            IF xNET_DUE <= 0  THEN

                                                                UPDATE SLS_BOOKING_DETAILS SET ORDER_STATUS = 60
                                                                WHERE PK_NO = xBOOKING_DETAILS_PK_NO;

                                                                UPDATE INV_STOCK SET ORDER_STATUS = 60
                                                                WHERE PK_NO = xINV_STOCK_PK_NO;

                                                                UPDATE SLS_ORDER SET ORDER_BALANCE_USED = xNET_VALUE, DEFAULT_AT = null, DEFAULT_TYPE = 0
                                                                WHERE PK_NO = xORDER_NO;
                                                            END IF;

                                                            END LOOP GET_CUR_UPDATE_ORDER_SATUS;

                                                        END IF;
                                                    CLOSE CUR_UPDATE_ORDER_SATUS;
                                                END Block2;

                                        /* END SECOND CURSOR */

                                        END LOOP GET_CUR_ACC_ORDER_PAYMENT;

                                    END IF;

                                CLOSE CUR_ACC_ORDER_PAYMENT;
            END Block1;
            /* END CURSOR FOR UPDATE ACC_ORDER_PAYMENT AND SLS_ORDER */


            UPDATE ACC_BANK_TXN SET AMOUNT_ACTUAL = AMOUNT_ACTUAL + VAR_MR_AMOUNT, IS_MATCHED = 1, MATCHED_ON = NOW() WHERE PK_NO = IN_BANK_TXN_PK_NO;

            UPDATE ACC_PAYMENT_BANK_ACC SET BALANCE_ACTUAL = BALANCE_ACTUAL + VAR_MR_AMOUNT WHERE PK_NO = VAR_F_ACC_PAYMENT_BANK_NO;

            UPDATE SLS_RESELLERS SET CUM_BALANCE_ACTUAL = VAR_CUM_BALANCE_ACTUAL, CUM_BALANCE = VAR_TOTAL_PAYMENT_REMAINING_MR WHERE PK_NO = VAR_F_RESELLER_NO ;

            UPDATE ACC_BANK_TXN_STATEMENT SET F_ACC_BANK_TXN_NO = IN_BANK_TXN_PK_NO, IS_MATCHED = 1, MATCHED_ON = NOW() WHERE PK_NO = IN_BANK_TXN_STATEMENT_PK_NO;


    END IF;


END
/
