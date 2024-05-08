drop trigger if exists before_insert_current_account_bank_statements ;
delimiter // 
create  trigger before_insert_current_account_bank_statements before insert on `current_account_bank_statements` for each row 
begin 
	declare _last_end_balance decimal(14,2) default 0 ;
	declare _previous_date date default null ;
		declare _count_all_rows integer default 0 ; 
		if new.id then 
		
		-- في حاله التعديل
		select date,end_balance into _previous_date, _last_end_balance  from current_account_bank_statements where company_id = new.company_id and financial_institution_account_id = new.financial_institution_account_id and  date <= new.date and id != new.id  order by full_date desc , id desc limit 1 ;
		set _count_all_rows = 1 ;
		else
		-- ف
		set new.created_at = CURRENT_TIMESTAMP;
		select date , end_balance  into _previous_date,_last_end_balance  from current_account_bank_statements where company_id = new.company_id and financial_institution_account_id = new.financial_institution_account_id  and  date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc  limit 1 ;
		select  count(*) into _count_all_rows from current_account_bank_statements where company_id = new.company_id  and financial_institution_account_id = new.financial_institution_account_id  and  date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc limit 1 ;
		end if;
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)); 
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	set new.is_debit = if(new.debit > 0 , 1 , 0);
	set new.is_credit = if(new.debit > 0 , 0 , 1);

end //
delimiter ; 
drop trigger if exists before_update_current_account_bank_statements ;
delimiter // 
create  trigger before_update_current_account_bank_statements before update on `current_account_bank_statements` for each row 
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
		select date,end_balance into _previous_date, _last_end_balance  from current_account_bank_statements where company_id = new.company_id and financial_institution_account_id = new.financial_institution_account_id  and  date <= new.date and id != new.id   order by full_date desc , id desc limit 1 ;
		set _count_all_rows =1 ;
		else
		-- في حاله الانشاء
		set new.created_at = CURRENT_TIMESTAMP;
		select date , end_balance into _previous_date,_last_end_balance  from current_account_bank_statements where company_id = new.company_id and financial_institution_account_id = new.financial_institution_account_id  and  date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc limit 1 ;
		select count(*) into _count_all_rows  from current_account_bank_statements where company_id = new.company_id and financial_institution_account_id = new.financial_institution_account_id  and  date <= new.date and created_at <= ifnull(new.created_at , CURRENT_TIMESTAMP )  order by full_date desc , id desc limit 1 ;
		end if;
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)) ;
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	
end //
