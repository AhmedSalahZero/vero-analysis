

-- 1-1
delimiter //
CREATE TRIGGER `insert_net_invoice_amount_for_customers` BEFORE INSERT
	ON `customer_invoices` FOR EACH ROW
	begin
		set @totalInvoiceAmount := ifnull(new.invoice_amount,0)  + ifnull(new.vat_amount,0) - ifnull(new.discount_amount,0) ;
	set new.net_invoice_amount = ( @totalInvoiceAmount  - ifnull(new.withhold_amount,0));
	set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);	
	set new.discount_amount_in_main_currency = (new.discount_amount * new.exchange_rate);	
	set new.net_balance = new.net_invoice_amount - ifnull(new.collected_amount,0);
	set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);
		
	IF (NEW.net_balance = 0 ) THEN
			SET  NEW.invoice_status = 'collected';
		ELSEIF(ifnull(NEW.collected_amount,0) + ifnull(NEW.withhold_amount,0) > 0 and DATE(NEW.invoice_due_date) < DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'partially_collected_and_past_due'; 
	ELSEIF( DATE(NEW.invoice_due_date) > DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'not_due_yet'; 
	ELSEIF( DATE(NEW.invoice_due_date) = DATE(NOW() )) THEN 
		SET  NEW.invoice_status = 'due_to_day';

	ELSEIF(ifnull(NEW.collected_amount,0) + ifnull(NEW.withhold_amount,0) = 0 and DATE(NEW.invoice_due_date) < DATE(NOW() )) THEN 
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
	set @totalInvoiceAmount := ifnull(new.invoice_amount,0)  + ifnull(new.vat_amount,0) - ifnull(new.discount_amount,0) ;
	set new.net_invoice_amount = ( @totalInvoiceAmount );
	set new.net_invoice_amount_in_main_currency = (new.net_invoice_amount * new.exchange_rate);
	set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);
	set new.net_balance = @totalInvoiceAmount - ifnull(new.withhold_amount,0) - ifnull(new.collected_amount,0);
	set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);
	set new.discount_amount_in_main_currency = (new.discount_amount * new.exchange_rate);	
	
	 IF (new.net_balance = 0 ) THEN
        SET  new.invoice_status = 'collected';
     ELSEIF(ifnull(new.collected_amount,0) + ifnull(new.withhold_amount,0) > 0 and DATE(new.invoice_due_date) < DATE(NOW() )) THEN 
     SET  new.invoice_status = 'partially_collected_and_past_due'; 
 	ELSEIF( DATE(new.invoice_due_date) > DATE(NOW() )) THEN 
     SET  new.invoice_status = 'not_due_yet'; 
	ELSEIF( DATE(new.invoice_due_date) = DATE(NOW() )) THEN 
     SET  new.invoice_status = 'due_to_day';

	 ELSEIF(ifnull(new.collected_amount,0) + ifnull(new.withhold_amount,0) = 0 and DATE(new.invoice_due_date) < DATE(NOW() )) THEN 
     SET  new.invoice_status = 'past_due';
	-- else 
	-- set new.invoice_status=new.net_balance;            
    END IF ;
	set new.invoice_month = LPAD(MONTH(new.invoice_date), 2, 0);
	set new.invoice_year = YEAR(new.invoice_date);
	set new.vat_amount_in_main_currency = (new.vat_amount * new.exchange_rate);
	set new.withhold_amount_in_main_currency = (new.withhold_amount * new.exchange_rate);
		
END//


delimiter //
create trigger remove_customer_after_delete_its_invoice  after delete 	ON `customer_invoices` FOR EACH ROW
begin 
	declare _length integer default 0 ;
	select count(*) into _length from `customer_invoices` where customer_id=old.customer_id   ;
	if _length = 0  
	then 
	delete from `partners` where  id = old.customer_id; 
	end if ;
end //  
