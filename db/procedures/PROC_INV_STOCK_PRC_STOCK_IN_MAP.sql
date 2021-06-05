CREATE PROCEDURE PROC_INV_STOCK_PRC_STOCK_IN_MAP(IN_PK_NO Integer)
  NO SQL
BEGIN

    /*PROC_INV_STOCK_PRC_STOCK_IN_MAP*/
    DECLARE int_F_PRC_STOCK_IN_NO INT(11) default 0;
    DECLARE int_F_INV_WAREHOUSE_NO INT(11) default 0;

    /* INV_WAREHOUSE_NAME variable DECLARE*/
    DECLARE VAR_INV_WAREHOUSE_NAME  varchar(200);

    /*PRC_STOCK_IN_DETAILS*/
    DECLARE int_HAS_DATA_PRC_STOCK_IN_DETAILS INT DEFAULT 1;
    DECLARE int_RECIEVED_QTY INT;
    DECLARE int_FAULTY_QTY INT;
    DECLARE int_TOTAL INT;

    /*INV STOCK*/
    DECLARE xCODE                            INT;
    DECLARE xF_INV_STOCK_PRC_STOCK_IN_MAP_NO INT;
    DECLARE xF_PRC_STOCK_IN_NO               INT;
    DECLARE xF_PRC_STOCK_IN_DETAILS_NO       INT;
    DECLARE xIG_CODE                         varchar(20);
    DECLARE xSKUID                           varchar(40);
    DECLARE xF_PRD_VARIANT_NO                INT;
    DECLARE xPRD_VARINAT_NAME                varchar(200);
    DECLARE xINVOICE_NAME                    varchar(200);
    DECLARE xF_INV_WAREHOUSE_NO              INT;
    DECLARE xINV_WAREHOUSE_NAME              varchar(200);
    DECLARE xF_BOOKING_NO                    INT;
    DECLARE xF_BOOKING_DETAILS_NO            INT;
    DECLARE xF_ORDER_NO                      INT;
    DECLARE xF_ORDER_DETAILS_NO              INT;
    DECLARE xHS_CODE                         varchar(20);
    DECLARE xHS_CODE_NARRATION               varchar(200);
    DECLARE xF_CATEGORY_NO                   INT;
    DECLARE xCATEGORY_NAME                   varchar(200);
    DECLARE xF_SUB_CATEGORY_NO               INT;
    DECLARE xSUB_CATEGORY_NAME               varchar(200);
    DECLARE xBARCODE                         varchar(40);
    DECLARE xF_BRAND_NO                      INT;
    DECLARE xBRAND_NAME                      varchar(40);
    DECLARE xF_MODEL_NO                      INT;
    DECLARE xMODEL_NAME                      varchar(200);
    DECLARE xPRODUCT_STATUS                  INT;
    DECLARE xBOOKING_STATUS                  INT;
    DECLARE xORDER_STATUS                    INT;
    DECLARE xPRODUCT_PURCHASE_PRICE_GBP      FLOAT;
    DECLARE xPRODUCT_PURCHASE_PRICE          FLOAT;
    DECLARE xPRODUCT_REGULAR_PRICE           FLOAT;
    DECLARE xPRODUCT_INSTALLMENT_PRICE       FLOAT;
    DECLARE xORDER_PRICE                     FLOAT;
    DECLARE xSS_COST                         FLOAT;
    DECLARE xSM_COST                         FLOAT;
    DECLARE xAIR_FREIGHT_COST                FLOAT;
    DECLARE xSEA_FREIGHT_COST                FLOAT;
    DECLARE xPREFERRED_SHIPPING_METHOD       varchar(40);
    DECLARE xF_SHIPPMENT_NO                  INT;
    DECLARE xSHIPMENT_NAME                   varchar(200);
    DECLARE xBOX_BARCODE                     varchar(200);
    DECLARE xF_BOX_NO                        INT;
    DECLARE xPRC_IN_IMAGE_PATH               varchar(200);
    DECLARE xPRD_VARIANT_IMAGE_PATH           varchar(200);

    /*LOOP VARIABLES*/
    DECLARE i int DEFAULT 0;

    DECLARE cur_PRC_STOCK_IN_DETAILS
        CURSOR FOR

                SELECT

                        INVOICE.F_PRC_STOCK_IN
                        ,INVOICE.PK_NO
                        ,INVOICE.F_PRD_VARIANT_NO
                        ,PRODUCT.MRK_ID_COMPOSITE_CODE
                        ,PRODUCT.COMPOSITE_CODE
                        ,PRODUCT.VARIANT_NAME
                        ,INVOICE.INVOICE_NAME
                        ,PRODUCT.HS_CODE
                        ,PRODUCT.BARCODE
                        ,INVOICE.UNIT_PRICE_GBP_EV
                        ,INVOICE.UNIT_PRICE_MR_EV
                        ,INVOICE.RECIEVED_QTY
                        ,INVOICE.FAULTY_QTY
                        ,PRODUCT.REGULAR_PRICE
                        ,PRODUCT.INSTALLMENT_PRICE
                        ,PRODUCT.INTER_DISTRICT_POSTAGE
                        ,PRODUCT.LOCAL_POSTAGE
                        ,PRODUCT.AIR_FREIGHT_CHARGE
                        ,PRODUCT.SEA_FREIGHT_CHARGE
                        ,PRODUCT.PREFERRED_SHIPPING_METHOD
                        ,INVOICE_MASTER.MASTER_INVOICE_RELATIVE_PATH
                        ,PRODUCT.PRIMARY_IMG_RELATIVE_PATH
                        ,PRODUCT_MASTER.F_MODEL
                        ,PRODUCT_MASTER.MODEL_NAME
                        ,PRODUCT_MASTER.F_BRAND
                        ,PRODUCT_MASTER.BRAND_NAME
                        ,PRODUCT_SUB_CATEGORY.PK_NO
                        ,PRODUCT_SUB_CATEGORY.NAME
                        ,PRODUCT_CATEGORY.PK_NO
                        ,PRODUCT_CATEGORY.NAME


                        FROM
        PRC_STOCK_IN INVOICE_MASTER
                                ,PRC_STOCK_IN_DETAILS INVOICE
                                ,PRD_VARIANT_SETUP PRODUCT
                                ,PRD_MASTER_SETUP PRODUCT_MASTER
                                ,PRD_SUB_CATEGORY PRODUCT_SUB_CATEGORY
                                ,PRD_CATEGORY PRODUCT_CATEGORY


                        WHERE
                    INVOICE.F_PRC_STOCK_IN = int_F_PRC_STOCK_IN_NO
                        AND  INVOICE.F_PRD_VARIANT_NO = PRODUCT.PK_NO
                        AND PRODUCT.F_PRD_MASTER_SETUP_NO=  PRODUCT_MASTER.PK_NO
                        AND PRODUCT_MASTER.F_PRD_SUB_CATEGORY_ID= PRODUCT_SUB_CATEGORY.PK_NO
                        AND PRODUCT_SUB_CATEGORY.F_PRD_CATEGORY_NO=  PRODUCT_CATEGORY.PK_NO
                        AND INVOICE_MASTER.PK_NO = INVOICE.F_PRC_STOCK_IN
                            ;



    DECLARE CONTINUE HANDLER
    FOR NOT FOUND SET int_HAS_DATA_PRC_STOCK_IN_DETAILS=0;


    /*delete from R;
    insert into R values ('96');

    insert into R values (int_F_PRC_STOCK_IN_NO);
    insert into R values (int_F_INV_WAREHOUSE_NO);    */


    SELECT F_PRC_STOCK_IN_NO ,F_INV_WAREHOUSE_NO
        INTO int_F_PRC_STOCK_IN_NO, int_F_INV_WAREHOUSE_NO
    FROM INV_STOCK_PRC_STOCK_IN_MAP
    WHERE PK_NO = IN_PK_NO ;


    /*FOR INV_WAREHOUSE_NAME  */

    SELECT NAME
        INTO VAR_INV_WAREHOUSE_NAME
    FROM INV_WAREHOUSE
    WHERE PK_NO= int_F_INV_WAREHOUSE_NO;

    IF int_F_INV_WAREHOUSE_NO = 2 THEN
       SET xPRODUCT_STATUS = 60;
    ELSE
       SET xPRODUCT_STATUS = NULL;
    END IF;
    /*insert into R values (int_F_PRC_STOCK_IN_NO);
    insert into R values (int_F_INV_WAREHOUSE_NO);        */


    OPEN cur_PRC_STOCK_IN_DETAILS;

        insert into R values ('105');

                get_PRC_STOCK_IN_DETAILS: LOOP

                        FETCH NEXT FROM  cur_PRC_STOCK_IN_DETAILS INTO

                        xF_PRC_STOCK_IN_NO               ,
                        xF_PRC_STOCK_IN_DETAILS_NO       ,
                        xF_PRD_VARIANT_NO                ,
                        xIG_CODE                         ,
                        xSKUID                           ,
                        xPRD_VARINAT_NAME                ,
                        xINVOICE_NAME                    ,
                        xHS_CODE                         ,
                        xBARCODE                         ,
                        xPRODUCT_PURCHASE_PRICE_GBP      ,
                        xPRODUCT_PURCHASE_PRICE          ,
                        int_RECIEVED_QTY                 ,
                        int_FAULTY_QTY                   ,
                        xPRODUCT_REGULAR_PRICE           ,
                        xPRODUCT_INSTALLMENT_PRICE       ,
                        xSS_COST                         ,
                        xSM_COST                         ,
                        xAIR_FREIGHT_COST                ,
                        xSEA_FREIGHT_COST                ,
                        xPREFERRED_SHIPPING_METHOD       ,
                        xPRC_IN_IMAGE_PATH               ,
                        xPRD_VARIANT_IMAGE_PATH          ,
                        xF_MODEL_NO                      ,
                        xMODEL_NAME                      ,
                        xF_BRAND_NO                      ,
                        xBRAND_NAME                      ,
                        xF_SUB_CATEGORY_NO               ,
                        xSUB_CATEGORY_NAME               ,
                        xF_CATEGORY_NO                   ,
                        xCATEGORY_NAME                   ;



        /*TOTAL GEN = RECQTY - FAUTLY QTY*/
        IF int_HAS_DATA_PRC_STOCK_IN_DETAILS = 0 THEN
            LEAVE get_PRC_STOCK_IN_DETAILS;

        END IF;

        SET int_TOTAL = int_RECIEVED_QTY - int_FAULTY_QTY;


        SET i=0;
        WHILE i < int_TOTAL DO

            insert into INV_STOCK(
                F_INV_STOCK_PRC_STOCK_IN_MAP_NO
                ,F_PRC_STOCK_IN_NO
                ,F_PRC_STOCK_IN_DETAILS_NO
                ,IG_CODE
                ,SKUID
                ,F_PRD_VARIANT_NO
                ,PRD_VARINAT_NAME
                ,INVOICE_NAME
                ,F_INV_WAREHOUSE_NO
                ,INV_WAREHOUSE_NAME
                ,HS_CODE
                ,F_CATEGORY_NO
                ,CATEGORY_NAME
                ,F_SUB_CATEGORY_NO
                ,SUB_CATEGORY_NAME
                ,BARCODE
                ,F_BRAND_NO
                ,BRAND_NAME
                ,F_MODEL_NO
                ,MODEL_NAME
                ,PRODUCT_PURCHASE_PRICE_GBP
                ,PRODUCT_PURCHASE_PRICE
                ,REGULAR_PRICE
                ,INSTALLMENT_PRICE
                ,SS_COST
                ,SM_COST
                ,AIR_FREIGHT_COST
                ,SEA_FREIGHT_COST
                ,PREFERRED_SHIPPING_METHOD
                ,FINAL_PREFFERED_SHIPPING_METHOD
                ,PRC_IN_IMAGE_PATH
                ,PRD_VARIANT_IMAGE_PATH
                ,PRODUCT_STATUS
                )
            VALUES

            (


            IN_PK_NO
            ,xF_PRC_STOCK_IN_NO
            ,xF_PRC_STOCK_IN_DETAILS_NO
            ,xIG_CODE
            ,xSKUID
            ,xF_PRD_VARIANT_NO
            ,xPRD_VARINAT_NAME
            ,xINVOICE_NAME
            ,int_F_INV_WAREHOUSE_NO
            ,VAR_INV_WAREHOUSE_NAME
            ,xHS_CODE
            ,xF_CATEGORY_NO
            ,xCATEGORY_NAME
            ,xF_SUB_CATEGORY_NO
            ,xSUB_CATEGORY_NAME
            ,xBARCODE
            ,xF_BRAND_NO
            ,xBRAND_NAME
            ,xF_MODEL_NO
            ,xMODEL_NAME
            ,xPRODUCT_PURCHASE_PRICE_GBP
            ,xPRODUCT_PURCHASE_PRICE
            ,xPRODUCT_REGULAR_PRICE
            ,xPRODUCT_INSTALLMENT_PRICE
            ,xSS_COST
            ,xSM_COST
            ,xAIR_FREIGHT_COST
            ,xSEA_FREIGHT_COST
            ,xPREFERRED_SHIPPING_METHOD
            ,xPREFERRED_SHIPPING_METHOD
            ,xPRC_IN_IMAGE_PATH
            ,xPRD_VARIANT_IMAGE_PATH
            ,xPRODUCT_STATUS
                );

            SET i = i + 1;

        END WHILE;



    END LOOP get_PRC_STOCK_IN_DETAILS;


    /* UPDATE INV_STOCK_PRC_STOCK_IN_MAP
    SET PROCESS_COMPLETE_TIME = NOW()
    WHERE PK_NO=IN_PK_NO;     */


CLOSE cur_PRC_STOCK_IN_DETAILS;


/*
if (int_HAS_DATA_PRC_STOCK_IN_DETAILS = 0)
return

    */

/*insert into INV_STOCK(CODE,INVOICE_NAME,PRD_VARIANT_NAME,HS_CODE,BAR_CODE)

SELECT CODE,INVOICE_NAME,PRD_VARIANT_NAME,HS_CODE,BAR_CODE

FROM PRC_STOCK_IN_DETAILS

WHERE PK_NO = IN_PK_NO;*/

END
/
