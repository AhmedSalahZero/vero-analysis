				
				delimiter ;
				drop trigger if exists before_insert_overdraft_against_commercial_paper ;
				delimiter // 
				create  trigger before_insert_overdraft_against_commercial_paper before insert on `overdraft_against_commercial_paper_bank_statements` for each row 
				begin 
					declare _last_end_balance decimal(14,2) default 0 ;
					declare _previous_date date default null ;
						declare _current_interest_rate decimal(5,2) default 0 ;
						declare _interest_rate decimal(5,2) default 0 ;
						declare _min_interest_rate decimal(5,2) default 0 ; 
						declare _count_all_rows integer default 0 ; 
						declare interest_type_text varchar(100) default 'interest';
						declare highest_debit_balance_text varchar(100) default 'highest_debit_balance';
						declare _accumulated_limit decimal (14,2) default 0 ;
						-- في حالة الانشاء
						set new.created_at = CURRENT_TIMESTAMP;
						select date , end_balance  into _previous_date,_last_end_balance  from overdraft_against_commercial_paper_bank_statements where  overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and full_date < new.full_date order by full_date desc , id desc limit 1 ; -- رتبت بالاي دي الاكبر علشان  لو كانوا متساوين في التاريخ بالظبط (ودا احتمال ضعيف ) ياخد اللي ال اي دي بتاعه اكبر
						select  count(*) into _count_all_rows from overdraft_against_commercial_paper_bank_statements where  overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and full_date < new.full_date ;

					set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)); 
					set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
				--	call calculate_limit_overdraft_against_commercial_bank_statements(new.overdraft_against_commercial_paper_id , new.money_received_id , new.full_date , new.company_id,_limit);
				
					select `accumulated_limit`  into _accumulated_limit from overdraft_against_commercial_paper_limits where is_active = 1 and company_id = new.company_id and overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and date(full_date) <=  date(new.full_date)  order by full_date desc limit 1 ;
					set new.limit = _accumulated_limit;
					set new.room = _accumulated_limit  +  new.end_balance ;
					set new.is_debit = if(new.debit > 0 , 1 , 0);
					set new.is_credit = if(new.debit > 0 , 0 , 1);
					
					set @dayCounts = 0 ;
					set @interestAmount = 0 ; 
					
						-- هنبدا نحسب الفوائد اللي عليه 
						
					select min_interest_rate , interest_rate into _min_interest_rate, _interest_rate from overdraft_against_commercial_paper_rates where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and date <= new.date order by date desc , id desc limit 1 ;
					
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
					set @interestAmount = if(_last_end_balance < 0 , _last_end_balance * @dailyInterestRate * @dayCounts , 0)  ;
					end if ; 
					set new.interest_rate_annually = _current_interest_rate ;
					set new.interest_rate_daily = @dailyInterestRate ;
					set new.days_count = @dayCounts ;
					set new.interest_amount = @interestAmount;
					-- نهاية حسبة الفوائد
					
					


				end //
				delimiter ;
				drop trigger if exists  before_update_overdraft_against_commercial_paper ;
				 
				drop procedure if exists resettlement_overdraft_against_commercial_paper_from ;
				
				
				
				delimiter // 
				create procedure resettlement_overdraft_against_commercial_paper_from(in _type varchar(255),in _start_update_from_date_time date , in _overdraft_against_commercial_paper_id integer , in _current_company_id integer  )
				begin 
					declare _current_debit decimal(14,2) default 0 ;
					declare _total_settlements decimal(14,2) default 0 ;

					select sum(debit) into _current_debit from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = _overdraft_against_commercial_paper_id and is_debit > 0    ;
					select sum(settlement_amount) into _total_settlements from overdraft_against_commercial_paper_withdrawals where overdraft_against_commercial_paper_id =  _overdraft_against_commercial_paper_id ;
					set _current_debit = _current_debit - _total_settlements ;
					
							call start_settlement_process_overdraft_against_commercial_paper(_type,0 , _overdraft_against_commercial_paper_id , _current_debit  ,0 , _current_company_id , CURRENT_TIMESTAMP);
					
					
				end //
					
				delimiter ;
				drop procedure if exists reverse_overdraft_against_commercial ;
				delimiter // 
				create procedure reverse_overdraft_against_commercial(in _start_update_from_date_time date  , in _overdraft_against_commercial_paper_id integer )
				begin 
				
					-- declare i INTEGER DEFAULT 0 ;
				--	declare _overdraft_against_commercial_paper_withdrawal_id integer default 0 ;
				-- هنجيب كل السحوبات اللي تاريخها اكبر من تاريخ الاغلاق لان اللي تاريخها اصغر من او يساوي تاريخ الاغلاق مش هنقدر نيجي يمها
					update overdraft_against_commercial_paper_withdrawals set net_balance = net_balance + settlement_amount , settlement_amount = 0 where due_date > _start_update_from_date_time  and overdraft_against_commercial_paper_id = _overdraft_against_commercial_paper_id ;
				end //
				
				delimiter ; 
				

				create trigger before_update_overdraft_against_commercial_paper before update on `overdraft_against_commercial_paper_bank_statements` for each row 
				begin 

						declare _current_debit decimal(14,2) default 0 ;
						declare _total_settlements decimal(14,2) default 0 ;
						declare _last_end_balance decimal(14,2) default 0 ;
						declare _start_update_from_date_time date default '2000-01-01' ;
						declare _previous_date date default null ;
						declare _last_bank_statement_date_to_start_settlement_from datetime default null ;
						declare _current_interest_rate decimal(5,2) default 0 ;
						declare _interest_rate decimal(5,2) default 0 ;
						declare _min_interest_rate decimal(5,2) default 0 ; 
						declare _count_all_rows integer default 0 ; 
						declare _current_bank_statement_id integer default 0 ; 
						declare _current_bank_statement_debit integer default 0 ; 
						declare _i integer default 0 ;
						declare _origin_update_row_is_debit integer default 0 ;
						declare _bank_statements_greater_than_current_one_length integer default 0 ;
						
						declare _last_bank_statement_date datetime default null ;
						declare _last_id integer default 0 ;
							declare _current_interest_amount decimal(14,2) default 0;
							declare _largest_end_balance decimal(14,2) default 0;
							declare _accumulated_limit decimal(14,2) default 0;
							declare _highest_debt_balance_rate decimal(5,2) default 0 ;
						-- declare _bank_statement_start_from_date datetime default null ;
							declare _overdraft_against_commercial_paper_to_be_settled_after integer default 0 ;
							declare interest_type_text varchar(100) default 'interest';
							declare highest_debit_balance_text varchar(100) default 'highest_debit_balance';


					if(new.type = 'payable_cheque') then
						select to_be_setteled_max_within_days into _overdraft_against_commercial_paper_to_be_settled_after from overdraft_against_commercial_papers where id = new.overdraft_against_commercial_paper_id ;
						update overdraft_against_commercial_paper_withdrawals set due_date =  ADDDATE(new.date,_overdraft_against_commercial_paper_to_be_settled_after) where overdraft_against_commercial_paper_bank_statement_id = new.id ;
						
					elseif (new.type = 'outgoing-transfer') then
					select to_be_setteled_max_within_days into _overdraft_against_commercial_paper_to_be_settled_after from overdraft_against_commercial_papers where id = new.overdraft_against_commercial_paper_id ;
						update overdraft_against_commercial_paper_withdrawals set due_date =  ADDDATE(new.date,_overdraft_against_commercial_paper_to_be_settled_after) where overdraft_against_commercial_paper_bank_statement_id = new.id ;
						
						
					end if;
						select date,end_balance into _previous_date, _last_end_balance  from overdraft_against_commercial_paper_bank_statements where  overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and full_date < new.full_date order by full_date desc , id desc  limit 1 ; -- رتبت بالاي دي الاكبر علشان  لو كانوا متساوين في التاريخ بالظبط (ودا احتمال ضعيف ) ياخد اللي ال اي دي بتاعه اكبر
						set _count_all_rows =1 ;
					set new.beginning_balance = if(_count_all_rows,_last_end_balance,ifnull(new.beginning_balance,0)) ;
					
					select `accumulated_limit`  into _accumulated_limit from overdraft_against_commercial_paper_limits where is_active = 1 and company_id = new.company_id and overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and date(full_date) <=  date(new.full_date)  order by full_date desc limit 1 ;
					set new.end_balance = new.beginning_balance + new.debit - new.credit ; 
					set new.limit = _accumulated_limit;
					set new.room = _accumulated_limit +  new.end_balance ;
					
					

					set @dayCounts = 0 ;
					set @interestAmount = 0 ; 
					
						-- هنبدا نحسب الفوائد اللي عليه 
						
					select min_interest_rate , interest_rate into _min_interest_rate, _interest_rate from overdraft_against_commercial_paper_rates where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and date <= new.date order by date desc , id desc limit 1 ;
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
					set @interestAmount = if(_last_end_balance < 0 , _last_end_balance * @dailyInterestRate * @dayCounts , 0)  ;
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
					
					
					
					
					-- هنجيب اخر اي دي للحساب دا لان من عندة هنبدا نسدد من اول وجديد 
					-- هنجيب اللي الدبت اكبر من الصفر علشان احنا هنسدد وبالتالي عايزين القيم اللي فيها دبنت
					-- select date into _last_bank_statement_date from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and debit > 0 order by date desc , created_at desc limit 1 ;
					-- select full_date into _last_bank_statement_date from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and debit > 0 order by full_date desc limit 1 ;
						-- لو العنصر دا اللي بنحدث حاليا هو اخر عنصر هنبدا ال السايكل بتاعت اعادة توزيع التسديدات لكل العناصر من اول عنصر اتغير 
							-- select full_date  into _last_bank_statement_date_to_start_settlement_from from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id order by full_date desc , priority asc limit 1 ;
							select full_date into _last_bank_statement_date_to_start_settlement_from from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id order by full_date desc , priority asc , id asc limit 1 ; 
							select oldest_full_date,origin_update_row_is_debit into _start_update_from_date_time,_origin_update_row_is_debit from overdraft_against_commercial_papers where id = new.overdraft_against_commercial_paper_id  ; 
			--				select start_settlement_from_bank_statement_date into _last_bank_statement_date_to_start_settlement_from from overdraft_against_commercial_papers where id = new.overdraft_against_commercial_paper_id ; 
							-- عايزين بدل السطر اللي فوق نجيب ال closing date 
						
					if(_last_bank_statement_date_to_start_settlement_from = new.full_date) then 		
					
						select sum(debit) into _current_debit from overdraft_against_commercial_paper_bank_statements where overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and is_debit > 0    ;
						select sum(settlement_amount) into _total_settlements from overdraft_against_commercial_paper_withdrawals where overdraft_against_commercial_paper_id =  new.overdraft_against_commercial_paper_id ;
						set _current_debit = _current_debit - _total_settlements ;
						
					
					
							call reverse_overdraft_against_commercial(_start_update_from_date_time,new.overdraft_against_commercial_paper_id);	
							call resettlement_overdraft_against_commercial_paper_from(new.type,_start_update_from_date_time,new.overdraft_against_commercial_paper_id,new.company_id);
				
					end if;
					
					
					
					
					
					
					
					
					-- اعادة حساب فايدة نهاية كل شهر (في حالة التعديل مش الانشاء)

					if new.id and (new.type = interest_type_text or new.type = highest_debit_balance_text ) then 
								select  sum(interest_amount) , max(end_balance) into _current_interest_amount,_largest_end_balance from  overdraft_against_commercial_paper_bank_statements where `type` != interest_type_text and `type` != highest_debit_balance_text and overdraft_against_commercial_paper_id = new.overdraft_against_commercial_paper_id and EXTRACT(MONTH from date) = EXTRACT(MONTH from new.date ) and  EXTRACT(YEAR from date) = EXTRACT(YEAR from new.date) ;
								set _current_interest_amount = ifnull(_current_interest_amount,0);
								select highest_debt_balance_rate into _highest_debt_balance_rate from overdraft_against_commercial_papers where id = new.overdraft_against_commercial_paper_id  ;
								if new.type = interest_type_text then 
								-- للفايدة الخاصة باخر الشهر
									set new.credit = _current_interest_amount ;
								elseif new.type = highest_debit_balance_text then 
								-- حساب ال highest debit balance
								set _current_interest_amount = _highest_debt_balance_rate / 100 * _largest_end_balance ; 
								
									set new.credit = _current_interest_amount ;
								end if;
								
					end if ;
					
					
					
				end //

				delimiter ;
				drop procedure if exists start_settlement_process_overdraft_against_commercial_paper;
				delimiter //
				-- هنا هنبدا نضيف سحبة جديدة لو البنك استيت منت كان كريدت اما لو كان دبت (يعني) الدبت اكبر من الصفر وقتها هنبدا نسدد 
				create procedure start_settlement_process_overdraft_against_commercial_paper(in _type varchar(255) ,in _bank_statement_id integer , in _overdraft_against_commercial_paper_id integer , in _debit decimal , in _credit decimal , in _company_id integer , in _date_for_settlement date)
				-- new.id , new.overdraft_against_commercial_paper_id , new.debit  , new.credit , new.company_id , new.date
				begin 
					declare _overdraft_against_commercial_paper_to_be_settled_after integer default 0 ;
					declare _due_date date default null ;
					declare _row_credit decimal(14,2) default 0 ;
					declare _first_item_to_be_settled_amount decimal(14,2) default 0 ;
					declare _total_number_or_rows_to_be_settled integer default 0 ;
					declare _overdraft_against_commercial_paper_withdrawal_id integer default 0 ;
					declare _first_item_to_be_settled_net_balance decimal(14,2) default 0 ;
					declare current_available_debit decimal(14,2) default _debit ;
					declare _current_settlement_amount decimal(14,2) default 0 ;
					set current_available_debit = ifnull(current_available_debit , 0);
					select to_be_setteled_max_within_days into _overdraft_against_commercial_paper_to_be_settled_after from overdraft_against_commercial_papers where id = _overdraft_against_commercial_paper_id ;
					set _overdraft_against_commercial_paper_to_be_settled_after = ifnull(_overdraft_against_commercial_paper_to_be_settled_after,0);
					set _due_date = if(_type = 'outstanding_balance' , _date_for_settlement ,ADDDATE(_date_for_settlement,_overdraft_against_commercial_paper_to_be_settled_after));
					set _overdraft_against_commercial_paper_to_be_settled_after = ifnull(_overdraft_against_commercial_paper_to_be_settled_after , 0) ; 

					-- 
					if  _overdraft_against_commercial_paper_to_be_settled_after > 0 and _credit > 0 and _type != 'interest' and _type != 'highest_debit_balance' and _type != 'fees'  then  -- في الحاله دي هنسجل سحبه جديدة
						insert into overdraft_against_commercial_paper_withdrawals (overdraft_against_commercial_paper_bank_statement_id,overdraft_against_commercial_paper_id , company_id  , max_settlement_days , due_date , settlement_amount , net_balance,created_at) values(_bank_statement_id,_overdraft_against_commercial_paper_id,_company_id,_overdraft_against_commercial_paper_to_be_settled_after,_due_date,0,_credit,CURRENT_TIMESTAMP);
					end if ; 
					if _overdraft_against_commercial_paper_to_be_settled_after > 0 then  -- في الحاله دي هنضيف القيم في جداول overdraft_against_commercial_paper_settlements + overdraft_against_commercial_paper_withdrawals
					
						select count(*) into _total_number_or_rows_to_be_settled from overdraft_against_commercial_paper_withdrawals where overdraft_against_commercial_paper_id = _overdraft_against_commercial_paper_id and net_balance > 0;
						set _total_number_or_rows_to_be_settled = ifnull(_total_number_or_rows_to_be_settled , 0);
						
					
						
						while current_available_debit > 0 and _total_number_or_rows_to_be_settled > 0 DO  -- معناه ان معاه فلوس يسدد بيها وكمان عليه فلوس لسه ما اتسددتش
					
						-- get first item need to be settled  هنجيب اول عنصر في المسحوبات محتاج يتعمله تسديد .. اللي هو النت بالانس بتاعه اكبر من الصفر
							-- هنجيب اللي المفروض تتسدد والاولويه هتكون للفؤايد اللي عليه
							select credit , settlement_amount , net_balance , overdraft_against_commercial_paper_withdrawals.id into _row_credit , _first_item_to_be_settled_amount , _first_item_to_be_settled_net_balance , _overdraft_against_commercial_paper_withdrawal_id from overdraft_against_commercial_paper_bank_statements
							join overdraft_against_commercial_paper_withdrawals on overdraft_against_commercial_paper_withdrawals.overdraft_against_commercial_paper_bank_statement_id = overdraft_against_commercial_paper_bank_statements.id
							where overdraft_against_commercial_paper_bank_statements.company_id =_company_id  
							and overdraft_against_commercial_paper_bank_statements.credit > 0  -- علشان نجيب التسديدات فقط
							and overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id = _overdraft_against_commercial_paper_id  -- لحساب الاوفر درافت دا
							and overdraft_against_commercial_paper_withdrawals.net_balance > 0 -- اي متبقي عليها فلوس 
							order by  overdraft_against_commercial_paper_withdrawals.due_date asc , overdraft_against_commercial_paper_bank_statements.priority asc , overdraft_against_commercial_paper_bank_statements.id asc  limit 1  ; --  بنرتب علي حس الاولويه علشان الفؤايد ليها الالويه ولو تساو في الاولويه هناخد الاقدم يعني اللي الاي دي بتاعه اصغر 
						
						
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
						
							-- insert into overdraft_against_commercial_paper_settlements (overdraft_against_commercial_paper_bank_statement_id,overdraft_against_commercial_paper_withdrawal_id,overdraft_against_commercial_paper_id , company_id   , settlement_amount,created_at) values(0,_overdraft_against_commercial_paper_withdrawal_id,_overdraft_against_commercial_paper_id,_company_id,_current_settlement_amount,CURRENT_TIMESTAMP);
					
							

								
								
							
							update overdraft_against_commercial_paper_withdrawals set settlement_amount = _current_settlement_amount + ifnull(settlement_amount,0) , net_balance = _row_credit - settlement_amount where id = _overdraft_against_commercial_paper_withdrawal_id ;
							
							set current_available_debit = current_available_debit - _current_settlement_amount ;
							
							select count(*) into _total_number_or_rows_to_be_settled from overdraft_against_commercial_paper_withdrawals where overdraft_against_commercial_paper_id = _overdraft_against_commercial_paper_id and net_balance > 0;
							set _total_number_or_rows_to_be_settled = ifnull(_total_number_or_rows_to_be_settled , 0);
						end while ;
					
					end if ;
					
				end //
				delimiter ; 
				drop trigger if exists insert_into_overdraft_withdrawal_after_insert_commercial_paper ;
				delimiter // 
				create  trigger insert_into_overdraft_withdrawal_after_insert_commercial_paper after insert on `overdraft_against_commercial_paper_bank_statements` for each row 
				begin 
			
					declare _date_for_settlement date default ifnull(new.outstanding_withdrawal_date,new.date) ;
					if  new.type = 'payable_cheque'
					then 
					select actual_payment_date into  _date_for_settlement from payable_cheques join money_payments on 
						money_payments.id = payable_cheques.money_payment_id 
					where payable_cheques.money_payment_id = money_payments.id
					and payable_cheques.money_payment_id = new.money_payment_id ; 
					elseif new.type = 'outgoing-transfer' then 
					
					select actual_payment_date into  _date_for_settlement from outgoing_transfers join money_payments on 
						money_payments.id = outgoing_transfers.money_payment_id 
					where outgoing_transfers.money_payment_id = money_payments.id
					and outgoing_transfers.money_payment_id = new.money_payment_id ; 
					
					
					end if  ;
					if new.is_credit > 0 then
						call start_settlement_process_overdraft_against_commercial_paper(new.type,new.id , new.overdraft_against_commercial_paper_id , new.debit  , new.credit , new.company_id ,_date_for_settlement);
					end if;
				end //


				delimiter ;
				drop procedure if exists end_of_month_overdraft_against_commercial_paper_interests ;
				delimiter // 
				create procedure end_of_month_overdraft_against_commercial_paper_interests()
				begin 
					declare current_id integer default 0 ;
					declare _overdraft_against_commercial_paper_bank_statement_id integer default 0 ;
					declare _overdraft_against_commercial_paper_id integer default 0 ;
					declare _company_id integer default 0 ;
					declare _limit decimal(14,2) default 0;
					declare _largest_end_balance decimal(14,2) default 0;
					declare interest_type_text varchar(100) default 'interest';
					declare highest_debit_balance_text varchar(100) default 'highest_debit_balance';
					declare _current_interest_amount decimal(14,2) default 0;
					declare _highest_debt_balance_rate decimal(5,2) default 0 ;
					declare i INTEGER DEFAULT 0 ;
					set _highest_debt_balance_rate = ifnull(_highest_debt_balance_rate,0);
					select count(distinct(overdraft_against_commercial_paper_id)) into @n from  overdraft_against_commercial_paper_bank_statements where `type` != interest_type_text and `type` != highest_debit_balance_text and EXTRACT(MONTH from date) = EXTRACT(MONTH from current_date()) and  EXTRACT(YEAR from date) = EXTRACT(YEAR from current_date()) group by overdraft_against_commercial_paper_id;
					set @n = ifnull(@n,0);
					if @n > 0 then 
					
					repeat 
								-- حساب الفايدة نهاية كل شهر
								select overdraft_against_commercial_paper_id , sum(interest_amount) , max(end_balance) into _overdraft_against_commercial_paper_id,_current_interest_amount,_largest_end_balance from  overdraft_against_commercial_paper_bank_statements where `type` != interest_type_text and `type` != highest_debit_balance_text and EXTRACT(MONTH from date) = EXTRACT(MONTH from current_date()) and  EXTRACT(YEAR from date) = EXTRACT(YEAR from current_date()) group by overdraft_against_commercial_paper_id limit i , 1;
								set _current_interest_amount = ifnull(_current_interest_amount , 0);
								set _largest_end_balance = ifnull(_largest_end_balance,0);
								select company_id,`limit`,highest_debt_balance_rate into _company_id,_limit,_highest_debt_balance_rate from overdraft_against_commercial_papers where id = _overdraft_against_commercial_paper_id  ;
								insert into overdraft_against_commercial_paper_bank_statements (type ,priority,overdraft_against_commercial_paper_id,money_received_id,company_id,date,`limit`,credit,interest_type,full_date) values(interest_type_text,1,_overdraft_against_commercial_paper_id,0,_company_id,current_date(),_limit,_current_interest_amount,'end_of_month',NOW());
								-- حساب ال highest debit balance
								set _current_interest_amount = _highest_debt_balance_rate / 100 * _largest_end_balance ; 
								insert into overdraft_against_commercial_paper_bank_statements (type,priority ,overdraft_against_commercial_paper_id,money_received_id,company_id,date,`limit`,credit,interest_type,full_date) values(highest_debit_balance_text,1,_overdraft_against_commercial_paper_id,0,_company_id,current_date(),_limit,_current_interest_amount,'end_of_month',NOW());
							set i = i +1 ; 
							UNTIL i >= @n  end repeat ;
					end if ;
					
				end //
				delimiter ; 
				DROP EVENT IF EXISTS `end_of_month_overdraft_against_commercial_paper_interests_event`;
				DELIMITER $$
				CREATE EVENT `end_of_month_overdraft_against_commercial_paper_interests_event`
				ON SCHEDULE EVERY  1 day
				STARTS '2022-03-31 23:59:00'
				ON COMPLETION PRESERVE
				DO BEGIN
				call end_of_month_overdraft_against_commercial_paper_interests();
				END$$
				DELIMITER ;
				