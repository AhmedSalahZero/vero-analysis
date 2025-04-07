$(document).on('click', '.repeat-to-right', function () {
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
	const val = $(this).val()
	const columnIndex = $(this).attr('data-column-index')
	const numberOfDecimals = $(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').attr('data-number-of-decimals')
	$(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').val(number_format(val, numberOfDecimals))
})
$(document).on('click', '.repeat-select-to-right', function () {
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


$(document).on('change', 'select.revenue-stream-type-js', function () {
	let revenueStreams = $(this).val()
	let studyId = $('#study-id-js').val()
	const that = this
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-stream-category-based-on-revenue-stream'
	if (revenueStreams.length) {
		var streamCategoryElement = $(that).closest('tr').find('select.stream-category-class')
		var currentSelected = $(streamCategoryElement).attr('data-current-selected-items') ? JSON.parse($(streamCategoryElement).attr('data-current-selected-items')) : null
		$.ajax({
			url,
			data: {
				revenueStreams
			},
			method: "post",
			success: function (res) {
				var options = ''
				var selected = ''
				if (currentSelected ? currentSelected.includes('all') : false) {
					selected = 'selected'
				}
				options += `<option ${selected} value="all">All</option>`
				
				for (id in res.result) {
					var title = res.result[id]
					selected = ''
					if (currentSelected ? currentSelected.includes(id) : null) {
						selected = 'selected'
					}
					options += `<option ${selected} value="${id}">${title}</option>`
				}
				streamCategoryElement.empty().append(options).trigger('change')
			}
		})
	} else {

	}
})
$(document).on('change', '.current-loan-input', function () {
	let total = 0
	let currentLoanIndex = parseInt($(this).attr('data-column-index'))
	$('.current-loan-input[data-column-index="' + currentLoanIndex + '"]').each(function (index, element) {
		total += parseFloat($(element).val())
	})

	$(this).closest('table').find('[data-row-total] .repeat-to-right-input-formatted[data-column-index="' + currentLoanIndex + '"]').val(number_format(total)).trigger('change')

})
$(document).on('change', '[js-recalculate-equity-funding-value]', function () {
	const columnIndex = parseInt($(this).attr('data-column-index'))
	const total = $('.total-loans-hidden[data-column-index="' + columnIndex + '"]').val()
	const equityFundingRate = $('.equity-funding-rates[data-column-index="' + columnIndex + '"]').val()
	let equityFundingValue = equityFundingRate / 100 * total
	let newLoanFundingValue = (1 - (equityFundingRate / 100)) * total
	$('input.equity-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(equityFundingValue)).trigger('change')
	$('input.new-loans-funding-formatted-value-class[data-column-index="' + columnIndex + '"]').val(number_format(newLoanFundingValue)).trigger('change')
})
$('[js-recalculate-equity-funding-value]').trigger('change')
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
	// const rowIndex = $('.factoring-rate[data-column-index="' + index + '"]').closest('[data-repeater-item]').index()
	var value = $('.factoring-projection-amount[data-column-index="' + index + '"]').val()
	
	$('.factoring-rate[data-column-index="' + index + '"]').each(function(currentIndex,rateElement){
		var rate = $(rateElement).val()
		var numberOfDecimals = $(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').closest('.input-hidden-parent').find('.repeat-to-right-input-formatted').attr('data-number-of-decimals');
		$(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').closest('.input-hidden-parent').find('.repeat-to-right-input-formatted').val(number_format(rate / 100 * value,numberOfDecimals));
		$(rateElement).closest('tr').find('.factoring-value[data-column-index="' + index + '"]').val(rate / 100 * value).trigger('change')
	})
})

$(function () {

	$('select.revenue-stream-type-js').trigger('change')
})
$(document).on('change', 'select.js-update-positions-for-department', function () {
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const departmentId = $(this).val()
	const currentPositionId = $(this).attr('data-current-selected')
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-positions-based-on-department'

	$.ajax({
		url,
		data: {
			departmentId,
			currentPositionId
		},
		type: "get",
		success: (res) => {
			let positions = ''
			for (let id in res.positions) {
				positions += `<option value="${id}" ${id == currentPositionId ? 'selected' : ''} >${res.positions[id]}</option>`
			}
			$(this).closest('tr').find('select.position-class').empty().append(positions).trigger('change')
		}

	})
})
$('select.js-update-positions-for-department').trigger('change')

$(document).on('change', '.is-percentage-from-total,.is-percentage-total-of', function () {
	let commonClass = $(this).attr('data-common-percentage-of-class')
	let columnIndex = $(this).attr('data-column-index')
	
	
	let totalOfAmount = $('.is-percentage-total-of[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').val()
	let currentRow = $(this).closest('tr')
	let tableRows = $(this).closest('table').find('tbody tr')
	let rowIndex = $(tableRows).index(currentRow)
	let percentage = $('.is-percentage-from-total[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').eq(rowIndex).val()
	let result = percentage / 100 * totalOfAmount
	let resultRow = $('.is-result-total-of[data-common-percentage-of-class="' + commonClass + '"][data-column-index="' + columnIndex + '"]').eq(rowIndex);
	let numberOfDecimals = resultRow.closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').attr('data-number-of-decimals')
	resultRow.closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="' + columnIndex + '"]').val(number_format(result, numberOfDecimals)).val(result)
	resultRow.val(result);
})


$(document).on('click', '.collapse-before-me', function () {

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

		$(this).closest('table').find('[data-column-index="' + columnIndex + '"]:not(.exclude-from-collapse)').toggle()

		columnIndex--
		counter++
		if (counter == 12) {
			hide = false
		}
	}
})
$(document).on('change', '.repeater-with-collapse-input', function () {
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
	e.preventDefault()
	$(this).toggleClass('rotate-180')
	$(this).closest('[data-is-main-row]').nextUntil('[data-is-main-row]').toggleClass('hidden')
})
$(document).on('change', '.recalculate-gr', function () {
	const columnIndex = parseInt($(this).attr('data-column-index'))
	const previousColumnIndex = columnIndex - 1
	const nextColumnIndex=columnIndex+1;
	const growthRateOfCurrentYear = $('.gr-field[data-column-index="' + columnIndex + '"]').val()
	
	
		
		allElements = $('.current-growth-rate-result-value-formatted[data-column-index="' + columnIndex + '"]') ;
		allElements.each(function (index, element) {
			const loanAmount = $(element).closest('tr').find('.current-growth-rate-result-value[data-column-index="' + previousColumnIndex + '"]').val()
			if(loanAmount != undefined){
				currentAmount = (1 + (growthRateOfCurrentYear / 100)) * loanAmount
				$(element).val(number_format(currentAmount)).trigger('change')
			}
		
		})
	$('.recalculate-gr[data-column-index="'+nextColumnIndex+'"]').trigger('change');
})
$(document).on('change','.current-growth-rate-result-value-formatted',function(event){
	const columnIndex = parseInt($(this).attr('data-column-index'));
	const nextColumnIndex=columnIndex+1;
	if(event.originalEvent && event.originalEvent.isTrusted){
		$('.recalculate-gr[data-column-index="'+nextColumnIndex+'"]').trigger('change');
	}else{
		console.log("Input was changed programmatically.");

	}
	//$('.recalculate-gr[data-column-index="'+nextColumnIndex+'"]').trigger('change');
})
$(document).on('change','.is-fully-funded-checkbox',function(){
	const value = parseInt($(this).val());
	const canViewFundingStructure = parseInt($('#toggleEditBtn').attr('can-show-funding-structure'));


	$('#ffe-funding').hide();
	if(value){
		$('#ffe-funding').hide();
		$('#toggleEditBtn').hide();
		$('#save-and-go-to-next').show();
	
	}else{
		if(canViewFundingStructure){
			$('#ffe-funding').show();
		}
		$('#save-and-go-to-next').hide();
		$('#toggleEditBtn').show();
	
		
	}
	if(canViewFundingStructure){
		$('#save-and-go-to-next').show();
	}
	
});
$('.is-fully-funded-checkbox:checked').trigger('change');
$(document).on('change','.recalculate-monthly-increase-amounts',function(){
	var currentRow = $(this).closest('tr') ;
	var itemCost = currentRow.find('.ffe-item-cost').val();
	// var vat = currentRow.find('dd');
	var costAnnuallyIncreaseRate = currentRow.find('.cost-annually-increase-rate').val() / 100;
	var contingencyRate = currentRow.find('.contingency-rate').val() / 100;
	
	var yearIndex = -1 ; ;
	currentRow.find('.ffe_counts').each(function(index,ffeCountElement){
		var currentYearIndex = parseInt($(ffeCountElement).attr('data-current-year-index'));
		var currentMonthIndex=$(ffeCountElement).attr('data-column-index');
		if(currentYearIndex != yearIndex){
			yearIndex++;
		}
		var currentCount = $(ffeCountElement).val();
		var currentTotalAmount = itemCost * currentCount  * (1+contingencyRate); 
		var currentTotalAmountIncrease = currentTotalAmount * Math.pow(1 + costAnnuallyIncreaseRate, yearIndex)
	
		$(ffeCountElement).closest('td').find('.current-month-amounts').val(currentTotalAmountIncrease);
		var totalForCurrentMonth = 0 ;
		$('.current-month-amounts[data-column-index="'+currentMonthIndex+'"]').each(function(index,amountElement){
			totalForCurrentMonth+= parseFloat($(amountElement).val());
		})
		$('.direct-ffe-amounts[data-column-index="'+currentMonthIndex+'"]').val(number_format(totalForCurrentMonth)).trigger('change');
		
	})
	
})
let calculateBranchIncreaseAmounts = function(){
	var currentRow = $(this).closest('tr') ;
	var itemCost = parseFloat(currentRow.find('.ffe-item-cost').val());
	itemCost = itemCost ? itemCost : 0 ;
	var costAnnuallyIncreaseRate = currentRow.find('.cost-annually-increase-rate').val() / 100;
	costAnnuallyIncreaseRate = costAnnuallyIncreaseRate ? costAnnuallyIncreaseRate : 0 ;
	var contingencyRate = currentRow.find('.contingency-rate').val() / 100;
	contingencyRate = contingencyRate ? contingencyRate : 0;
	var currentItemCount = parseInt(currentRow.find('.current-count').val());
	currentItemCount = currentItemCount ? currentItemCount : 0;
	var yearIndex = -1 ; // will increase every year ;
	var  netBranchOpeningProjections = JSON.parse($('#net-branch-opening-projections').val());
	var counts = {};
	for(var currentDateAsIndex in netBranchOpeningProjections){
		var currentBranchCount = netBranchOpeningProjections[currentDateAsIndex];
		currentCount = currentBranchCount * currentItemCount;
		var currentYearIndex = $('.year-index-month-index[data-month-index="'+ currentDateAsIndex +'"]').attr('data-year-index');
		var currentMonthIndex=currentDateAsIndex;
		if(currentYearIndex != yearIndex){
			yearIndex++;
		}
		counts[currentMonthIndex]=currentCount;
		var currentTotalAmount = itemCost * currentCount  * (1+contingencyRate); 
		var currentTotalAmountIncrease = currentTotalAmount * Math.pow(1 + costAnnuallyIncreaseRate, yearIndex)
		$(currentRow).closest('tr').find('.current-month-amounts[data-column-index="'+currentMonthIndex+'"]').val(currentTotalAmountIncrease);
		var totalForCurrentMonth = 0 ;
		$('.current-month-amounts[data-column-index="'+currentMonthIndex+'"]').each(function(index,amountElement){
			var currentAmount = $(amountElement).val() ;
			currentAmount = currentAmount == undefined ? 0 : currentAmount ;
			totalForCurrentMonth+= parseFloat(currentAmount);
			
		})
		$('.direct-ffe-amounts[data-column-index="'+currentMonthIndex+'"]').val(number_format(totalForCurrentMonth)).trigger('change');
		
	}
	$(currentRow).find('.current-row-counts').val(JSON.stringify(counts));
}
$(document).on('change','.recalculate-monthly-increase-amounts-branches',calculateBranchIncreaseAmounts)
$('.recalculate-monthly-increase-amounts-branches').trigger('change');
$(document).on('change','select.department-class',function(){
	const departmentIds = $(this).val();
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/' + studyId + '/get-positions-based-on-departments';
	var data = {
		departmentIds
	}
	$.ajax({
		url,
		data,
		success:(res)=>{
			var positionArr = res.positionIds ;
			var options ='';
			var positionRow = $(this).closest('tr').find('select.position-class');
			var currentSelected = JSON.parse($(positionRow).attr('data-current-selected-items'));
			for(var positionId in positionArr){
				positionId = positionId;
				var selected = currentSelected.includes(positionId);
				console.log(currentSelected,positionId,selected,'--')
				options+=`<option ${selected ? 'selected':''} value="${positionId}">${positionArr[positionId]}</option>`
			}
			$(positionRow).empty().append(options).trigger('change');
		}
	})
	
})
$(function(){
	$('select.department-class').trigger('change');
})


$(document).ready(function() {
    // Set table to readonly by default
	var inEditMode = parseInt($('#toggleEditBtn').attr('in-edit-mode'));
	if(inEditMode){
		$('#fixedAssets_repeater').addClass('readonly');
		const table = $('#fixedAssets_repeater');
		table.find('input, select').prop('readonly', true);
	}
    // Toggle editability
    $('#toggleEditBtn').click(function(e) {
		e.preventDefault();
        const table = $('#fixedAssets_repeater');
        const isReadonly = table.hasClass('readonly');
        
		// console.log('save form',saveForm);

        if (isReadonly) {
			table.removeClass('readonly').addClass('editable');
			$(this).text('Disabled Editing');
			$(this).attr('can-show-funding-structure',0);
		//	$(this).attr('is-save-and-continue',1);
            // Enable all inputs and selects
			
				table.find('input, select').prop('readonly', false);
				//table.find('.bootstrap-select').removeClass('disabled');
			
        } else {
			table.removeClass('editable').addClass('readonly');

			$(this).text('Enable Editing');
	//		$(this).attr('is-save-and-continue',0);
			$(this).attr('can-show-funding-structure',1);
            // Disable all inputs and selects
		
				table.find('input, select').prop('readonly', true);
	
		
				
        }
		$('.is-fully-funded-checkbox:checked').trigger('change');
    });
    
    // Initially disable all inputs and selects
    // $('#fixedAssets_repeater').find('input, select').prop('readonly', true);
    // $('#fixedAssets_repeater').find('.bootstrap-select').addClass('readonly');
});

$(function(){
//	$('#toggleEditBtn').click();
})
