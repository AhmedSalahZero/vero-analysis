

$(document).on('click', '#js-delivery-bank', function (e) {
	e.preventDefault()
	$('#js-choose-bank-id').modal('show')
})
$(document).on('click', '.js-delivery-bank-class', function (e) {
	e.preventDefault()
	$('#js-choose-bank-id').modal('show')
})
$(document).on('click', '#js-append-bank-name-if-not-exist', function () {
	const deliveryBank = document.getElementById('js-delivery-bank').parentElement
	const newBankId = $('#js-bank-names').val()
	const newBankName = $('#js-bank-names option:selected').attr('data-name')
	const isBankExist = $(deliveryBank).find('option[value="' + newBankId + '"]').length

	if (!isBankExist) {
		const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'

		$('#js-delivery-bank').parent().find('select').append(option)
	}
	$('#js-choose-bank-id').modal('hide')
})


$(document).on('click', '.js-append-bank-name-if-not-exist-in-repeater', function () {
	const newBankId = $('#js-bank-names').val()
	const newBankName = $('#js-bank-names option:selected').attr('data-name')
	$('select.delivery-bank-class').each(function (index, selectElement) {
		const isBankExist = $(selectElement).find('option[value="' + newBankId + '"]').length
		if (!isBankExist) {
			const option = '<option  value="' + newBankId + '">' + newBankName + '</option>'
			$(selectElement).append(option).selectpicker("refresh")
		}
	})


	$('#js-choose-bank-id').modal('hide')
})

$(document).on('click', '#js-delivery-bank', function (e) {
	e.preventDefault()
	$('#js-choose-delivery-bank-id').modal('show')
})

$(document).on('click', '#js-append-delivery-bank-name-if-not-exist', function () {
	const deliveryBank = document.getElementById('js-delivery-bank').parentElement
	const newBankId = $('#js-delivery-bank-names').val()
	const newBankName = $('#js-delivery-bank-names').find('option:selected').attr('data-name')
	const isBankExist = $(deliveryBank).parent().find('select').find('option[value="' + newBankId + '"]').length
	if (!isBankExist) {
		const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
		$('#js-delivery-bank').parent().find('select').append(option)
	}
	$('#js-choose-delivery-bank-id').modal('hide')
})






$(document).on('click', '#js-delivery-branch', function (e) {
	e.preventDefault()
	$('#js-choose-delivery-branch-id').modal('show')

})

$(document).on('click', '#js-append-delivery-branch-name-if-not-exist', function () {
	const deliveryBranch = document.getElementById('js-delivery-branch').parentElement
	const newBranchName = $('#js-delivery-branch-names').val()
	const isBranchExist = $(deliveryBranch).parent().find('select').find('option[value="' + newBranchName + '"]').length
	if (!isBranchExist) {
		const option = '<option selected value="' + newBranchName + '">' + newBranchName + '</option>'
		$('#js-delivery-branch').parent().find('select').append(option)
	}
	$('#js-choose-delivery-branch-id').modal('hide')
})




