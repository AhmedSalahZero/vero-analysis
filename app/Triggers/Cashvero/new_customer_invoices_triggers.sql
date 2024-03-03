

-- 1-1
delimiter //
CREATE TRIGGER `insert_net_invoice_amount` BEFORE INSERT
	ON `customer_invoices` FOR EACH ROW
	begin
		set @totalInvoiceAmount := ifnull(new.invoice_amount,0)  + ifnull(new.vat_amount,0) ;
	set new.net_invoice_amount = ( @totalInvoiceAmount - ifnull(new.withhold_amount,0));
	set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);	
	set new.net_balance = @totalInvoiceAmount - ifnull(new.withhold_amount,0) - ifnull(new.collected_amount,0);
	set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);
		
	IF (NEW.net_balance = 0 ) THEN
			SET  NEW.invoice_status = 'collected';
		ELSEIF(NEW.collected_amount + NEW.withhold_amount > 0 and DATE(NEW.invoice_due_date) < DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'partially_collected_and_past_due'; 
	ELSEIF( DATE(NEW.invoice_due_date) > DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'not_due_yet'; 
	ELSEIF( DATE(NEW.invoice_due_date) = DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'due_to_day';

	ELSEIF(NEW.collected_amount + NEW.withhold_amount = 0 and DATE(NEW.invoice_due_date) < DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'past_due';            
		END IF;
		
		set new.invoice_month = LPAD(MONTH(new.invoice_date), 2, 0);
		set new.invoice_year = YEAR(new.invoice_date);
		
		set new.net_invoice_amount_in_main_currency = (new.net_invoice_amount * new.exchange_rate);
		set new.vat_amount_in_main_currency = (new.vat_amount * new.exchange_rate);
		set new.withhold_amount_in_main_currency = (new.withhold_amount * new.exchange_rate);
end//
delimiter ;
delimiter // 
	-- 1-1
CREATE TRIGGER `update_net_invoice_amount` BEFORE
UPDATE
	ON `customer_invoices` FOR EACH ROW
	begin
	set @totalInvoiceAmount := ifnull(new.invoice_amount,0)  + ifnull(new.vat_amount,0) ;
	-- set new.net_invoice_amount = ( @totalInvoiceAmount - ifnull(new.withhold_amount,0));
	set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);
	set new.net_balance = @totalInvoiceAmount - ifnull(new.withhold_amount,0) - ifnull(new.collected_amount,0);
	set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);
	 IF (new.net_balance = 0 ) THEN
        SET  new.invoice_status = 'collected';
     ELSEIF(new.collected_amount + new.withhold_amount > 0 and DATE(new.invoice_due_date) < DATE(NOW() )) THEN 
     SET  new.invoice_status = 'partially_collected_and_past_due'; 
 	ELSEIF( DATE(new.invoice_due_date) > DATE(NOW() )) THEN 
     SET  new.invoice_status = 'not_due_yet'; 
	ELSEIF( DATE(new.invoice_due_date) = DATE(NOW() )) THEN 
     SET  new.invoice_status = 'due_to_day';

	 ELSEIF(new.collected_amount + new.withhold_amount = 0 and DATE(new.invoice_due_date) < DATE(NOW() )) THEN 
     SET  new.invoice_status = 'past_due';            
    END IF ;
	set new.invoice_month = LPAD(MONTH(new.invoice_date), 2, 0);
	set new.invoice_year = YEAR(new.invoice_date);
	set new.net_invoice_amount_in_main_currency = (new.net_invoice_amount * new.exchange_rate);
	set new.vat_amount_in_main_currency = (new.vat_amount * new.exchange_rate);
	set new.withhold_amount_in_main_currency = (new.withhold_amount * new.exchange_rate);
		
END//
