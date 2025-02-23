delimiter ;
drop trigger if exists insert_down_payment_balance_for_money_received ;
DELIMITER //
create trigger  `insert_down_payment_balance_for_money_received` before insert on `down_payment_settlements` for each row 
BEGIN
	--  set new.down_payment_balance = ifnull(new.down_payment_amount,0) - ifnull(new.total_down_payment_settlement,0);
END //



delimiter ;
drop trigger if exists update_down_payment_balance_for_money_received ;
delimiter //
create trigger  `update_down_payment_balance_for_money_received` before update on `down_payment_settlements` for each row 
BEGIN
-- set new.down_payment_balance = ifnull(new.down_payment_amount,0) - ifnull(new.total_down_payment_settlement,0);
END//
delimiter ;
drop trigger if exists delete_down_payment_balance_for_money_received ;
delimiter //
create trigger  `delete_down_payment_balance_for_money_received` before delete on `down_payment_settlements` for each row 
BEGIN
-- set old.down_payment_balance = old.down_payment_amount-old.total_down_payment_settlement;
END//
