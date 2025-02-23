$(document).on('click','.repeat-to-right',function(){
	let columnIndex = parseInt($(this).attr('data-column-index'))
	let parent = $(this).closest('tr');
	let name = $(this).attr('data-name');
	let numberFormatDecimalsForCurrentRow = parent.attr('data-repeat-formatting-decimals')
	numberFormatDecimalsForCurrentRow = numberFormatDecimalsForCurrentRow ? numberFormatDecimalsForCurrentRow : 0 ;
	let input = parent.find('.repeat-to-right-input-formatted[data-column-index="'+ columnIndex +'"][data-name="'+name+'"]');
	let numberOfDecimalsForCurrentInput = $(input).attr('data-number-of-decimals');
	numberOfDecimalsForCurrentInput = numberOfDecimalsForCurrentInput == undefined ? numberFormatDecimalsForCurrentRow : numberOfDecimalsForCurrentInput;
	let inputValue = input.val();
	inputValue = number_unformat(inputValue);
	let totalPerYear = 0 ;
	$(this).closest('tr').find('.repeat-to-right-input-formatted[data-name="'+name+'"]').each(function(index,inputFormatted){
		let currentColumnIndex = $(inputFormatted).attr('data-column-index');
		if(currentColumnIndex >= columnIndex ){
			totalPerYear += parseFloat(inputValue) ;
			$(inputFormatted).val(number_format(inputValue,numberOfDecimalsForCurrentInput)).trigger('change');
		}
	})
})
$('.repeat-to-right-input-hidden').on('change',function(){
	const val = $(this).val();
	const columnIndex = $(this).attr('data-column-index');
	const numberOfDecimals = $(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="'+columnIndex+'"]').attr('data-number-of-decimals');
	$(this).closest('.input-hidden-parent').find('.copy-value-to-his-input-hidden[data-column-index="'+columnIndex+'"]').val(number_format(val,numberOfDecimals))
})
$(document).on('click','.repeat-select-to-right',function(){
	let columnIndex = parseInt($(this).attr('data-column-index'))
	let parent = $(this).closest('tr');
	let value = parent.find('.repeat-to-right-select[data-column-index="'+ columnIndex +'"]').val();
	$(this).closest('tr').find('.repeat-to-right-select').each(function(index,select){
		if($(select).attr('data-column-index') >= columnIndex ){
			$(select).val(value).trigger('change');
		}
	})

})

$(document).on('change','.input-hidden-parent .copy-value-to-his-input-hidden',function(){
	let val = $(this).val();
	$(this).closest('.input-hidden-parent').find('input.input-hidden-with-name').val(number_unformat(val)).trigger('change');
})


$(document).on('change', '.is-leasing', function() {
	const isTotalOthers = $('#is-leasing-1').is(':checked');
	const parent = $(this).closest('.form-group.row')
	if (isTotalOthers) {
		parent.find('.total-leasing-div').css('display', 'initial').find('input,select').prop('disabled', false)
		parent.find('.leasing-repeater-parent').css('display', 'none').find('input,select').prop('disabled', true)
	} else {
		parent.find('.leasing-repeater-parent').css('display', 'initial').find('input,select').prop('disabled', false)
		parent.find('.total-leasing-div').css('display', 'none').find('input,select').prop('disabled', true)
	}
})
$(function() {
	$('.is-leasing:checked').trigger('change');
})


