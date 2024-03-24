drop trigger if exists refresh_calculation_before_insert ;
delimiter // 
create  trigger refresh_calculation_before_insert before insert on `clean_overdraft_bank_statements` for each row 
begin 
	declare _last_end_balance decimal(14,2) default 0 ;
	declare _previous_date date default null ;
		declare _current_interest_rate decimal(5,2) default 0 ;
		declare _interest_rate decimal(5,2) default 0 ;
		declare _min_interest_rate decimal(5,2) default 0 ; 
		declare _count_all_rows integer default 0 ; 
		if new.id then 
		-- في حاله التعديل
		select date,end_balance into _previous_date, _last_end_balance  from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id and id < new.id order by id desc limit 1 ;
		set _count_all_rows = 1 ;
		else
		-- ف
		select date , end_balance  into _previous_date,_last_end_balance  from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id order by id desc limit 1 ;
		select  count(*) into _count_all_rows from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id order by id desc limit 1 ;
		end if;
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)); 
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
    set new.room = new.limit +  new.end_balance ;
	set new.is_debit = if(new.debit > 0 , 1 , 0);
	set new.is_credit = if(new.debit > 0 , 0 , 1);
	
	set @dayCounts = 0 ;
	set @interestAmount = 0 ; 
	
		-- هنبدا نحسب الفوائد اللي عليه 
		
	select min_interest_rate , interest_rate into _min_interest_rate, _interest_rate from clean_overdrafts where id = new.clean_overdraft_id ;
	set _min_interest_rate = ifnull(_min_interest_rate,0);
	set _interest_rate = ifnull(_interest_rate,0);
	
	if _min_interest_rate >  _interest_rate then 
		set _current_interest_rate = _min_interest_rate ;
	else 
		set _current_interest_rate = _interest_rate ;
	end if ;
	set _current_interest_rate = _current_interest_rate / 100 ;


	
	set @dailyInterestRate = _current_interest_rate/365 ;
	if _previous_date then 
	set @dayCounts = DATEDIFF(new.date,_previous_date) ;
	set @interestAmount = _last_end_balance * @dailyInterestRate * @dayCounts ;
	end if ; 
	set new.interest_rate_annually = _current_interest_rate ;
	set new.interest_rate_daily = @dailyInterestRate ;
	set new.days_count = @dayCounts ;
	set new.interest_amount = @interestAmount;
	-- نهاية حسبة الفوائد
	
	


end //
delimiter ;
drop trigger if exists  refresh_calculation_before_update ;
drop procedure if exists resettlement_clean_overdraft_from ;
delimiter // 
create procedure resettlement_clean_overdraft_from(in _clean_overdraft_bank_statement_to_start_from integer , in _clean_overdraft_id integer )
begin 
	declare i integer default  0 ;
	declare _current_bank_statement_id integer default 0 ;
	declare _current_clean_overdraft_id integer default 0 ;
	declare _current_company_id integer default 0 ;
	declare _current_debit decimal(14,2) default 0 ;
	declare _current_credit decimal(14,2) default 0 ;
	declare _current_date date default null ;
	declare _bank_statements_debit_greater_than_or_equal_current_item_length integer default 0 ; 
	 select count(_bank_statements_debit_greater_than_or_equal_current_item_length) into _bank_statements_debit_greater_than_or_equal_current_item_length from clean_overdraft_bank_statements where clean_overdraft_id = _clean_overdraft_id and is_debit > 0 and id >= _clean_overdraft_bank_statement_to_start_from   ;

	if _bank_statements_debit_greater_than_or_equal_current_item_length > 0 then 
		repeat
			 select id , clean_overdraft_id,debit,credit,company_id,date into _current_bank_statement_id , _current_clean_overdraft_id,_current_debit,_current_credit,_current_company_id,_current_date from clean_overdraft_bank_statements where clean_overdraft_id = _clean_overdraft_id and is_debit > 0 and id >= _clean_overdraft_bank_statement_to_start_from order by id asc limit i , 1 ;

			call start_settlement_process(_current_bank_statement_id , _current_clean_overdraft_id , _current_debit  , _current_credit , _current_company_id , _current_date);
			set i = i + 1 ; 
			until i >= _bank_statements_debit_greater_than_or_equal_current_item_length end repeat ; 
			
				 	-- في حالة التعديل .. فا عدلنا خلاص وعملنا اعادة التسديدات وفضل فيه عنصر متسددش يبقي يتحذف
		 delete from clean_overdraft_settlements where clean_overdraft_id = _clean_overdraft_id and settlement_amount = 0 ;
	
	end if;
