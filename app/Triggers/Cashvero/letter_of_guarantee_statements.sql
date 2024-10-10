drop trigger if exists refresh_calculation_before_insert_letter_of_guarantee_statements ;
delimiter // 
create  trigger refresh_calculation_before_insert_letter_of_guarantee_statements before insert on `letter_of_guarantee_statements` for each row 
begin 
	declare _last_end_balance decimal(14,2) default 0 ;
	declare _previous_date date default null ;
		declare _count_all_rows integer default 0 ; 
	
		set new.created_at = CURRENT_TIMESTAMP;
		if new.source = "lg-facility" then 
		select date , end_balance  into _previous_date,_last_end_balance  from letter_of_guarantee_statements where company_id = new.company_id and currency = new.currency and lg_facility_id = new.lg_facility_id and financial_institution_id = new.financial_institution_id and source = new.source and lg_type = new.lg_type  and  full_date < new.full_date   order by full_date desc , id desc limit 1 ;
		select  count(*) into _count_all_rows from letter_of_guarantee_statements where company_id = new.company_id and currency = new.currency and lg_facility_id = new.lg_facility_id  and lg_type = new.lg_type and financial_institution_id = new.financial_institution_id and source = new.source and full_date < new.full_date   order by full_date desc , id desc limit 1 ;
		else
		select date , end_balance  into _previous_date,_last_end_balance  from letter_of_guarantee_statements where company_id = new.company_id and currency = new.currency and financial_institution_id = new.financial_institution_id and source = new.source and lg_type = new.lg_type  and  full_date < new.full_date   order by full_date desc , id desc limit 1 ;
		select  count(*) into _count_all_rows from letter_of_guarantee_statements where company_id = new.company_id and currency = new.currency  and lg_type = new.lg_type and financial_institution_id = new.financial_institution_id and source = new.source and full_date < new.full_date   order by full_date desc , id desc limit 1 ;
		end if ; 
					
		
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)); 
	 
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	set new.is_debit = if(new.debit > 0 , 1 , 0);
	set new.is_credit = if(new.debit > 0 , 0 , 1);
	

end //
delimiter ; 
drop trigger if exists refresh_calculation_before_update_letter_of_guarantee_statements ;
delimiter // 
create  trigger refresh_calculation_before_update_letter_of_guarantee_statements before update on `letter_of_guarantee_statements` for each row 
begin 
		declare _last_end_balance decimal(14,2) default 0 ;
		declare _previous_date date default null ;
		declare _count_all_rows integer default 0 ; 
		
		if new.source = "lg-facility" then 
				select date,end_balance into _previous_date, _last_end_balance  from letter_of_guarantee_statements where company_id = new.company_id and lg_facility_id = new.lg_facility_id  and financial_institution_id = new.financial_institution_id and source = new.source and lg_type = new.lg_type and currency = new.currency and full_date < new.full_date order by full_date desc , id desc limit 1 ;
else
				select date,end_balance into _previous_date, _last_end_balance  from letter_of_guarantee_statements where company_id = new.company_id  and financial_institution_id = new.financial_institution_id and source = new.source and lg_type = new.lg_type and currency = new.currency and full_date < new.full_date order by full_date desc , id desc limit 1 ;
end if ; 
		
		set _count_all_rows =1 ;
	
	 set new.beginning_balance = _last_end_balance ;
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
	
end //