$(document).on('change','select.revenue-stream-type-js',function(){
	let revenueStreams = $(this).val()
	let studyId = $('#study-id-js').val()
	const that = this ;
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/'+studyId+'/get-stream-category-based-on-revenue-stream'

	if(revenueStreams.length){
		streamCategoryElement = $(that).closest('tr').find('select.stream-category-class');
		var currentSelected = $(streamCategoryElement).attr('data-current-selected-items') ? JSON.parse($(streamCategoryElement).attr('data-current-selected-items')) : null;

		$.ajax({
			url,
			data:{
				revenueStreams
			},
			method:"post",
			success:function(res){
				var options ='';
				var selected = '';
					if(currentSelected ? currentSelected.includes('all') : false){
						selected = 'selected';
					}
				options+=`<option ${selected} value="all">All</option>`
			
				for(id in res.result){
					var title = res.result[id];
					 selected = '';
					if(currentSelected ? currentSelected.includes(id) : null){
						selected = 'selected';
					}
					options+=`<option ${selected} value="${id}">${title}</option>`
				}
				streamCategoryElement.empty().append(options).trigger('change');
			}
		})
	}else{
		
	}
})
$(document).on('change','.current-loan-input',function(){
	let total = 0 ;
	let currentLoanIndex = parseInt($(this).attr('data-column-index')) ;
	$('.current-loan-input[data-column-index="'+currentLoanIndex+'"]').each(function(index,element){
		total+=parseFloat($(element).val());
	})

	$(this).closest('table').find('[data-row-total] .repeat-to-right-input-formatted[data-column-index="'+currentLoanIndex+'"]').val(number_format(total)).trigger('change');

})
$(document).on('change','.js-recalculate-equity-funding-value',function(){
	const columnIndex = parseInt($(this).attr('data-column-index'));
	const total = $('.total-loans-hidden[data-column-index="'+ columnIndex +'"]').val();
	const equityFundingRate = $('.equity-funding-rates[data-column-index="'+ columnIndex +'"]').val();
	let equityFundingValue  = equityFundingRate /100 * total;
	let newLoanFundingValue = (1-(equityFundingRate /100) )* total ;
	console.log(equityFundingValue,columnIndex);
	console.log($('input.equity-funding-formatted-value-class[data-column-index="'+columnIndex+'"]').length)
	$('input.equity-funding-formatted-value-class[data-column-index="'+columnIndex+'"]').val(number_format(equityFundingValue)).trigger('change');
	$('input.new-loans-funding-formatted-value-class[data-column-index="'+columnIndex+'"]').val(number_format(newLoanFundingValue)).trigger('change');
})
$('.js-recalculate-equity-funding-value').trigger('change');
function convertDateToDefaultDateFormat(dateStr)
{
	const [month,day, year] = dateStr.split("/"); // Split the string by "/";
	return  `${year}-${month}-${day}`; // Rearrange to YYYY-MM-DD
}
function getEndOfMonth(year, month) {
	// قم بإنشاء تاريخ لأول يوم من الشهر التالي
	let date = new Date(year, month + 1, 0);
	return date;
  }
  $(document).on('change','.recalculate-factoring',function(){
	const index = parseInt($(this).attr('data-column-index'));  
	const rate = $('.factoring-rate[data-column-index="'+index+'"]').val();
	const rowIndex = $('.factoring-rate[data-column-index="'+index+'"]').closest('[data-repeater-item]').index();
	const value = $('.factoring-projection-amount[data-column-index="'+index+'"]').val();
	$('.factoring-value[data-column-index="'+index+'"]').val(rate/100*value).trigger('change');
  })

  $(function(){

	$('select.revenue-stream-type-js').trigger('change');
  })
  $(document).on('change','select.js-update-positions-for-department',function(){
	const companyId = $('body').attr('data-current-company-id')
	const lang = $('body').attr('data-lang')
	let studyId = $('#study-id-js').val()
	const departmentId  = $(this).val();
	const currentPositionId = $(this).attr('data-current-selected');
	const url = '/' + lang + '/' + companyId + '/non-banking-financial-services/study/'+studyId+'/get-positions-based-on-department'

	$.ajax({
		url,
		data:{
			departmentId,
			currentPositionId
		} ,
		type:"get",
		success:(res)=>{
			let positions = '';
			for(let id in res.positions){
				positions+=`<option value="${id}" ${id == currentPositionId ? 'selected' : ''} >${res.positions[id]}</option>`
			}
			$(this).closest('tr').find('select.position-class').empty().append(positions).trigger('change')
		}
		
	})
  })
  $('select.js-update-positions-for-department').trigger('change')

  $(document).on('change','.is-percentage-from-total,.is-percentage-total-of',function(){
	let commonClass = $(this).attr('data-common-percentage-of-class');
	let columnIndex = $(this).attr('data-column-index');
	let percentage = $('.is-percentage-from-total[data-common-percentage-of-class="'+commonClass+'"][data-column-index="'+columnIndex+'"]').val();
	let totalOfAmount = $('.is-percentage-total-of[data-common-percentage-of-class="'+commonClass+'"][data-column-index="'+columnIndex+'"]').val();
	let currentRow = $(this).closest('tr');
	let tableRows = $(this).closest('table').find('tbody tr');
	let rowIndex = $(tableRows).index(currentRow)
	let result = percentage /100 * totalOfAmount ;
	$('.is-result-total-of[data-common-percentage-of-class="'+commonClass+'"][data-column-index="'+columnIndex+'"]').eq(rowIndex).val(result)
  })

  
  $(document).on('click','.collapse-before-me',function(){

	let columnIndex = $(this).attr('data-column-index') ;
	hide = true ;
	let counter = 0;
	while(hide){
		if(counter != 0){
	
			if($(this).closest('table').find('th[data-column-index="'+columnIndex+'"]').hasClass('exclude-from-collapse'))
			{
				hide = false;
				return ;
			}
		}
	
		$(this).closest('table').find('[data-column-index="'+columnIndex+'"]:not(.exclude-from-collapse)').toggle()
		
		columnIndex--;		
		counter ++;
		if(counter == 12){
			hide = false ;
		}
	}
})
$(document).on('change','.repeater-with-collapse-input',function(){
	let groupIndex = $(this).attr('data-group-index');
	let total = 0 ;
	$(this).closest('tr').find('input[data-group-index="'+groupIndex+'"]').each(function(index,element){
		total+= parseFloat($(element).val());
	})
	$(this).closest('tr').find('.year-repeater-index-'+groupIndex).val(number_format(total)).trigger('change');
})
$('input[type="hidden"].exclude-from-collapse').on('change',function(){
	var total = 0 ;
	$(this).closest('tr').find('.repeat-group-year').each(function(index,element){
		total+= parseFloat(number_unformat($(element).val()));
	})
	
	$(this).closest('tr').find('.total-td').val(number_format(total)).trigger('change');
})
$(document).on('click','.add-btn-js',function(e){
	e.preventDefault();
	$(this).toggleClass('rotate-180')
	$(this).closest('[data-is-main-row]').nextUntil('[data-is-main-row]').toggleClass('hidden')
	})
	$(document).on('change','.recalculate-gr',function(){
		const columnIndex = $(this).attr('data-column-index');
		const previousColumnIndex = columnIndex -1 ;
		const growthRateOfCurrentYear = $('.gr-field[data-column-index="'+columnIndex+'"]').val();
		const loanAmount = $('.current-growth-rate-result-value[data-column-index="'+previousColumnIndex+'"]').val(); 

		if(loanAmount != undefined){
			currentAmount = (1 + (growthRateOfCurrentYear / 100)) * loanAmount 
			$('.current-growth-rate-result-value[data-column-index="'+columnIndex+'"]').each(function(index,element){
				$(element).val(currentAmount).trigger('change');
			})
		}
	})
