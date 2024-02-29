


-- 1-1
CREATE TRIGGER `insert_net_invoice_amount_in_main_currency` BEFORE
INSERT
	ON `customer_invoices` FOR EACH ROW
set
	new.net_invoice_amount = (new.invoice_amount  + new.vat_amount - new.withhold_amount);
	
	-- 1-1
CREATE TRIGGER `update_net_invoice_amount_in_main_currency` BEFORE
UPDATE
	ON `customer_invoices` FOR EACH ROW
set
	new.net_invoice_amount = (new.invoice_amount  + new.vat_amount - new.withhold_amount);




CREATE TRIGGER `insert_invoice_amount_in_main_currency` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);

CREATE TRIGGER `insert_invoice_month` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.invoice_month = LPAD(MONTH(new.invoice_date), 2, 0);

CREATE TRIGGER `insert_invoice_status` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW BEGIN
  
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
END;

CREATE TRIGGER `insert_invoice_year` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.invoice_year = YEAR(new.invoice_date);

CREATE TRIGGER `insert_net_balance` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.net_balance = new.invoice_amount + new.vat_amount - new.withhold_amount - new.collected_amount;

CREATE TRIGGER `insert_net_balance_in_main_currency` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);

CREATE TRIGGER `insert_net_invoice_amount_in_main_currency` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.net_invoice_amount_in_main_currency = (new.net_invoice_amount * new.exchange_rate);

CREATE TRIGGER `insert_vat_amount_in_main_currency` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.vat_amount_in_main_currency = (new.vat_amount * new.exchange_rate);

CREATE TRIGGER `insert_withhold_amount_in_main_currency` BEFORE INSERT ON `customer_invoices`
 FOR EACH ROW set new.withhold_amount_in_main_currency = (new.withhold_amount * new.exchange_rate);

CREATE TRIGGER `update_invoice_amount_in_main_currency` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);

CREATE TRIGGER `update_invoice_month` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.invoice_month = LPAD(MONTH(new.invoice_date), 2, 0);

CREATE TRIGGER `update_invoice_status` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW BEGIN
  
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
END;

CREATE TRIGGER `update_invoice_year` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.invoice_year = YEAR(new.invoice_date);

CREATE TRIGGER `update_net_balance` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.net_balance = new.invoice_amount + new.vat_amount - new.withhold_amount - new.collected_amount;

CREATE TRIGGER `update_net_balance_in_main_currency` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.net_balance_in_main_currency = (new.net_balance * new.exchange_rate);

CREATE TRIGGER `update_net_invoice_amount_in_main_currency` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.net_invoice_amount_in_main_currency = (new.net_invoice_amount * new.exchange_rate);

CREATE TRIGGER `update_vat_amount_in_main_currency` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.vat_amount_in_main_currency = (new.vat_amount * new.exchange_rate);

CREATE TRIGGER `update_withhold_amount_in_main_currency` BEFORE UPDATE ON `customer_invoices`
 FOR EACH ROW set new.withhold_amount_in_main_currency = (new.withhold_amount * new.exchange_rate);
