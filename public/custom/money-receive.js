$(document).on('click', '#js-drawee-bank', function (e) {
	e.preventDefault()
	$('#js-choose-bank-id').modal('show')
})

$(document).on('click', '#js-append-bank-name-if-not-exist', function () {
	const receivingBank = document.getElementById('js-drawee-bank').parentElement
	const newBankId = $('#js-bank-names').val()
	const newBankName = $('#js-bank-names option:selected').attr('data-name')
	const isBankExist = $(receivingBank).find('option[value="' + newBankId + '"]').length
	if (!isBankExist) {
		const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
		$('#js-drawee-bank').parent().find('select').append(option)
	}
	$('#js-choose-bank-id').modal('hide')
})




$(document).on('click', '#js-receiving-bank', function (e) {
	e.preventDefault()
	$('#js-choose-receiving-bank-id').modal('show')
})

$(document).on('click', '#js-append-receiving-bank-name-if-not-exist', function () {
	const receivingBank = document.getElementById('js-receiving-bank').parentElement
	const newBankId = $('#js-receiving-bank-names').val()
	const newBankName = $('#js-receiving-bank-names').find('option:selected').attr('data-name')
	const isBankExist = $(receivingBank).parent().find('select').find('option[value="' + newBankId + '"]').length
	if (!isBankExist) {
		const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
		$('#js-receiving-bank').parent().find('select').append(option)
	}
	$('#js-choose-receiving-bank-id').modal('hide')
})






$(document).on('click', '#js-receiving-branch', function (e) {
	e.preventDefault()
	$('#js-choose-receiving-branch-id').modal('show')

})

$(document).on('click', '#js-append-receiving-branch-name-if-not-exist', function () {
	const receivingBranch = document.getElementById('js-receiving-branch').parentElement
	const newBranchName = $('#js-receiving-branch-names').val()
	const isBranchExist = $(receivingBranch).parent().find('select').find('option[value="' + newBranchName + '"]').length
	if (!isBranchExist) {
		const option = '<option selected value="' + newBranchName + '">' + newBranchName + '</option>'
		$('#js-receiving-branch').parent().find('select').append(option)
	}
	$('#js-choose-receiving-branch-id').modal('hide')
})






$(document).on('change', '.ajax-get-invoice-numbers', function () {
	const inEditMode = +$('#js-in-edit-mode').val()
	let onlyOneInvoiceNumber = +$('#ajax-invoice-item').attr('data-single-model')
	let specificInvoiceNumber = $('#ajax-invoice-item').val()
	const moneyReceivedId = +$('#js-money-received-id').val()
	const customerInvoiceId = $('#customer_name').val()
	const currency = $('#js-currency-id').val()
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/money-received/get-invoice-numbers/' + customerInvoiceId+'/'+currency
	if (customerInvoiceId ) {
		$.ajax({
			url,
			data: {
				inEditMode
				, money_received_id: moneyReceivedId
			}
		}).then(function (res) {
			// first append currencies 
			let currenciesOptions = '';
			var selectedCurrency = res.selectedCurrency ;
			for(var currencyName in res.currencies){
				
				var currencyFormattedName = res.currencies[currencyName]
				currenciesOptions+= `<option ${currencyName == selectedCurrency ? 'selected' : ''} value="${currencyName}">${currencyFormattedName}</option>`;
			}
			
			
			$('#js-currency-id').empty().append(currenciesOptions);
			// second add settlements repeater 
			var lastNode = $('.js-duplicate-node:last-of-type').clone(true);
			$('.js-append-to').empty()
			for (var i = 0; i < res.invoices.length; i++) {
				var invoiceNumber = res.invoices[i].invoice_number
				var currency = res.invoices[i].currency
				var netInvoiceAmount = res.invoices[i].net_invoice_amount
				var netBalance = res.invoices[i].net_balance
				var collectedAmount = res.invoices[i].collected_amount
				var invoiceDate = res.invoices[i].invoice_date
				var settlementAmount = res.invoices[i].settlement_amount
				var withholdAmount = res.invoices[i].withhold_amount
				var domInvoiceNumber = $(lastNode).find('.js-invoice-number')
				domInvoiceNumber.val(invoiceNumber)
				domInvoiceNumber.attr('name', 'settlements[' + invoiceNumber + '][invoice_number]')
				if (!onlyOneInvoiceNumber || (onlyOneInvoiceNumber && invoiceNumber == specificInvoiceNumber)) {
					$(lastNode).find('.js-invoice-date').val(invoiceDate)
					$(lastNode).find('.js-net-invoice-amount').val(number_format(netInvoiceAmount, 2))
					$(lastNode).find('.js-currency').val(currency)
					$(lastNode).find('.js-net-balance').val(number_format(netBalance, 2))
					$(lastNode).find('.js-collected-amount').val(number_format(collectedAmount, 2))

					var domSettlementAmount = $(lastNode).find('.js-settlement-amount')
					var domWithholdAmount = $(lastNode).find('.js-withhold-amount')
					domSettlementAmount.val(settlementAmount)
					domWithholdAmount.val(withholdAmount)
					domSettlementAmount.attr('name', 'settlements[' + invoiceNumber + '][settlement_amount]')
					domWithholdAmount.attr('name', 'settlements[' + invoiceNumber + '][withhold_amount]')
					$('.js-append-to').append(lastNode)
					lastNode = $('.js-duplicate-node:last-of-type').clone(true)
				}

			}
			$('.js-append-to').find('.js-settlement-amount:first-of-type').trigger('change')

		})
	}
})
$('.ajax-get-invoice-numbers').trigger('change')
$(document).on('change', '.js-settlement-amount,[data-max-cheque-value]', function () {
	let total = 0
	$('.js-settlement-amount').each(function (index, input) {
		total += parseFloat($(input).val())
	})
	const currentType = $('#money_type').val()
	const receivedAmount = $('.js-' + currentType + '-received-amount').val()
	let totalRemaining = receivedAmount - total
	totalRemaining = totalRemaining ? totalRemaining : 0 ;
	$('#remaining-settlement-js').val(totalRemaining);
	
})
$('.js-send-to-collection').on('change', function () {
	const noCheckedItems = $('.js-send-to-collection:checked').length
	const sendToCollectionTrigger = $('#js-send-to-under-collection-trigger')
	if (noCheckedItems) {
		sendToCollectionTrigger.attr('title', '').removeClass('disabled')
	}
	else {
		sendToCollectionTrigger.attr('title', 'Please Select More Than One Cheque').addClass('disabled')
	}

})
$(function () {
	setTimeout(function () {
		$('.js-send-to-collection').trigger('change')
	}, 1000)
})