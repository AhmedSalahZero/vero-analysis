$(document).on('click','#js-drawee-bank option',function(e){
	e.preventDefault();
	let value = $(this).attr('value');
	if(value == -1){
		$('#js-choose-bank-id').modal('show');
	}
})

$(document).on('click','#js-append-bank-name-if-not-exist',function(){
	const receivingBank = document.getElementById('js-drawee-bank');
	const newBankName = $('#js-bank-names').val();
	const isBankExist =  $(receivingBank).find('option[value="'+newBankName+'"]').length ;
	if(!isBankExist){
		const option = '<option selected value="'+newBankName+'">'+newBankName+'</option>'
		$('#js-drawee-bank').append(option);
	}
	$('#js-choose-bank-id').modal('hide');
});




$(document).on('click','#js-receiving-bank option',function(e){
	e.preventDefault();
	let value = $(this).attr('value');
	if(value == -1){
		$('#js-choose-receiving-bank-id').modal('show');
	}
})

$(document).on('click','#js-append-receiving-bank-name-if-not-exist',function(){
	const receivingBank = document.getElementById('js-receiving-bank');
	const newBankName = $('#js-receiving-bank-names').val();
	const isBankExist =  $(receivingBank).find('option[value="'+newBankName+'"]').length ;
	if(!isBankExist){
		const option = '<option selected value="'+newBankName+'">'+newBankName+'</option>'
		$('#js-receiving-bank').append(option);
	}
	$('#js-choose-receiving-bank-id').modal('hide');
});






$(document).on('click','#js-receiving-branch option',function(e){
	e.preventDefault();
	let value = $(this).attr('value');
	if(value == -1){
		$('#js-choose-receiving-branch-id').modal('show');
	}
})

$(document).on('click','#js-append-receiving-branch-name-if-not-exist',function(){
	const receivingBranch = document.getElementById('js-receiving-branch');
	const newBranchName = $('#js-receiving-branch-names').val();
	const isBranchExist =  $(receivingBranch).find('option[value="'+newBranchName+'"]').length ;
	if(!isBranchExist){
		const option = '<option selected value="'+newBranchName+'">'+newBranchName+'</option>'
		$('#js-receiving-branch').append(option);
	}
	$('#js-choose-receiving-branch-id').modal('hide');
});






$(document).on('change','#ajax-get-invoice-numbers',function(){
	const customerId = $(this).val();
	const companyId = $('body').attr('data-current-company-id');
	const lang = $('body').attr('data-lang');
	const url = '/'+lang+'/'+companyId+'/money-received/get-invoice-numbers/'+customerId;
	if(customerId){
		$.ajax({
			url:url,
		}).then(function(res){
			var lastNode = $('.js-duplicate-node:last-of-type').clone(true);
			$('.js-append-to').empty();
		
			for(var i = 0  ; i < res.invoices.length ; i++){
				var invoiceNumber = res.invoices[i].invoice_number;
				var netInvoiceAmount = res.invoices[i].net_invoice_amount;
				var invoiceDate = res.invoices[i].invoice_date;
				$(lastNode).find('.js-invoice-number').val(invoiceNumber)
				$(lastNode).find('.js-invoice-date').val(invoiceDate)
				$(lastNode).find('.js-net-invoice-amount').val(number_format(netInvoiceAmount,2))
				$('.js-append-to').append(lastNode);
				lastNode = $('.js-duplicate-node:last-of-type').clone(true);
			}
			
		});
	}
})
$('#ajax-get-invoice-numbers').trigger('change');
