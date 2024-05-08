drop trigger if exists refresh_calculation_before_insert_cash_in_safe_statements ;
delimiter // 
create  trigger refresh_calculation_before_insert_cash_in_safe_statements before insert on `cash_in_safe_statements` for each row 
begin 
	declare _last_end_balance decimal(14,2) default 0 ;
	declare _previous_date date default null ;
		declare _count_all_rows integer default 0 ; 
		if new.id then 
		-- في حاله التعديل
		select date,end_balance into _previous_date, _last_end_balance  from cash_in_safe_statements where company_id = new.company_id and currency = new.currency and branch_id = new.branch_id and id != new.id and date <= new.date and id != new.id  order by full_date desc , id desc limit 1 ;
		set _count_all_rows = 1 ;
		else
		-- في حالة الانشاء
		set new.created_at = CURRENT_TIMESTAMP;
		select date , end_balance  into _previous_date,_last_end_balance  from cash_in_safe_statements where company_id = new.company_id and currency = new.currency and branch_id = new.branch_id  and  date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc limit 1 ;
		select  count(*) into _count_all_rows from cash_in_safe_statements where company_id = new.company_id and currency = new.currency and branch_id = new.branch_id and date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc limit 1 ;
		end if;
		
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)); 
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	set new.is_debit = if(new.debit > 0 , 1 , 0);
	set new.is_credit = if(new.debit > 0 , 0 , 1);
	

end //
delimiter ; 
drop trigger if exists refresh_calculation_before_update_cash_in_safe_statements ;
delimiter // 
create  trigger refresh_calculation_before_update_cash_in_safe_statements before update on `cash_in_safe_statements` for each row 
begin 
	-- الكود دا نفس الكود اللي في ال
	-- before insert 
	-- فا لو عدلت ال
	-- before insert
	-- خده كوبي وبيست وحطة هنا
		
		declare _last_end_balance decimal(14,2) default 0 ;
		declare _previous_date date default null ;
		declare _count_all_rows integer default 0 ; 
		
		 
		if new.id then 
		-- في حاله التعديل
		select date,end_balance into _previous_date, _last_end_balance  from cash_in_safe_statements where company_id = new.company_id and branch_id = new.branch_id and currency = new.currency and date <= new.date   and id != new.id order by full_date desc , id desc limit 1 ;
		set _count_all_rows =1 ;
		else
		-- في حاله الانشاء
		set new.created_at = CURRENT_TIMESTAMP;
		select date , end_balance into _previous_date,_last_end_balance  from cash_in_safe_statements where company_id = new.company_id and branch_id = new.branch_id and   currency = new.currency and date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP ) order by full_date desc , id desc limit 1 ;
		select count(*) into _count_all_rows  from cash_in_safe_statements where company_id = new.company_id and branch_id = new.branch_id and currency = new.currency  and date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP ) order by full_date desc , id desc limit 1 ;
		end if;
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)) ;
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	
end //
