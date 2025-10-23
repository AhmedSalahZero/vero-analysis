$(document).on('click', '.repeat-to-right', function () {
	// console.log('from 1')
	let columnIndex = parseInt($(this).attr('data-column-index'))
	let parent = $(this).closest('tr')
	let name = $(this).attr('data-name')
	let numberFormatDecimalsForCurrentRow = parent.attr('data-repeat-formatting-decimals')
	numberFormatDecimalsForCurrentRow = numberFormatDecimalsForCurrentRow ? numberFormatDecimalsForCurrentRow : 0
	let input = parent.find('.repeat-to-right-input-formatted[data-column-index="' + columnIndex + '"][data-name="' + name + '"]')
	let numberOfDecimalsForCurrentInput = $(input).attr('data-number-of-decimals')
	numberOfDecimalsForCurrentInput = numberOfDecimalsForCurrentInput == undefined ? numberFormatDecimalsForCurrentRow : numberOfDecimalsForCurrentInput
	let inputValue = input.val()
	inputValue = number_unformat(inputValue)
	let totalPerYear = 0
	$(this).closest('tr').find('.repeat-to-right-input-formatted[data-name="' + name + '"]').each(function (index, inputFormatted) {
		let currentColumnIndex = $(inputFormatted).attr('data-column-index')
		if (currentColumnIndex >= columnIndex) {
			totalPerYear += parseFloat(inputValue)
			$(inputFormatted).val(number_format(inputValue, numberOfDecimalsForCurrentInput)).trigger('change')
		}
	})
})
$('.repeat-to-right-input-hidden').on('change', function () {
	// console.log('from 2')
	const val = $(this).val()
	const columnIndex = $(this).attr('data-column-index')
	const numberOfDecimals = $(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').attr('data-number-of-decimals')
	$(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').val(number_format(val, numberOfDecimals))
})
$(document).on('click', '.repeat-select-to-right', function () {
	// console.log('from 3')
	let columnIndex = parseInt($(this).attr('data-column-index'))
	let parent = $(this).closest('tr')
	let value = parent.find('.repeat-to-right-select[data-column-index="' + columnIndex + '"]').val()
	$(this).closest('tr').find('.repeat-to-right-select').each(function (index, select) {
		if ($(select).attr('data-column-index') >= columnIndex) {
			$(select).val(value).trigger('change')
		}
	})

})

$(document).on('change', '.input-hidden-parent .copy-value-to-his-input-hidden', function () {
	let val = $(this).val()
	$(this).closest('.input-hidden-parent').find('input.input-hidden-with-name').val(number_unformat(val)).trigger('change')
})


$(document).on('change', '.is-leasing', function () {
	// console.log('from 4')
	const isTotalOthers = $('#is-leasing-1').is(':checked')
	const parent = $(this).closest('.form-group.row')
	if (isTotalOthers) {
		parent.find('.total-leasing-div').css('display', 'initial').find('input,select').prop('disabled', false)
		parent.find('.leasing-repeater-parent').css('display', 'none').find('input,select').prop('disabled', true)
	} else {
		parent.find('.leasing-repeater-parent').css('display', 'initial').find('input,select').prop('disabled', false)
		parent.find('.total-leasing-div').css('display', 'none').find('input,select').prop('disabled', true)
	}
})
$(function () {
	$('.is-leasing:checked').trigger('change')
})


// $(document).on('change', 'select.revenue-stream-type-js', function () {
// 	// console.log('from 5')
// 	let revenueStreams = $(this).val()
// 	let studyId = $('#study-id-js').val()
// 	const that = this
// 	const companyId = $('body').attr('data-current-company-id')
// 	const lang = $('body').attr('data-lang')
// 	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-stream-category-based-on-revenue-stream'
// 	if (revenueStreams.length) {
// 		var streamCategoryElement = $(that).closest('tr').find('select.stream-category-class')
// 		var currentSelected = $(streamCategoryElement).attr('data-current-selected-items') ? JSON.parse($(streamCategoryElement).attr('data-current-selected-items')) : null
// 		$.ajax({
// 			url,
// 			data: {
// 				revenueStreams
// 			},
// 			method: "post",
// 			success: function (res) {
// 				var options = ''
// 				var selected = ''
// 				if (currentSelected ? currentSelected.includes('all') : false) {
// 					selected = 'selected'
// 				}
// 				options += `<option ${selected} value="all">All</option>`

// 				for (id in res.result) {
// 					var title = res.result[id]
// 					selected = ''
// 					if (currentSelected ? currentSelected.includes(id) : null) {
// 						selected = 'selected'
// 					}
// 					options += `<option ${selected} value="${id}">${title}</option>`
// 				}
// 				streamCategoryElement.empty().append(options).trigger('change')
// 			}
// 		})
// 	} else {

// 	}
// })

$(document).on('change', '[js-recalculate-equity-funding-value],.js-recalculate-equity-funding-value', function () {
	const parent  = $(this).closest('table');
	const columnIndex = parseInt($(this).attr('data-column-index'))
	let total = $(parent).find('.total-loans-hidden[data-column-index="' + columnIndex + '"]').val()
	if(total == undefined){
		total = $('.total-loans-hidden[data-column-index="' + columnIndex + '"]').val()
	}
	let equityFundingRate = $(parent).find('.equity-funding-rates[data-column-index="' + columnIndex + '"]').val()
	if(equityFundingRate == undefined){
		equityFundingRate = $('.equity-funding-rates[data-column-index="' + columnIndex + '"]').val();
	}
	let equityFundingValue = equityFundingRate / 100 * total
	let newLoanFundingValue = (1 - (equityFundingRate / 100)) * total
	console.log();
	if($(parent).find('input.equity-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').length){
		$(parent).find('input.equity-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(equityFundingValue)).trigger('change')
		$(parent).find('input.new-loans-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(newLoanFundingValue)).trigger('change')
	}else{
		$('input.equity-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(equityFundingValue)).trigger('change')
		$('input.new-loans-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(newLoanFundingValue)).trigger('change')
	}
	

})

// $(document).on('change', '[js-recalculate-equity-funding-value],.js-recalculate-equity-funding-value', function () {
// 	// console.log('from 7')
// 	const columnIndex = parseInt($(this).attr('data-column-index'))
// 	const total = $('.total-loans-hidden[data-column-index="' + columnIndex + '"]').val()
// 	const equityFundingRate = $('.equity-funding-rates[data-column-index="' + columnIndex + '"]').val()
// 	let equityFundingValue = equityFundingRate / 100 * total
// 	let newLoanFundingValue = (1 - (equityFundingRate / 100)) * total
// 	$('input.equity-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(equityFundingValue)).trigger('change')
// 	$('input.new-loans-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(newLoanFundingValue)).trigger('change')
// })

//$('[js-recalculate-equity-funding-value]').trigger('change')
function convertDateToDefaultDateFormat(dateStr) {
	const [month, day, year] = dateStr.split("/") // Split the string by "/";
	return `${year}-${month}-${day}` // Rearrange to YYYY-MM-DD
}
function getEndOfMonth(year, month) {
	// قم بإنشاء تاريخ لأول يوم من الشهر التالي
	let date = new Date(year, month + 1, 0)
	return date
}
$(document).on('change', '.recalculate-factoring', function () {
	const index = parseInt($(this).attr('data-column-index'))
	var value = $('.factoring-projection-amount[data-column-index="' + index + '"]').val()
	$('.factoring-rate[data-column-index="' + index + '"]').each(function (currentIndex, rateElement) {
		var rate = $(rateElement).val()
		var numberOfDecimals = $(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').closest('.input-hidden-parent').find('.repeat-to-right-input-formatted').attr('data-number-of-decimals')
		$(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').closest('.input-hidden-parent').find('.repeat-to-right-input-formatted').val(number_format(rate / 100 * value, numberOfDecimals))
		$(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').val(rate / 100 * value).trigger('change')
	})

})

$(function () {

	$('select.revenue-stream-type-js').trigger('change')
})
$(document).on('change', 'select.js-update-positions-for-department', function () {
	// console.log('from 9')
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const departmentId = $(this).val()
	const currentPositionIds = $(this).attr('data-current-selected')
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-positions-based-on-department'

	$.ajax({
		url,
		data: {
			departmentId
		},
		type: "get",
		success: (res) => {
			let positions = ''
			for (let id in res.positions) {
				positions += `<option value="${id}" ${currentPositionIds.includes(id) ? 'selected' : ''} >${res.positions[id]}</option>`
			}
			$(this).closest('tr').find('select.position-class').empty().append(positions).trigger('change')
		}

	})
})
$('select.js-update-positions-for-department').trigger('change')

$(document).on('change', '.is-percentage-from-total,.is-percentage-total-of', function () {
	// console.log('from 10')
	let commonClass = $(this).attr('data-common-percentage-of-class')
	let columnIndex = $(this).attr('data-column-index')


	let totalOfAmount = $('.is-percentage-total-of[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').val()
	let currentRow = $(this).closest('tr')
	let tableRows = $(this).closest('table').find('tbody tr')
	let rowIndex = $(tableRows).index(currentRow)
	let percentage = $('.is-percentage-from-total[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').eq(rowIndex).val()
	let result = percentage / 100 * totalOfAmount
	let resultRow = $('.is-result-total-of[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').eq(rowIndex)
	let numberOfDecimals = resultRow.closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').attr('data-number-of-decimals')
	resultRow.closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').val(number_format(result, numberOfDecimals)).val(result)
	resultRow.val(result)
})


$(document).on('click', '.collapse-before-me', function () {
	// console.log('from 11')
	let columnIndex = $(this).attr('data-column-index')
	hide = true
	let counter = 0
	while (hide) {
		if (counter != 0) {

			if ($(this).closest('table').find('th[data-column-index="' + columnIndex + '"]').hasClass('exclude-from-collapse')) {
				hide = false
				return
			}
		}

		$(this).closest('table').find('[data-column-index="' + columnIndex + '"]:not(.exclude-from-collapse):not(.total-td):not(.total-td-formatted)').toggle()

		columnIndex--
		counter++
		if (counter == 12) {
			hide = false
		}
	}
})
$(document).on('change', '.repeater-with-collapse-input', function () {
	// console.log('from 12')
	let groupIndex = $(this).attr('data-group-index')
	let total = 0
	$(this).closest('tr').find('input[data-group-index="' + groupIndex + '"]').each(function (index, element) {
		total += parseFloat($(element).val())
	})
	$(this).closest('tr').find('.year-repeater-index-' + groupIndex).val(number_format(total)).trigger('change')
})
$('input[type="hidden"].exclude-from-collapse').on('change', function () {
	var total = 0
	$(this).closest('tr').find('.repeat-group-year').each(function (index, element) {
		total += parseFloat(number_unformat($(element).val()))
	})
	$(this).closest('tr').find('.total-td').val(number_format(total)).trigger('change')
})
$(document).on('click', '.add-btn-js', function (e) {
	// console.log('from 13')
	e.preventDefault()
	$(this).toggleClass('rotate-180')
	$(this).closest('[data-is-main-row]').nextUntil('[data-is-main-row]').toggleClass('hidden')
})
$(document).on('change', '.recalculate-gr', function () {
	// console.log('from 14')
	const columnIndex = parseInt($(this).attr('data-column-index'))
	const previousColumnIndex = columnIndex - 1
	const nextColumnIndex = columnIndex + 1
	const growthRateOfCurrentYear = $('.gr-field[data-column-index="' + columnIndex + '"]').val()



	allElements = $('.current-growth-rate-result-value-formatted[data-column-index="' + columnIndex + '"]')
	allElements.each(function (index, element) {
		const loanAmount = $(element).closest('tr').find('.current-growth-rate-result-value[data-column-index="' + previousColumnIndex + '"]').val()
		if (loanAmount != undefined) {
			currentAmount = (1 + (growthRateOfCurrentYear / 100)) * loanAmount
			$(element).val(number_format(currentAmount)).trigger('change')
		}

	})
	$('.recalculate-gr[data-column-index="' + nextColumnIndex + '"]').trigger('change')
})
$(document).on('change', '.current-growth-rate-result-value-formatted', function (event) {
	// console.log('from 15')
	const columnIndex = parseInt($(this).attr('data-column-index'))
	const nextColumnIndex = columnIndex + 1
	const previousColumnIndex = columnIndex - 1
	if (event.originalEvent && event.originalEvent.isTrusted) {
		// console.log('if---------')
		let previousValue = $(this).closest('tr').find('.current-growth-rate-result-value[data-column-index="' + previousColumnIndex + '"]').val()
		if (previousValue !== undefined) {

			let currentValue = number_unformat($(this).val())
			let currentGrowthRate = Math.round(((currentValue - previousValue) / previousValue) * 100, 2)
			$(this).closest('table').find('.gr-field[data-column-index="' + columnIndex + '"]').val(currentGrowthRate).trigger('change')
		} else {
			$(this).closest('table').find('.gr-field[data-column-index="' + nextColumnIndex + '"]').trigger('change')

		}
		//	// console.log(previousValue ,currentValue ,'--' )

		// $('.recalculate-gr[data-column-index="' + nextColumnIndex + '"]').trigger('change')
	} else {
		// console.log('else---------')
		// console.log("Input was changed programmatically.")

	}
	//$('.recalculate-gr[data-column-index="'+nextColumnIndex+'"]').trigger('change');
})
$(document).on('click', '#enable-editing-btn', function (e) {
	// console.log('from 16')
	e.preventDefault()
	var isEnableEditing = +$(this).attr('data-is-enable-editing')
	if (isEnableEditing) {
		// console.log('if')
		var disableText = $(this).attr('data-disable-edit-text')
		$(this).attr('data-is-enable-editing', 0)
		$(this).closest('form').find('input').prop('disabled', false)
		$(this).closest('form').find('[data-repeater-create]').show()
		$(this).closest('form').find('[data-repeater-delete]').show()
		$(this).closest('form').find('select').prop('disabled', false).selectpicker('refresh')
		$(this).html(disableText)
		$('#leasing-loans').hide()
	} else {
		// console.log('else')
		$(this).closest('form').find('input').prop('disabled', true)
		$(this).closest('form').find('[data-repeater-create]').hide()
		$(this).closest('form').find('[data-repeater-delete]').hide()
		$(this).closest('form').find('select').prop('disabled', true).selectpicker('refresh')

		var enableText = $(this).attr('data-enable-edit-text')
		$(this).attr('data-is-enable-editing', 1)
		// console.log(enableText)
		// console.log(enableText)
		$('#leasing-loans').show()
		$(this).html(enableText)
	}

})
$('#enable-editing-btn').trigger('click')
// $(document).on('change', '.is-fully-funded-checkbox', function () {
// 		// console.log('from 17')
// 	const value = parseInt($(this).val())
// 	//	const canViewFundingStructure = parseInt($('#toggleEditBtn').attr('can-show-funding-structure'));
// 	const canViewFundingStructure = 1


// 	$('#ffe-funding').hide()
// 	if (value) {
// 		$('#ffe-funding').hide()
// 		$('#toggleEditBtn').hide()
// 		$('#save-and-go-to-next').show()

// 	} else {
// 		if (canViewFundingStructure) {
// 			$('#ffe-funding').show()
// 		}
// 		$('#save-and-go-to-next').hide()
// 		$('#toggleEditBtn').show()


// 	}
// 	if (canViewFundingStructure) {
// 		$('#save-and-go-to-next').show()
// 	}

// })
// $('.is-fully-funded-checkbox:checked').trigger('change')
$(document).on('change', '.recalculate-monthly-increase-amounts', function () {
	// console.log('from 18')
	var currentRow = $(this).closest('tr')
	var itemCost = currentRow.find('.ffe-item-cost').val()
	// var vat = currentRow.find('dd');
	var costAnnuallyIncreaseRate = currentRow.find('.cost-annually-increase-rate').val() / 100
	var contingencyRate = currentRow.find('.contingency-rate').val() / 100

	var yearIndex = -1;;
	currentRow.find('.ffe_counts').each(function (index, ffeCountElement) {
		var currentYearIndex = parseInt($(ffeCountElement).attr('data-current-year-index'))
		var currentMonthIndex = $(ffeCountElement).attr('data-column-index')
		if (currentYearIndex != yearIndex) {
			yearIndex++
		}
		var currentCount = $(ffeCountElement).val()
		var currentTotalAmount = itemCost * currentCount * (1 + contingencyRate)
		var currentTotalAmountIncrease = currentTotalAmount * Math.pow(1 + costAnnuallyIncreaseRate, yearIndex)

		$(ffeCountElement).closest('td').find('.current-month-amounts').val(currentTotalAmountIncrease)
		var totalForCurrentMonth = 0
		$('.current-month-amounts[data-column-index="' + currentMonthIndex + '"]').each(function (index, amountElement) {
			totalForCurrentMonth += parseFloat($(amountElement).val())
		})
		$('.direct-ffe-amounts[data-column-index="' + currentMonthIndex + '"]').val(number_format(totalForCurrentMonth)).trigger('change')

	})

})
let calculateBranchIncreaseAmounts = function () {
	// console.log('from 19')
	var currentRow = $(this).closest('tr')
	var itemCost = parseFloat(currentRow.find('.ffe-item-cost').val())
	itemCost = itemCost ? itemCost : 0
	var costAnnuallyIncreaseRate = currentRow.find('.cost-annually-increase-rate').val() / 100
	costAnnuallyIncreaseRate = costAnnuallyIncreaseRate ? costAnnuallyIncreaseRate : 0
	var contingencyRate = currentRow.find('.contingency-rate').val() / 100
	contingencyRate = contingencyRate ? contingencyRate : 0
	var currentItemCount = parseInt(currentRow.find('.current-count').val())
	currentItemCount = currentItemCount ? currentItemCount : 0
	var yearIndex = -1 // will increase every year ;
	var netBranchOpeningProjections = JSON.parse($('#net-branch-opening-projections').val())
	var counts = {}
	for (var currentDateAsIndex in netBranchOpeningProjections) {
		var currentBranchCount = netBranchOpeningProjections[currentDateAsIndex]
		currentCount = currentBranchCount * currentItemCount
		var currentYearIndex = $('.year-index-month-index[data-month-index="' + currentDateAsIndex + '"]').attr('data-year-index')
		var currentMonthIndex = currentDateAsIndex
		if (currentYearIndex != yearIndex) {
			yearIndex++
		}
		counts[currentMonthIndex] = currentCount
		var currentTotalAmount = itemCost * currentCount * (1 + contingencyRate)
		var currentTotalAmountIncrease = currentTotalAmount * Math.pow(1 + costAnnuallyIncreaseRate, yearIndex)
		$(currentRow).closest('tr').find('.current-month-amounts[data-column-index="' + currentMonthIndex + '"]').val(currentTotalAmountIncrease)
		var totalForCurrentMonth = 0
		$('.current-month-amounts[data-column-index="' + currentMonthIndex + '"]').each(function (index, amountElement) {
			var currentAmount = $(amountElement).val()
			currentAmount = currentAmount == undefined ? 0 : currentAmount
			totalForCurrentMonth += parseFloat(currentAmount)

		})
		$('.direct-ffe-amounts[data-column-index="' + currentMonthIndex + '"]').val(number_format(totalForCurrentMonth)).trigger('change')

	}
	$(currentRow).find('.current-row-counts').val(JSON.stringify(counts))
}
$(document).on('change', '.recalculate-monthly-increase-amounts-branches', calculateBranchIncreaseAmounts)
$('.recalculate-monthly-increase-amounts-branches').trigger('change')
$(document).on('change', 'select.department-class', function () {
	// console.log('from 20')
	const departmentIds = $(this).val()
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-positions-based-on-departments'
	var data = {
		departmentIds
	}
	$.ajax({
		url,
		data,
		success: (res) => {
			var positionArr = res.positionIds
			var options = ''
			var positionRow = $(this).closest('tr').find('select.position-class')
			var currentSelected = $(positionRow).attr('data-current-selected-items')
			currentSelected = currentSelected ? JSON.parse(currentSelected) : ''
			for (var positionId in positionArr) {
				positionId = positionId
				var selected = currentSelected.includes(positionId)
				options += `<option ${selected ? 'selected' : ''} value="${positionId}">${positionArr[positionId]}</option>`
			}
			if (positionRow != '[]') {
				$(positionRow).empty().append(options).trigger('change')
			}
		}
	})

})
$(function () {
	$('select.department-class').trigger('change')
})


$(document).ready(function () {
	// Set table to readonly by default
	var inEditMode = parseInt($('#toggleEditBtn').attr('in-edit-mode'))
	var repeaterId = '#leasingRevenueStreamBreakdown_repeater'
	//	var repeaterId  = '#fixedAssets_repeater';
	if (inEditMode) {
		$(repeaterId).addClass('readonly')
		const table = $(repeaterId)
		table.find('input, select').prop('readonly', true)
	}
	// Toggle editability
	$('#toggleEditBtn').click(function (e) {
		e.preventDefault()
		const table = $(repeaterId)
		const isReadonly = table.hasClass('readonly')

		// // console.log('save form',saveForm);
		// console.log('from 21')
		if (isReadonly) {
			table.removeClass('readonly').addClass('editable')
			$(this).text('Disabled Editing')
			$(this).attr('can-show-funding-structure', 0)
			//	$(this).attr('is-save-and-continue',1);
			// Enable all inputs and selects

			table.find('input, select').prop('readonly', false)
			//table.find('.bootstrap-select').removeClass('disabled');

		} else {
			table.removeClass('editable').addClass('readonly')

			$(this).text('Enable Editing')
			//		$(this).attr('is-save-and-continue',0);
			$(this).attr('can-show-funding-structure', 1)
			// Disable all inputs and selects
			table.find('input,select').prop('readonly', true)

		}
		$('.is-fully-funded-checkbox:checked').trigger('change')
	})

	// Initially disable all inputs and selects
	// $('#fixedAssets_repeater').find('input, select').prop('readonly', true);
	// $('#fixedAssets_repeater').find('.bootstrap-select').addClass('readonly');
})

$(function () {
	//	$('#toggleEditBtn').click();
})
$(document).on('change', '[total-row-tr] input.input-hidden-with-name', function () {
	// console.log('from 22')
	let parent = $(this).closest('tr')
	let totalRow = parent.find('.sum-total-row')

	let numberOfDecimals = parent.attr('data-repeat-formatting-decimals')
	if (totalRow) {
		let total = 0
		parent.find('input.input-hidden-with-name:not(.exclude-from-total)').each(function (index, row) {
			var currentTotal = parseFloat(number_unformat($(row).val()))
			total += currentTotal
		})

		parent.find('input.sum-total-row').val(number_format(total, numberOfDecimals))
	}

})
$('[total-row-tr] input.input-hidden-with-name').trigger('change')





$(document).on('change', '.percentage_field,.number_field', function () {
	// console.log('from 23')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number = number_unformat($(parent).find('.number_field' + appendColumnIndex).val())
	const percentage = number_unformat($(parent).find('.percentage_field' + appendColumnIndex).val())
	const result = number * percentage / 100
	$(parent).find('.number_multiple_percentage' + appendColumnIndex).val(result).trigger('change')
})
$(document).on('change', '.percentage_field2,.number_field2', function () {
	// console.log('from 24')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number = number_unformat($(parent).find('.number_field2' + appendColumnIndex).val())
	const percentage = number_unformat($(parent).find('.percentage_field2' + appendColumnIndex).val())
	const result = number * percentage / 100
	$(parent).find('.number_multiple_percentage2' + appendColumnIndex).val(result).trigger('change')
})
$(document).on('change', '.percentage_field3,.number_field3', function () {
	// console.log('from 25')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number = number_unformat($(parent).find('.number_field3' + appendColumnIndex).val())
	const percentage = number_unformat($(parent).find('.percentage_field3' + appendColumnIndex).val())
	const result = number * percentage / 100
	$(parent).find('.number_multiple_percentage3' + appendColumnIndex).val(result).trigger('change')
})
$(document).on('change', '.number_field_1,.number_field_2', function () {
	// console.log('from 26')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendQuery = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number1 = number_unformat($(parent).find('.number_field_1' + appendQuery).val())
	const number2 = number_unformat($(parent).find('.number_field_2' + appendQuery).val())
	let result = number1 * number2
	const resultQuery = $(parent).find('.number_multiple_number' + appendQuery)
	const numberFormat = resultQuery.attr('data-number-format')
	if (numberFormat != undefined) {
		result = number_format(result, numberFormat)
	}
	resultQuery.val(result).trigger('change')
})


$(document).on('change', '.sum-num1,.sum-num2,.sum-num3', function () {
	// console.log('from 27')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendQuery = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number1 = parseFloat(number_unformat($(parent).find('.sum-num1' + appendQuery).val()))
	const number2 = parseFloat(number_unformat($(parent).find('.sum-num2' + appendQuery).val()))
	const number3 = parseFloat(number_unformat($(parent).find('.sum-num3' + appendQuery).val()))
	let result = number1 + number2 + number3
	const resultQuery = $(parent).find('.sum-three-column-result' + appendQuery)
	const numberFormat = resultQuery.attr('data-number-format')
	if (numberFormat != undefined) {
		result = number_format(result, numberFormat)
	}
	resultQuery.val(result).trigger('change')
})


$(document).on('change', '.number_minus_field_1,.number_minus_field_2', function () {
	// console.log('from 28')
	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendQuery = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number1 = number_unformat($(parent).find('.number_minus_field_1' + appendQuery).val())
	const number2 = number_unformat($(parent).find('.number_minus_field_2' + appendQuery).val())
	let result = number1 - number2
	const resultQuery = $(parent).find('.number_minus_number_result' + appendQuery)
	const numberFormat = resultQuery.attr('data-number-format')
	if (numberFormat != undefined) {
		result = number_format(result, numberFormat)
	}
	resultQuery.val(result).trigger('change')
})

$(document).on('change', '.growth_percentage', function (event) {
	// console.log('from 29')
	const parent = $(this).closest('.closest-parent')
	let percentage = $(parent).find('.growth_percentage').val()
	percentage = percentage ? percentage : 0
	const previousParent = $(parent).prev('.closest-parent')
	const previousAmount = number_unformat($(previousParent).find('.number_growth_amount').val())
	if (previousParent.length) {
		const result = previousAmount * (1 + (percentage / 100))
		$(parent).find('.number_growth_amount').val(result).trigger('change')
	}
})
$(document).on('change', '.number_growth_amount', function (event) {
	// console.log('from 30')
	const parent = $(this).closest('.closest-parent')
	$(parent).next('.closest-parent').find('.growth_percentage').trigger('change')
})


$(document).on('change', '.growth_percentage_in_diff_parent', function (event) {
	// console.log('from 31')
	$('.parent-for-salary-amount .number_growth_amount_in_diff_parent').each(function (index, input) {
		$(input).trigger('change')
	})

})


$(document).on('change', '.total_input', function () {
	// console.log('from 32')
	const parent = $(this).closest('.closest-parent')
	let total = 0
	$(parent).find('.total_input').each(function (index, input) {
		// console.log($(input).val() , input)
		total += parseFloat(number_unformat($(input).val()))
	})
	$(parent).find('.total_row_result').val(number_format(total, 2)).trigger('change')
})

document.addEventListener('DOMContentLoaded', function () {
	// console.log('from 33')
	// Select all elements with class target_last_value
	document.querySelectorAll('.target_last_value').forEach(icon => {
		icon.addEventListener('click', function () {
			// Find the closest form-group and the input within it
			const formGroup = this.closest('.form-group')
			const sourceInput = formGroup.querySelector('input')
			if (!sourceInput) return // Exit if no input found

			// Get the direction from data attribute
			const direction = this.getAttribute('data-repeating-direction')

			if (direction === 'column') {
				// Existing column logic
				const sourceName = sourceInput.name
				let suffix = sourceName.replace(/^[^_]+/, '')
				suffix = suffix.replace(/\[\d+\]/, '')
				const valueToCopy = sourceInput.value
				const currentRow = this.closest('.closest-parent')

				const allRows = Array.from(document.querySelectorAll('.closest-parent'))

				const currentRowIndex = allRows.indexOf(currentRow)

				allRows.slice(currentRowIndex + 1).forEach(row => {

					let targetInput = row.querySelector(`input[name*="${suffix}"]`)
					if (targetInput) {
						targetInput.value = valueToCopy
						targetInput.dispatchEvent(new Event('input', { bubbles: true }))
						targetInput.dispatchEvent(new Event('change', { bubbles: true }))
					}
				})
			}
		})
	})
})
$(document).ready(function () {
	// console.log('from 34')
	$('.target_last_value_to_right').on('click', function () {

		// Find the closest form-group and the input within it
		var formGroup = $(this).closest('.closest-parent')
		var sourceInput = formGroup.find('input')
		if (!sourceInput.length) return // Exit if no input found

		// Get the value to copy
		var valueToCopy = sourceInput.val()

		// Find the closest row (.closest-parent)
		var currentRow = $(this).closest('.closest-parent')
		// Find all inputs in the same row, excluding the source input
		var targetInputs = currentRow.find('input').not(sourceInput)
		// Copy the value to all other inputs in the row
		targetInputs.each(function () {
			$(this).val(valueToCopy)
			// Trigger input event to handle any dependent calculations
			$(this).trigger('input')
		})
	})
})
$(document).on('click', '.toggle-show-hide', function () {
	const query = $(this).attr('data-query')
	$(query).toggleClass('hidden')
})
$(document).ready(function () {
	// console.log('from 35')
	$('.target_last_value_to_right_until_end').on('click', function () {
		let parentDiv = $(this).closest('.parent-for-salary-amount')
		let currentElement = $(this).closest('.common-parent').find('.repeat-to-right-element')
		let currentInputValue = currentElement.val()
		let currentIndex = currentElement.attr('data-index')
		let subsequentDivs = parentDiv.find('.closest-parent .repeat-to-right-element')
		subsequentDivs.each(function (index, element) {
			if (index >= currentIndex) {
				$(element).val(currentInputValue)
			}
		})
	})
})





$(function () {
	// console.log('from 36')
	$('.is-leasing:checked').trigger('change')
})

$(document).on('change', '.sum_product_value_1,.sum_product_quantity_1,.sum_product_value_2,.sum_product_quantity_2', function () {
	// console.log('from 37')

	const parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendQuery = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	const number1 = number_unformat($(parent).find('.sum_product_value_1' + appendQuery).val())
	const number2 = number_unformat($(parent).find('.sum_product_quantity_1' + appendQuery).val())
	const number3 = number_unformat($(parent).find('.sum_product_value_2' + appendQuery).val())
	const number4 = number_unformat($(parent).find('.sum_product_quantity_2' + appendQuery).val())

	let result = (number1 * number2) + (number3 * number4)
	const resultQuery = $(parent).find('.two_sum_product_result' + appendQuery)
	const numberFormat = resultQuery.attr('data-number-format')
	if (numberFormat != undefined) {
		result = number_format(result, numberFormat)
	}
	resultQuery.val(result).trigger('change')

})


$(document).on('click', '.parent-checkbox', function () {
	// console.log('from 38')
	$(this).closest('.closest-parent').find('input[type="checkbox"]').prop('checked', false).trigger('change')
	$(this).closest('td').find('input[type="checkbox"]').prop('checked', true).trigger('change')

})
$(document).on('change', '.name-required-when-greater-than-zero-js', function () {
	// console.log('from 39')
	const value = $(this).val()
	const parent = $(this).closest('.closest-parent')
	if (value > 0) {
		$(parent).find('.name-field-js').prop('required', true)
	} else {
		$(parent).find('.name-field-js').prop('required', false)
	}
})
$(function () {
	$('.name-required-when-greater-than-zero-js').trigger('change')
})
$(function () {
	$('.delay-button').prop('disabled', false)
})
$(document).on('change', '.allocate-checkbox', function () {
	// console.log('from 38')
	const modal = $(this).closest('.modal')
	const isChecked = $(this).is(':checked')
	if (isChecked) {
		$(modal).find('.percentage-allocation').each(function (index, input) {
			$(input).val(0).prop('readonly', true).trigger('change')
		})
	} else {
		$(modal).find('.percentage-allocation').each(function (index, input) {
			var currentVal = $(input).attr('data-old-value')
			$(input).val(currentVal).prop('readonly', false).trigger('change')
		})
	}

})

$(document).on('change', '.fg-beginning-inventory-original-value-class', function () {
	// console.log('from 39')
	const value = number_unformat($(this).val())
	$('.fg-beginning-inventory-value-class').val(value).trigger('change')
})
function replaceRepeaterIndex(element) {

	$(element).closest('[data-repeater-list]').find('[data-last-index]').each(function (index, element) {
		var currentIndex = $(element).closest('[data-repeater-item]').index()
		var mainCategory = $(element).attr('data-main-category')
		var subCategory = $(element).attr('data-sub-category')
		var currentDate = $(element).attr('data-last-index')
		var newName = mainCategory + '[' + currentIndex + ']' + '[' + subCategory + ']' + '[' + currentDate + ']'
		$(element).attr('name', newName)
	})
}







// $(document).on('change', '[total-row-tr] input.input-hidden-with-name', function () {
// 		// console.log('from 40')
// 	let parent = $(this).closest('tr')
// 	let totalRow = parent.find('.sum-total-row')
// 	let numberOfDecimals = parent.attr('data-repeat-formatting-decimals')
// 	if (totalRow) {
// 		let total = 0
// 		parent.find('input.input-hidden-with-name').each(function (index, row) {
// 			var currentTotal = parseFloat(number_unformat($(row).val()))
// 			total += currentTotal
// 		})
// 		parent.find('input.sum-total-row').val(number_format(total, numberOfDecimals))
// 	}

// })
$(document).on('change', 'select.expense-category-class', function () {
	// console.log('from 41')
	const value = $(this).val()
	const hasAllocation = +$(this).find('option:selected').attr('data-has-allocation')
	const parent = $(this).closest('.common-parent')
	if (hasAllocation) {
		$(parent).find('.allocate-parent').show()
	} else {
		$(parent).find('.allocate-parent').hide()
	}
})

$(document).on('change', '.hundred-minus-number', function () {
	// console.log('from 42')
	let parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	let equityFundingPercentage = number_unformat($(parent).find('.hundred-minus-number' + appendColumnIndex).val())
	let debtFunding = 100 - equityFundingPercentage
	$(parent).find('.hundred-minus-number-result' + appendColumnIndex).val(number_format(debtFunding, 1)).trigger('change')
})

$(document).on('change', '.hundred-minus-number-one', function () {
	// console.log('from 43')
	let parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	let equityFundingPercentage = number_unformat($(parent).find('.hundred-minus-number-one' + appendColumnIndex).val())
	let debtFunding = 100 - equityFundingPercentage
	$(parent).find('.hundred-minus-number-result-one' + appendColumnIndex).val(number_format(debtFunding, 1)).trigger('change')
})

$(document).on('change', '.hundred-minus-number1,.hundred-minus-number2', function () {
	// console.log('from 44')
	let parent = $(this).closest('.closest-parent')
	const columnIndex = $(this).attr('data-column-index')
	const appendColumnIndex = columnIndex == undefined ? '' : '[data-column-index="' + columnIndex + '"]'
	let number1 = number_unformat($(parent).find('.hundred-minus-number1' + appendColumnIndex).val())
	let number2 = number_unformat($(parent).find('.hundred-minus-number2' + appendColumnIndex).val())
	let debtFunding = 100 - number1 - number2
	$(parent).find('.hundred-minus-two-number-result' + appendColumnIndex).val(number_format(debtFunding, 1)).trigger('change')
})


let handlePaymentTermModal = function () {
	// console.log('from 45')
	const parentTermsType = $(this).closest('select').val()
	const tableId = $(this).closest('table').attr('id')
	const parent = $(this).closest('td')
	if (parentTermsType == 'customize') {
		parent.find('.collection-modal').modal('show')
	}
	if (parentTermsType == 'installment') {
		parent.find('.installment-modal').modal('show')
	}
}
$(document).on('change', 'select.payment_terms', handlePaymentTermModal)


$(document).on('change', '.rate-element', function () {
	// console.log('from 46')
	let total = 0
	const parent = $(this).closest('tbody')

	parent.find('.rate-element').each(function (index, element) {
		total += parseFloat(number_unformat($(element).val()))
	})
	parent.find('td.td-for-total-payment-rate').html(number_format(total, 2) + ' %')

})




$(document).ready(function () {

	// console.log('from 47')
	$(document).on('select2:select', '.js-select2-with-one-selection', function (e) {
		// Keep only the last selected option
		let selected = e.params.data.id
		$(this).val([selected]).trigger('change')
	})

})



function initMultiselect(container) {
	const $container = $(container)
	const $trigger = $container.find('.multiselect-trigger')
	const $dropdown = $container.find('.multiselect-dropdown')
	if (!$dropdown.length) {
		return
	}
	// console.log($container)
	// console.log($dropdown.length)
	const $searchInput = $container.find('.search-input')
	const $addOptionInput = $container.find('.add-option-input')
	const $addOptionBtn = $container.find('.btn-add-option')
	const $selectAllBtn = $container.find('.btn-select-all')
	const $deselectAllBtn = $container.find('.btn-deselect-all')
	const $optionsContainer = $container.find('.multiselect-options')
	const $selectedText = $container.find('.selected-text')
	const $selectedOptionsContainer = $container.find('.selected-options-container')
	let selectedValues = []

	// Toggle dropdown
	$trigger.on('click', function (e) {
		e.stopPropagation()
		$dropdown.toggle()
	})

	// Close on outside click
	$(document).on('click', function (e) {
		if (!$container.has(e.target).length) {
			$dropdown.hide()
		}
	})

	// Bind checkbox events
	function bindCheckboxEvents($checkbox) {
		$checkbox.on('change', updateSelected)
	}

	// Update selected values and display
	function updateSelected() {
		const $options = $optionsContainer.find('.option-item input[type="checkbox"]')
		selectedValues = $options.filter(':checked').map(function () { return $(this).val() }).get()
		$selectedText.text(selectedValues.length ? `${selectedValues.length} selected` : 'Select options...')

		// Clear existing hidden inputs
		$selectedOptionsContainer.empty()
		// Add a hidden input for each selected value
		selectedValues.forEach(function (value) {
			$selectedOptionsContainer.append(
				`<input type="hidden" name="selectedOptions[]" value="${value}">`
			)
		})
	}

	// Bind initial checkboxes
	$optionsContainer.find('.option-item input[type="checkbox"]').each(function () {
		bindCheckboxEvents($(this))
	})

	// Select All
	$selectAllBtn.on('click', function (e) {
		e.preventDefault()
		$optionsContainer.find('.option-item input[type="checkbox"]').prop('checked', true)
		updateSelected()
	})

	// Deselect All
	$deselectAllBtn.on('click', function (e) {
		e.preventDefault()
		$optionsContainer.find('.option-item input[type="checkbox"]').prop('checked', false)
		updateSelected()
	})

	// Search filter
	$searchInput.on('input', function () {
		const query = $(this).val().toLowerCase()
		$optionsContainer.find('.option-item').each(function () {
			const label = $(this).text().toLowerCase()
			$(this).toggle(label.includes(query))
		})
	})





	updateSelected() // Initial call
}

$(function () {
	$('[data-repeater-item]').each(function () {
		initMultiselect($(this))
	})
})


$(document).on('change', '[js-main-select]', function () {
	// console.log('from 48')
	const value = $(this).val()
	const isChecked = $(this).is(':checked')
	if (isChecked) {
		$(this).closest('.multiselect-options').find('input[data-parent="' + value + '"]').attr('checked', true).trigger('change')
	} else {
		$(this).closest('.multiselect-options').find('input[data-parent="' + value + '"]').attr('checked', false).trigger('change')
	}
})
$(document).on('changed.bs.select', 'select.js-due_in_days', function (e, clickedIndex, isSelected, previousValue) {
	// console.log('from 49')
	if (isSelected) {
		let currentValue = $(this).find('option').eq(clickedIndex).val()
		setTimeout(() => {
			$(this).selectpicker('val', [currentValue]).selectpicker('refresh')
		}, 0)
	}
})
$(document).on('click', '.increase-rate-parent', function () {
	$(this).closest('.increase-rate-parent').find('.modal-increase-rates').modal('show')
})
$(document).on('click', '.show-hide-repeater', function () {
	const query = this.getAttribute('data-query')
	$(query).fadeToggle(300)

})
$('#seasonality').on('change', function () {
	var seasonality = $(this).val()
	if (seasonality == 'flat') {
		$('.flat_section').removeClass('hidden')
		$('.quarterly_section').addClass('hidden')
		$('.monthly_section').addClass('hidden')
		$('.percentage').addClass('hidden')
		$('.quarterly').val('')
		$('.monthly').val('')
	} else if (seasonality == 'quarterly') {
		$('.flat_section').addClass('hidden')
		$('.monthly_section').addClass('hidden')
		$('.quarterly_section').removeClass('hidden')
		$('.percentage').removeClass('hidden')
		$('.monthly').val('')
	} else if (seasonality == 'monthly') {
		$('.flat_section').addClass('hidden')
		$('.quarterly_section').addClass('hidden')
		$('.monthly_section').removeClass('hidden')
		$('.percentage').removeClass('hidden')
		$('.quarterly').val('')
	} else {
		$('.flat_section').addClass('hidden')
		$('.quarterly_section').addClass('hidden')
		$('.monthly_section').addClass('hidden')
		$('.percentage').removeClass('hidden')
		$('.quarterly').val('')
		$('.monthly').val('')
	}
})
$(document).on('change', 'select.update-revenue-category-based-on-revenue-js', function () {
	const revenueStreamId = $(this).val()
	let studyId = $('#study-id-js').val()
	const that = this
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-stream-category-based-on-revenue-stream-id'
	const data = {
		revenueStreamId
	}
	$.ajax({
		url,
		data,
		success: function (res) {
			let options = ''
			const revenueCategoryElement = $(that).closest('tr').find('select.revenue-category-class')
			const selectedCategories = JSON.parse(revenueCategoryElement.attr('data-current-selected'))
			for (var option of res.data) {
				var value = String(option.value)
				var isSelected = selectedCategories.includes(value) ? 'selected' : ''
				options += '<option ' + isSelected + ' value="' + option.value + '">' + option.title + '</option>'
			}
			revenueCategoryElement.empty().append(options).trigger('change')

		}
	})
})
$('select.update-revenue-category-based-on-revenue-js').trigger('change')

$(document).on('change', '.microfinance-checkbox-js', function () {
	var checked = $(this).is(':checked')
	if (checked) {
		$('.show-only-with-microfinance').show()
	} else {
		$('.show-only-with-microfinance').hide()
		$('.show-only-with-microfinance input').prop('checked', false).trigger('change')
		$('.no-branch-div').addClass('hidden')
		//	$('.no-branch-input-js').val(0).trigger('change')

	}
})
$('.microfinance-checkbox-js').trigger('change')


$(document).on('change', '.microfinance-sub-checkbox-js', function () {
	var isWholeCompany = $(this).hasClass('is-whole-company')
	var isByBranch = $(this).hasClass('is-by-branch')
	// console.log(isByBranch)
	if (isByBranch) {
		$('.no-branch-div').removeClass('hidden')
	} else {
		$('.no-branch-div').addClass('hidden')
		//	$('.no-branch-input-js').val(0).trigger('change')
	}
})
$('.microfinance-sub-checkbox-js:checked').trigger('change')

$(document).on('change', '.create-product-or-existing-branch-js', function () {
	const isChecked = $(this).is(':checked')
	const value = $(this).val()
	console.log(value)
	if (value == 'product-mix') {
		$('.product-mix-count-parent-js').removeClass('hidden')
	} else {
		$('.product-mix-count-parent-js').addClass('hidden')
	}
})
$('.create-product-or-existing-branch-js:checked').trigger('change')


function calculateResult(input,v) {
        //        let baseValue = input.value.trim();
		baseValue = $(input).val();
	
          //      let multiplier = parseFloat(multiplierValue);

                if (baseValue.startsWith("=")) {
                    try {
                        baseValue = math.evaluate(baseValue.substring(1)); // Evaluate formula
                    } catch (e) {
                        baseValue = 0;
                    }
                } else {
                    baseValue = parseFloat(baseValue);
                }
				console.log('after',baseValue);
                if (!isNaN(baseValue)) {
					baseValueHidden = baseValue.toFixed(10); // Format to 5 decimals
                    baseValue = baseValue.toFixed(2); // Format to 5 decimals
                   $(input).val(baseValue).trigger('change'); // Update input field
				   $(input).closest('.input-hidden-parent').find('input.input-hidden-with-name').val(baseValueHidden);
                }

            }
			$(document).on('blur','.calcField',function(){
				calculateResult($(this),this.value.trim());
			})
       
$(document).on('click','.recalculate-decrease-rates',function(){
	const parent = $(this).closest('td');
	const productId = parent.attr('data-product-id');
	const tenor = $('.tenor-class'+productId).val();
	const flatRate = $(parent).find('.flat-rate-input').val();
	console.log(flatRate)
	parent.find('.flat-rate-id').val(flatRate);
	
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-decrease-rate-based-on-flat-rate';
	
	
	$.ajax({
		url ,
		data:{
			flatRate,
			tenor
		},
		success:function(res){
			parent.find('.decreasing-rate-id').val(res.decreaseRate);
		}
	})
	
})