end //
delimiter ;
drop procedure if exists reverse_clean_overdraft_settlements ;
delimiter // 
create procedure reverse_clean_overdraft_settlements(in _clean_overdraft_bank_statement_id integer , in _diff_between_new_clean_overdraft_bank_credit_and_old decimal  , in _is_debit tinyint )
begin 
		declare _clean_overdraft_withdrawal_id integer default 0 ;
		declare _settlements_count integer default 0 ;
		declare _current_settlement_id integer default 0 ;
		declare _current_settlement_amount decimal default 0 ;
		declare i integer default 0 ;
	--   هنجيب كل ال التسديدات settlements 
	-- الخاصة _clean_overdraft_bank_statement_id دي وبما انهم اكثر من واحدة يبقي هنعمل عليهم لوب 
	-- فا اول شئ هنجيب عدد العناصر علشان اللوب
	select count(*)  into _settlements_count from clean_overdraft_settlements where clean_overdraft_bank_statement_id  = _clean_overdraft_bank_statement_id ;
	if _settlements_count  >  0 and _is_debit > 0 then 
	repeat 
		-- هناخد عنصر واحد من التسديدات في كل لوب
	
		select id , settlement_amount  ,clean_overdraft_withdrawal_id into _current_settlement_id , _current_settlement_amount , _clean_overdraft_withdrawal_id from clean_overdraft_settlements where clean_overdraft_bank_statement_id = _clean_overdraft_bank_statement_id limit i , 1;
		-- لو ال دبت اكبر من صغر تبقي هي كانت تسديدة  
	
		
			-- هنقلل قيمة التسديده من جدول السحبات 
			update clean_overdraft_withdrawals 	set settlement_amount = settlement_amount - _current_settlement_amount where id = _clean_overdraft_withdrawal_id ;  
			-- بما ان قيمة ال settlement_amount 
			-- تم تحدثيها .. يبقي لازم نحدث ال نت بلانس
			update clean_overdraft_withdrawals 	set net_balance = net_balance + _current_settlement_amount  where id = _clean_overdraft_withdrawal_id ;  
			-- بعد كدا هنحذف التسديدة دي لاننا خلاص شلنا قيمتها
			-- او هنخليها عادي وعند التستيل تاني بما ان قيمت التسديد فيها صفر فا هيرجع يملها تاني
			-- delete from clean_overdraft_settlements where id = _current_settlement_id ;
			
			update  clean_overdraft_settlements set settlement_amount = 0  where id = _current_settlement_id ;
			
			-- طب ماذا لو كانت عباره عن سحبة .. يبقي في االحالة دي ملهاش قيمة في جدول ال settlements لان اللي بينحط في في جدول التسديدات هو اللي الدبنت بتاعته اكبر من صفر 
		
		
	set i = i + 1 ;
	until i  >=  _settlements_count  end repeat ;
	
	ELSEIF _diff_between_new_clean_overdraft_bank_credit_and_old != 0 then 
			select   id into   _clean_overdraft_withdrawal_id from clean_overdraft_withdrawals where clean_overdraft_bank_statement_id = _clean_overdraft_bank_statement_id ;
	
			--  في الحاله دي هنعدل بس قيمة ال
			-- end balance in withdrawals table 
			-- هنزود عليها الفرق بين ال credit القديم و الجديد
			update clean_overdraft_withdrawals 	set net_balance = net_balance + _diff_between_new_clean_overdraft_bank_credit_and_old where id = _clean_overdraft_withdrawal_id ;  
	
	end if;