$(document).on('change', '.ajax-get-purchases-orders-for-contract', function () {
	let inEditMode = +$('#js-in-edit-mode').val()
	inEditMode = inEditMode ? inEditMode : 0
	let onlyOneSalesOrder = +$('#ajax-purchases-order-item').attr('data-single-model')
	let specificSalesOrder = $('#ajax-purchases-order-item').val()
	const downPaymentId = +$('#js-down-payment-id').val()
	let contractId = $('#contract-id').val()
	contractId = contractId ? contractId : $(this).closest('[data-repeater-item]').find('select.supplier-name-js').val()
	let currency = $('.current-currency').val()
	currency = currency ? currency : $(this).closest('[data-repeater-item]').find('select.current-currency').val()
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/down-payments/get-purchases-orders-for-contract/' + contractId + '/' + currency
	console.log(contractId)
	if (contractId) {
		$.ajax({
			url,
			data: {
				inEditMode
				, down_payment_id: downPaymentId
			}
		}).then(function (res) {
			// first append currencies 
		//	let currenciesOptions = ''
		//	var selectedCurrency = res.selectedCurrency
		//	for (var currencyName in res.currencies) {
		//		var currencyFormattedName = res.currencies[currencyName].toUpperCase()
		//		currenciesOptions += `<option ${currencyName == selectedCurrency ? 'selected' : ''} value="${currencyName}">${currencyFormattedName}</option>`
		//	}
//
		//	$('.current-currency').empty().append(currenciesOptions)
			// second add settlements repeater 
			var lastNode = $('.js-duplicate-node:last-of-type').clone(true)
			$('.js-append-to').empty()
		
			for (var i = 0; i < res.purchases_orders.length; i++) {
				 var salesOrderId = res.purchases_orders[i].id
				// var currency = res.invoices[i].currency
				var amount = res.purchases_orders[i].amount
			//	var netBalance = res.invoices[i].net_balance
			//	var paidAmount = res.invoices[i].paid_amount
			//	var invoiceDate = res.invoices[i].invoice_date
				var paidAmount = res.purchases_orders[i].paid_amount
			//	var withholdAmount = res.invoices[i].withhold_amount
				var domSalesOrder = $(lastNode).find('.js-purchases-order-number')
				domSalesOrder.val(salesOrderId)
				domSalesOrder.attr('name', 'purchases_orders_amounts[' + salesOrderId + '][purchases_order_id]').val(salesOrderId)
				if (!onlyOneSalesOrder || (onlyOneSalesOrder && salesOrderId == specificSalesOrder)) {
				//	$(lastNode).find('.js-invoice-date').val(invoiceDate)
					$(lastNode).find('.js-amount').val(number_format(amount, 2))
					//$(lastNode).find('.js-currency').val(currency)
					//$(lastNode).find('.js-net-balance').val(number_format(netBalance, 2))
					//$(lastNode).find('.js-paid-amount').val(number_format(paidAmount, 2))

					var domPaidAmount = $(lastNode).find('.js-paid-amount')
			//		var domWithholdAmount = $(lastNode).find('.js-withhold-amount')
					domPaidAmount.val(paidAmount)
					// domWithholdAmount.val(withholdAmount)
					domPaidAmount.attr('name', 'purchases_orders_amounts[' + salesOrderId + '][paid_amount]')
					//domWithholdAmount.attr('name', 'purchases_orders_amounts[' + invoiceNumber + '][withhold_amount]')
					$('.js-append-to').append(lastNode)
					lastNode = $('.js-duplicate-node:last-of-type').clone(true)
					
				}

			}
			if(res.purchases_orders.length == 0){
				$('.js-append-to').append(lastNode)
			}
		//	$('.js-append-to').find('.js-settlement-amount:first-of-type').trigger('change')

		})
	}
})

