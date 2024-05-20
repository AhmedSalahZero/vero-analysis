drop trigger if exists insert_net_balance_until_date ;
delimiter // 
create trigger `insert_net_balance_until_date` before insert on `unapplied_amounts` 
for each row 
begin
	declare _sum_previous_net_balance_until_date decimal(14,2) default 0 ;
	declare _net_balance_until_date decimal(14,2) default 0 ;
		select sum(amount) into _sum_previous_net_balance_until_date from `unapplied_amounts` where partner_id = new.partner_id and company_id = new.company_id and currency = new.currency ;
		set new.net_balance_until_date = new.amount + ifnull(_sum_previous_net_balance_until_date,0) ;
end  //
 
delimiter ; 
drop trigger if exists update_net_balance_until_date ;
delimiter // 
create trigger `update_net_balance_until_date` before update on `unapplied_amounts` 
for each row 
begin
	declare _sum_previous_net_balance_until_date decimal(14,2) default 0 ;
	declare _net_balance_until_date decimal(14,2) default 0 ;
		select sum(net_balance_until_date) into _sum_previous_net_balance_until_date from `unapplied_amounts` where partner_id = new.partner_id and company_id = new.company_id   ;
		set new.net_balance_until_date = new.amount + ifnull(_sum_previous_net_balance_until_date,0) ;
end  //
