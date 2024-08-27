delimiter ;
drop trigger if exists `insert_total_paid_amount` ;
DELIMITER //
create trigger  `insert_total_paid_amount` after insert on `payment_settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	declare _withhold_amount decimal(14,2) ;
	select sum(settlement_amount) into _settlement_amount from payment_settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	-- insert into debugging 
	select sum(withhold_amount) into _withhold_amount from payment_settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `supplier_invoices` set withhold_amount = _withhold_amount where new.invoice_number  = invoice_number and company_id = new.company_id ;

	update `supplier_invoices` set paid_amount = _settlement_amount where new.invoice_number  = invoice_number and company_id = new.company_id ;
	
	
END //
delimiter ;
drop trigger if exists update_total_paid_amount ;
delimiter // 
create trigger  `update_total_paid_amount` after update on `payment_settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	
	select sum(settlement_amount) into _settlement_amount from payment_settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `supplier_invoices` set paid_amount = _settlement_amount where new.invoice_number  = invoice_number and company_id = new.company_id ;
	
END//
delimiter ;
drop trigger if exists delete_total_paid_amount ;
delimiter // 
create trigger  `delete_total_paid_amount` after delete on `payment_settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	declare _withhold_amount decimal(14,2) ;
	select sum(settlement_amount) into _settlement_amount from payment_settlements where company_id = old.company_id and invoice_number = old.invoice_number ;
	select sum(withhold_amount) into _withhold_amount from payment_settlements where company_id = old.company_id and invoice_number = old.invoice_number ;
	update `supplier_invoices` set paid_amount = ifnull(_settlement_amount,0) where old.invoice_number  = invoice_number and company_id = old.company_id ;
	update `supplier_invoices` set withhold_amount = ifnull(_withhold_amount,0) where old.invoice_number  = invoice_number and company_id = old.company_id ;
END//