$(document).on('change', 'select.ajax-get-invoice-numbers', function () {
	let inEditMode = +$('#js-in-edit-mode').val()
	inEditMode = inEditMode ? inEditMode : 0
	let onlyOneInvoiceNumber = +$('#ajax-invoice-item').attr('data-single-model')
	let specificInvoiceNumber = $('#ajax-invoice-item').val()
	const moneyPaymentId = +$('#js-money-payment-id').val()
	let supplierInvoiceId = $('#supplier_name').val()
	supplierInvoiceId = supplierInvoiceId ? supplierInvoiceId : $(this).closest('[data-repeater-item]').find('select.supplier-name-js').val()
	let currency = $('.current-currency').val()
	currency = currency ? currency : $(this).closest('[data-repeater-item]').find('select.current-currency').val()
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/money-payment/get-invoice-numbers/' + supplierInvoiceId + '/' + currency

	if (supplierInvoiceId) {
		$.ajax({
			url,
			data: {
				inEditMode
				, money_payment_id: moneyPaymentId
			}
		}).then(function (res) {
			// first append currencies 
			let currenciesOptions = ''
			var selectedCurrency = res.selectedCurrency
			for (var currencyName in res.currencies) {
				var currencyFormattedName = res.currencies[currencyName].toUpperCase()
				currenciesOptions += `<option ${currencyName == currency ? 'selected' : ''} value="${currencyName}">${currencyFormattedName}</option>`
			}


			// $('.current-currency').empty().append(currenciesOptions)
			// second add settlements repeater 
			var lastNode = $('.js-duplicate-node:last-of-type').clone(true)
			$('.js-append-to').empty()
			for (var i = 0; i < res.invoices.length; i++) {
				var invoiceNumber = res.invoices[i].invoice_number
				var currency = res.invoices[i].currency
				var netInvoiceAmount = res.invoices[i].net_invoice_amount
				var netBalance = res.invoices[i].net_balance
				var paidAmount = res.invoices[i].paid_amount
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
					$(lastNode).find('.js-paid-amount').val(number_format(paidAmount, 2))

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
$('select.ajax-get-invoice-numbers').trigger('change')
$('select.ajax-get-purchases-orders-for-contract').trigger('change')
$(document).on('change', '.js-settlement-amount,[data-max-cheque-value]', function () {
	let total = 0
	$('.js-settlement-amount').each(function (index, input) {
		total += parseFloat($(input).val())
	})
	const currentType = $('#type').val()
	const paidAmount = $('.js-' + currentType + '-paid-amount').val()
	let totalRemaining = paidAmount - total
	totalRemaining = totalRemaining ? totalRemaining : 0
	$('#remaining-settlement-js').val(totalRemaining)

})
$('.js-send-to-collection').on('change', function () {
	const noCheckedItems = $('.js-send-to-collection:checked').length
	const moneyType = $(this).attr('data-money-type')
	const sendToCollectionTrigger = $('#js-send-to-under-collection-trigger' + moneyType)
	if (noCheckedItems) {
		sendToCollectionTrigger.attr('title', '').removeClass('disabled')
	}
	else {
		sendToCollectionTrigger.attr('title', 'Please Select More Than One Cheque').addClass('disabled')
	}

})

$(document).on('change', '.js-update-account-number-based-on-account-type', function () {
	const val = $(this).val()
	const lang = $('body').attr('data-lang')
	const companyId = $('body').attr('data-current-company-id')
	const repeaterParentIfExists = $(this).closest('[data-repeater-item]')
	const parent = repeaterParentIfExists.length ? repeaterParentIfExists : $(this).closest('.kt-portlet__body')
	const moneyType = $(this).closest('form').attr('data-money-type')
	const data = []
	let currency = $(this).closest('form').find('.current-currency').val()
	currency = currency ? currency : $('.js-send-to-collection[data-money-type="' + moneyType + '"]').closest('tr').find('[data-currency]').attr('data-currency')
	let financialInstitutionBankId = parent.find('[data-financial-institution-id]').val()

	financialInstitutionBankId = typeof financialInstitutionBankId !== 'undefined' ? financialInstitutionBankId : $('[data-financial-institution-id]').val()
	if (!val || !currency || !financialInstitutionBankId) {
		return
	}
	const url = '/' + lang + '/' + companyId + '/money-payment/get-account-numbers-based-on-account-type/' + val + '/' + currency + '/' + financialInstitutionBankId
	$.ajax({
		url,
		data,
		success: function (res) {
			options = ''
			var selectToAppendInto = $(parent).find('.js-account-number')

			for (key in res.data) {
				var val = res.data[key]
				var selected = $(selectToAppendInto).attr('data-current-selected') == val ? 'selected' : ''
				options += '<option ' + selected + '  value="' + val + '">' + val + '</option>'
			}

			selectToAppendInto.empty().append(options)
		}
	})






})
$(document).on('change', '[js-when-change-trigger-change-account-type]', function () {
	$(this).closest('.kt-portlet__body').find('.js-update-account-number-based-on-account-type').trigger('change')
})
$(function () {
	$('.js-update-account-number-based-on-account-type').trigger('change')
	setTimeout(function () {
		$('.js-send-to-collection').trigger('change')
	}, 1000)
})
