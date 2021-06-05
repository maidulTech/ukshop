CREATE PROCEDURE PROC_SC_SHIPMENT_CANCELLED(IN_SHIPMENT_PK_NO Integer(11), OUT OUT_STATUS VarChar(20))
  NO SQL
BEGIN


/*10101010~10~5|10101011~9~3|10101012~10~1|*/



    DECLARE int_HAS_cur_SC_BOX INT DEFAULT 1;
    DECLARE xPK_NO INT;


    DECLARE cur_SC_BOX
        CURSOR FOR
        SELECT
            F_BOX_NO
            FROM SC_SHIPMENT_BOX
            WHERE F_SHIPPMENT_NO=IN_SHIPMENT_PK_NO ;


    DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET int_HAS_cur_SC_BOX = 0;



              UPDATE INV_STOCK
              SET PRODUCT_STATUS = 20,
              F_SHIPPMENT_NO = NULL,
              SHIPMENT_NAME = NULL
              WHERE F_SHIPPMENT_NO = IN_SHIPMENT_PK_NO;


                OPEN cur_SC_BOX;


                    get_PROC_SC_SHIPMENT_CANCELLED: LOOP
                        FETCH NEXT FROM  cur_SC_BOX INTO xPK_NO;

                        IF int_HAS_cur_SC_BOX = 0 THEN
                                LEAVE get_PROC_SC_SHIPMENT_CANCELLED;
                            END IF;

                          UPDATE SC_BOX
                            SET BOX_STATUS = 10
                            WHERE PK_NO = xPK_NO;


                    END LOOP get_PROC_SC_SHIPMENT_CANCELLED;


                CLOSE cur_SC_BOX;


        DELETE FROM SC_SHIPMENT_BOX WHERE F_SHIPMENT_NO = IN_SHIPMENT_PK_NO;


    SET OUT_STATUS = 'success';


    END
/