end //

create  trigger refresh_calculation_before_update before update on `clean_overdraft_bank_statements` for each row 
begin 
	-- الكود دا نفس الكود اللي في ال
	-- before insert 
	-- ما عدا #REMEMBER _last_bank_statement_id , _bank_statement_start_from_id
	-- ومن اول ال
	-- call reverse_clean_overdraft_settlements
	-- فا لو عدلت ال
	-- before insert
	-- خده كوبي وبيست وحطة هنا
		
		declare _last_end_balance decimal(14,2) default 0 ;
		declare _previous_date date default null ;
		declare _current_interest_rate decimal(5,2) default 0 ;
		declare _interest_rate decimal(5,2) default 0 ;
		declare _min_interest_rate decimal(5,2) default 0 ; 
		declare _count_all_rows integer default 0 ; 
		declare _current_bank_statement_id integer default 0 ; 
		declare _current_bank_statement_debit integer default 0 ; 
		declare _i integer default 0 ;
		declare _bank_statements_greater_than_current_one_length integer default 0 ;
		
		declare _last_bank_statement_id integer default 0 ;
		declare _bank_statement_start_from_id integer default 0 ;
		declare _test_id integer default 0 ;
		 
		if new.id then 
		-- في حاله التعديل
		select id,date,end_balance into _test_id,_previous_date, _last_end_balance  from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id and id < new.id order by id desc limit 1 ;
		set _count_all_rows =1 ;
		else
		-- في حاله الانشاء
		select date , end_balance into _previous_date,_last_end_balance  from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id order by id desc limit 1 ;
		select count(*) into _count_all_rows  from clean_overdraft_bank_statements where company_id = new.company_id and clean_overdraft_id = new.clean_overdraft_id order by id desc limit 1 ;
		end if;
	 set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)) ;
	set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
    set new.room = new.limit +  new.end_balance ;


	set @dayCounts = 0 ;
	set @interestAmount = 0 ; 
	
		-- هنبدا نحسب الفوائد اللي عليه 
		
	select min_interest_rate , interest_rate into _min_interest_rate, _interest_rate from clean_overdrafts where id = new.clean_overdraft_id ;
	set _min_interest_rate = ifnull(_min_interest_rate,0);
	set _interest_rate = ifnull(_interest_rate,0);
	
	if _min_interest_rate >  _interest_rate then 
		set _current_interest_rate = _min_interest_rate ;
	else 
		set _current_interest_rate = _interest_rate ;
	end if ;
	set _current_interest_rate = _current_interest_rate / 100 ;


	
	set @dailyInterestRate = _current_interest_rate/365 ;
	if _previous_date then 
	set @dayCounts = DATEDIFF(new.date,_previous_date) ;
	set @interestAmount = _last_end_balance * @dailyInterestRate * @dayCounts ;
	end if ; 
	set new.interest_rate_annually = _current_interest_rate ;
	set new.interest_rate_daily = @dailyInterestRate ;
	set new.days_count = @dayCounts ;
	set new.interest_amount = @interestAmount;
	-- نهاية حسبة الفوائد
	-- هنيجي بعد كدا علي تحديث جدول ال 
	-- withdrawal 
	-- عن طريق اول هنعمل عمليه ال 
	-- reverse settlements 
	-- بمعني ان كل اللي التسديدات اللي 
	 call reverse_clean_overdraft_settlements(new.id,new.credit - old.credit,old.is_debit);	
	 
	 -- هنجيب اخر اي دي للحساب دا لان من عندة هنبدا نسدد من اول وجديد 
	 -- هنجيب اللي الدبت اكبر من الصفر علشان احنا هنسدد وبالتالي عايزين القيم اللي فيها دبنت
	 select id into _last_bank_statement_id from clean_overdraft_bank_statements where clean_overdraft_id = new.clean_overdraft_id and debit > 0 order by id desc limit 1 ;
		-- لو العنصر دا اللي بنحدث حاليا هو اخر عنصر هنبدا ال السايكل بتاعت اعادة توزيع التسديدات لكل العناصر من اول عنصر اتغير 
	 if(_last_bank_statement_id = new.id) then 		
			select start_settlement_from_bank_statement_id into _bank_statement_start_from_id from clean_overdrafts where id = new.clean_overdraft_id;
	
	 		 call resettlement_clean_overdraft_from(_bank_statement_start_from_id,new.clean_overdraft_id);
	
		 
	 end if;
	
	
