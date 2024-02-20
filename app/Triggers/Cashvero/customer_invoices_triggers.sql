-- 1-1
CREATE TRIGGER `insert_invoice_amount_in_main_currency` BEFORE
INSERT
	ON `customer_invoices` FOR EACH ROW
set
	new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);

-- 1-2
CREATE TRIGGER `update_invoice_amount_in_main_currency` BEFORE
UPDATE
	ON `customer_invoices` FOR EACH ROW
set
	new.invoice_amount_in_main_currency = (new.invoice_amount * new.exchange_rate);

-- 10-1
CREATE TRIGGER `insert_invoice_status` BEFORE
INSERT
	ON `customer_invoices` FOR EACH ROW BEGIN IF (NEW.net_balance = 0) THEN
SET
	NEW.invoice_status = 'collected';

ELSEIF(
	NEW.collected_amount + NEW.withhold_amount > 0
	and DATE(NEW.invoice_due_date) < DATE(NOW())
) THEN
SET
	NEW.invoice_status = 'partially_collected_and_past_due';

ELSEIF(DATE(NEW.invoice_due_date) > DATE(NOW())) THEN
SET
	NEW.invoice_status = 'not_due_yet';

ELSEIF(DATE(NEW.invoice_due_date) = DATE(NOW())) THEN
SET
	NEW.invoice_status = 'due_to_day';

ELSEIF(
	NEW.collected_amount + NEW.withhold_amount = 0
	and DATE(NEW.invoice_due_date) < DATE(NOW())
) THEN
SET
	NEW.invoice_status = 'past_due';

END IF;

END;

-- 10-2
CREATE TRIGGER `update_invoice_status` BEFORE
UPDATE
	ON `customer_invoices` FOR EACH ROW BEGIN IF (NEW.net_balance = 0) THEN
SET
	NEW.invoice_status = 'collected';

ELSEIF(
	NEW.collected_amount + NEW.withhold_amount > 0
	and DATE(NEW.invoice_due_date) < DATE(NOW())
) THEN
SET
	NEW.invoice_status = 'partially_collected_and_past_due';

ELSEIF(DATE(NEW.invoice_due_date) > DATE(NOW())) THEN
SET
	NEW.invoice_status = 'not_due_yet';

ELSEIF(DATE(NEW.invoice_due_date) = DATE(NOW())) THEN
SET
	NEW.invoice_status = 'due_to_day';

ELSEIF(
	NEW.collected_amount + NEW.withhold_amount = 0
	and DATE(NEW.invoice_due_date) < DATE(NOW())
) THEN
SET
	NEW.invoice_status = 'past_due';

END IF;

END
