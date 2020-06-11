BEGIN                      
  DBMS_SCHEDULER.CREATE_JOB ( 
   job_name        => 'baocaocongno_job',
   job_type        => 'STORED_PROCEDURE',       -- see oracle documentation on types --
   job_action      => 'PROC_INIT_DEBT_REPORT_OF_MONTH',
   start_date      => SYSTIMESTAMP,      
   repeat_interval => 'FREQ=MONTHLY;BYMONTHDAY=-2',    -- daily @ 2 a.m.
   end_date        => NULL,
   enabled         => TRUE,
   comments        => 'your general comment');
END;
/

BEGIN                      
  DBMS_SCHEDULER.CREATE_JOB ( 
   job_name        => 'baocaoton_job',
   job_type        => 'STORED_PROCEDURE',       -- see oracle documentation on types --
   job_action      => 'PROC_INIT_OPENING_STOCK_OF_MONTH',
   start_date      => SYSTIMESTAMP,      
   repeat_interval => 'FREQ=MONTHLY;BYMONTHDAY=-2',    -- daily @ 2 a.m.
   end_date        => NULL,
   enabled         => TRUE,
   comments        => 'your general comment');
END;
/