end //

delimiter ;
drop procedure if exists start_settlement_process;
delimiter //
-- هنا هنبدا نضيف سحبة جديدة لو البنك استيت منت كان كريدت اما لو كان دبت (يعني) الدبت اكبر من الصفر وقتها هنبدا نسدد 
create procedure start_settlement_process(in _bank_statement_id integer , in _clean_overdraft_id integer , in _debit decimal , in _credit decimal , in _company_id integer , in _date date)
-- new.id , new.clean_overdraft_id , new.debit  , new.credit , new.company_id , new.date
begin 
	declare _last_end_balance decimal(14,2) default 0 ;
	declare _clean_overdraft_to_be_settled_after integer default 0 ;

	declare _due_date date default null ;
	declare _row_credit decimal(14,2) default 0 ;
	declare _first_item_to_be_settled_amount decimal(14,2) default 0 ;

	declare _total_number_or_rows_to_be_settled integer default 0 ;
	declare _clean_overdraft_withdrawal_id integer default 0 ;
	declare _first_item_to_be_settled_net_balance decimal(14,2) default 0 ;
	declare current_available_debit decimal(14,2) default _debit ;
	declare _current_settlement_amount decimal(14,2) default 0 ;
	set current_available_debit = ifnull(current_available_debit , 0);
	select to_be_setteled_max_within_days into _clean_overdraft_to_be_settled_after from clean_overdrafts where id = _clean_overdraft_id ;
	set _clean_overdraft_to_be_settled_after = ifnull(_clean_overdraft_to_be_settled_after,0);
	set _due_date = ADDDATE(_date,_clean_overdraft_to_be_settled_after);
	set _clean_overdraft_to_be_settled_after = ifnull(_clean_overdraft_to_be_settled_after , 0) ; 
	

	-- 
	
	if  _clean_overdraft_to_be_settled_after > 0 and _credit > 0   then  -- في الحاله دي هنسجل سحبه جديدة
		insert into clean_overdraft_withdrawals (clean_overdraft_bank_statement_id,clean_overdraft_id , company_id  , max_settlement_days , due_date , settlement_amount , net_balance) values(_bank_statement_id,_clean_overdraft_id,_company_id,_clean_overdraft_to_be_settled_after,_due_date,0,_credit);
	end if ; 
	if _clean_overdraft_to_be_settled_after > 0 then  -- في الحاله دي هنضيف القيم في جداول clean_overdraft_settlements + clean_overdraft_withdrawals
		select count(*) into _total_number_or_rows_to_be_settled from clean_overdraft_withdrawals where clean_overdraft_id = _clean_overdraft_id and net_balance > 0;
		set _total_number_or_rows_to_be_settled = ifnull(_total_number_or_rows_to_be_settled , 0);
		
		
		
		while current_available_debit > 0 and _total_number_or_rows_to_be_settled > 0 DO  -- معناه ان معاه فلوس يسدد بيها وكمان عليه فلوس لسه ما اتسددتش
		-- get first item need to be settled  هنجيب اول عنصر في المسحوبات محتاج يتعمله تسديد .. اللي هو النت بالانس بتاعه اكبر من الصفر
			-- هنجيب اللي المفروض تتسدد والاولويه هتكون للفؤايد اللي عليه
			select credit , settlement_amount , net_balance , clean_overdraft_withdrawals.id into _row_credit , _first_item_to_be_settled_amount , _first_item_to_be_settled_net_balance , _clean_overdraft_withdrawal_id from clean_overdraft_bank_statements
			join clean_overdraft_withdrawals on clean_overdraft_withdrawals.clean_overdraft_bank_statement_id = clean_overdraft_bank_statements.id
			where clean_overdraft_bank_statements.company_id =_company_id  
			and clean_overdraft_bank_statements.credit > 0  -- علشان نجيب التسديدات فقط
			and clean_overdraft_bank_statements.clean_overdraft_id = _clean_overdraft_id  -- لحساب الاوفر درافت دا
			and clean_overdraft_withdrawals.net_balance > 0 -- اي متبقي عليها فلوس 
			order by clean_overdraft_bank_statements.priority , clean_overdraft_bank_statements.id asc limit 1  ; --  بنرتب علي حس الاولويه علشان الفؤايد ليها الالويه ولو تساو في الاولويه هناخد الاقدم يعني اللي الاي دي بتاعه اصغر 
		
		 
			if(_first_item_to_be_settled_net_balance > current_available_debit) then   -- معناه ان الفلوس اللي عليه اكبر من الفلوس اللي معاه
			set _current_settlement_amount = current_available_debit ;
			else  -- الفلوس اللي معاه اكبر او تساوي وبالتالي هنسدد كل اللي معاه
			set _current_settlement_amount = _first_item_to_be_settled_net_balance ;
			end if ;
			set _first_item_to_be_settled_amount = ifnull(_first_item_to_be_settled_amount , 0);
			set _first_item_to_be_settled_net_balance = ifnull(_first_item_to_be_settled_net_balance , 0);
			-- لو فيه عنصر قديم في التسديدات قيمة ال
			-- settlement_amount 
			-- بتاعته بصفر لهذا العنصر وقتها حدثه .. ودا بيحصل لما بنعمل 
			-- resettlement ب
			-- اي بعد التحديث .. ولو مش موجود يبقي احنا في حاله الانشاء يبقي ضيف عنصر جديد
			
				
		 
			if (select exists(select * from clean_overdraft_settlements where clean_overdraft_withdrawal_id = _clean_overdraft_withdrawal_id and settlement_amount = 0 and clean_overdraft_bank_statement_id = _bank_statement_id  )) then
			update clean_overdraft_settlements set settlement_amount = _current_settlement_amount where clean_overdraft_withdrawal_id = _clean_overdraft_withdrawal_id and clean_overdraft_bank_statement_id = _bank_statement_id and settlement_amount = 0 order by id asc limit 1;
			else 
			insert into clean_overdraft_settlements (clean_overdraft_bank_statement_id,clean_overdraft_withdrawal_id,clean_overdraft_id , company_id   , settlement_amount) values(_bank_statement_id,_clean_overdraft_withdrawal_id,_clean_overdraft_id,_company_id,_current_settlement_amount);
			
			end if ;
			
			
			update clean_overdraft_withdrawals set settlement_amount = _current_settlement_amount + ifnull(settlement_amount,0) where id = _clean_overdraft_withdrawal_id ;
			update clean_overdraft_withdrawals set net_balance = _row_credit - settlement_amount where id = _clean_overdraft_withdrawal_id  ;
			set current_available_debit = current_available_debit - _current_settlement_amount ;
			select count(*) into _total_number_or_rows_to_be_settled from clean_overdraft_withdrawals where clean_overdraft_id = _clean_overdraft_id and net_balance > 0;
			set _total_number_or_rows_to_be_settled = ifnull(_total_number_or_rows_to_be_settled , 0);
		end while ;
	
	end if ;
	
