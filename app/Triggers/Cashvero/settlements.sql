create trigger  `insert_total_collected_amount` after insert on `settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	declare _withhold_amount decimal(14,2) ;
	select sum(settlement_amount) into _settlement_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	select sum(withhold_amount) into _withhold_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `customer_invoices` set withhold_amount = _withhold_amount where new.invoice_number  = invoice_number ;

	update `customer_invoices` set collected_amount = _settlement_amount where new.invoice_number  = invoice_number ;
	
	
END
;

create trigger  `update_total_collected_amount` after update on `settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	
	select sum(settlement_amount) into _settlement_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `customer_invoices` set collected_amount = _settlement_amount where new.invoice_number  = invoice_number ;
	
	
END


create trigger  `insert_total_collected_amount` after insert on `settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	declare _withhold_amount decimal(14,2) ;
	select sum(settlement_amount) into _settlement_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	select sum(withhold_amount) into _withhold_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `customer_invoices` set withhold_amount = _withhold_amount where new.invoice_number  = invoice_number ;

	update `customer_invoices` set collected_amount = _settlement_amount where new.invoice_number  = invoice_number ;
	
	
END
;

create trigger  `update_total_collected_amount` after update on `settlements` for each row 
BEGIN
	declare _settlement_amount decimal(14,2) ;
	
	select sum(settlement_amount) into _settlement_amount from settlements where company_id = new.company_id and invoice_number = new.invoice_number ;
	
	update `customer_invoices` set collected_amount = _settlement_amount where new.invoice_number  = invoice_number ;
	
	
END
