    <script>
                $(document).on('change', '[change-financial-instutition-js]', function() {
                    const parent = $(this).closest('.kt-portlet__body');
                    const accountType = $('.js-update-account-id-based-on-account-type').val()
                    const accountId = $('[js-cd-or-td-account-number]').val();
					if(!accountId){
						return ;
					}
                    let financialInstitutionId = $('#financial-instutition-id').val();
                    financialInstitutionId = financialInstitutionId ? financialInstitutionId : $('[name="financial_institution_id"]').val();
                    let url = "{{ route('update.balance.and.net.balance.based.on.account.id.ajax',['company'=>$company->id , 'accountType'=>'replace_account_type' , 'accountId'=>'replace_account_id','financialInstitutionId'=>'replace_financial_institution_id' ]) }}";
                    url = url.replace('replace_account_type', accountType);
                    url = url.replace('replace_account_id', accountId);
                    url = url.replace('replace_financial_institution_id', financialInstitutionId);

                    $.ajax({
                        url
                        , success: function(res) {

                            if (res.balance_date) {
                                $(parent).find('.balance-date-js').html('[ ' + res.balance_date + ' ]')
                            }
                            if (res.net_balance_date) {
                                $(parent).find('.net-balance-date-js').html('[ ' + res.net_balance_date + ' ]')
                            }
						
                            $(parent).find('.net-balance-js').val(number_format(res.net_balance))
                            $(parent).find('.balance-js').val(number_format(res.balance))
                        }
                    });
                })
				
				
				$(document).on('change', '[js-when-change-trigger-change-account-type]', function () {
					$('.js-update-account-number-based-on-account-type').trigger('change')
					})



	
            </script>