end //
delimiter ; 
drop trigger if exists insert_into_overdraft_withdrawal_after_insert ;
delimiter // 
create  trigger insert_into_overdraft_withdrawal_after_insert after insert on `clean_overdraft_bank_statements` for each row 
begin 
	 call start_settlement_process(new.id , new.clean_overdraft_id , new.debit  , new.credit , new.company_id , new.date);
end //







delimiter ;
drop procedure if exists recalculate_end_of_month_clean_overdraft_interests ;
delimiter // 
create procedure recalculate_end_of_month_clean_overdraft_interests()
begin 
		declare i INTEGER DEFAULT 0 ;
 	   declare current_id integer default 0 ;
   	 declare _clean_overdraft_bank_statement_id integer default 0 ;
   	 declare _clean_overdraft_id integer default 0 ;
     declare _company_id integer default 0 ;
	 declare _current_interest_amount decimal(14,2) default 0;
	 declare _limit decimal(14,2) default 0;
	 declare _largest_end_balance decimal(14,2) default 0;
	declare interest_type_text varchar(100) default 'interest';
	 declare highest_debit_balance_text varchar(100) default 'highest_debit_balance';
   	declare _highest_debt_balance_rate decimal(5,2) default 0 ;
	 select count(*) into @n from  clean_overdraft_bank_statements where `type` != interest_type_text and `type` != highest_debit_balance_text and EXTRACT(MONTH from date) = EXTRACT(MONTH from current_date()) and  EXTRACT(YEAR from date) = EXTRACT(YEAR from current_date()) group by clean_overdraft_id;
	set _highest_debt_balance_rate = ifnull(_highest_debt_balance_rate,0);
    set @n = ifnull(@n,0);
    if @n > 0 then 
    repeat 
				-- حساب الفايدة نهاية كل شهر
                select clean_overdraft_id , sum(interest_amount) , max(end_balance) into _clean_overdraft_id,_current_interest_amount,_largest_end_balance from  clean_overdraft_bank_statements where `type` != interest_type_text and `type` != highest_debit_balance_text and EXTRACT(MONTH from date) = EXTRACT(MONTH from current_date()) and  EXTRACT(YEAR from date) = EXTRACT(YEAR from current_date()) group by clean_overdraft_id limit i , 1;
				select company_id,`limit`,highest_debt_balance_rate into _company_id,_limit,_highest_debt_balance_rate from clean_overdrafts where id = _clean_overdraft_id  ;
				set _current_interest_amount = ifnull(_current_interest_amount,0);
				set _largest_end_balance = ifnull(_largest_end_balance,0);
				insert into clean_overdraft_bank_statements (type ,priority,clean_overdraft_id,money_received_id,company_id,date,`limit`,credit,interest_type) values(interest_type_text,1,_clean_overdraft_id,0,_company_id,current_date(),_limit,_current_interest_amount,'end_of_month');
          		  -- حساب ال highest debit balance
				set _current_interest_amount = _highest_debt_balance_rate / 100 * _largest_end_balance ; 
				insert into clean_overdraft_bank_statements (type,priority ,clean_overdraft_id,money_received_id,company_id,date,`limit`,credit,interest_type) values(highest_debit_balance_text,1,_clean_overdraft_id,0,_company_id,current_date(),_limit,_current_interest_amount,'end_of_month');
			set i = i +1 ; 
			UNTIL i >= @n  end repeat ;
    end if ;
	
end //
delimiter ; 
DROP EVENT IF EXISTS `recalculate_end_of_month_clean_overdraft_interests_event`;
DELIMITER $$
CREATE EVENT `recalculate_end_of_month_clean_overdraft_interests_event`
ON SCHEDULE EVERY  1 day
STARTS '2022-03-31 23:30:00'
ON COMPLETION PRESERVE
DO BEGIN
call recalculate_end_of_month_clean_overdraft_interests();
END$$
DELIMITER ;
