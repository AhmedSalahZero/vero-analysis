<?php $__env->startSection('Title'); ?>
<style>
    tbody td {
        font-weight: bold;
        color: black !important;
    }

</style>
<span class="kt-portlet__head-icon">
    <i class="kt-font-brand flaticon2-line-chart fa-fw flaticon-house-sketch pull-<?php echo e(__('left')); ?>"></i>
    <?php echo e(__('Loan Calculator') . ' ( ' .str_to_upper(Request()->segments()[count(Request()->segments())-1]) . ' )'); ?>

</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<!-- end::Sticky Toolbar -->
<div class="kt-portlet">
    <?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <ul>
            <li><?php echo e(Session::get('success')); ?></li>
        </ul>
    </div>
    <?php endif; ?>
</div>

<form class="kt-form kt-form--label-right" id="create-form" method="POST" action="<?php echo e(route('loan2.store.php',['company' => $company->id,'financialInstitution'=>$financialInstitution->id])); ?>">
    <?php echo e(csrf_field()); ?>



    <div class="kt-portlet">
        <div class="kt-portlet__body">


            <div class="row">

                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Fixed Loan Type')); ?></label><span class="astric">*</span>
                        <div class="form-group-sub">
                            <select name="fixed_loan_type" id="fixed_loan_type" class="form-control">
                                <?php $__currentLoopData = getFixedLoanTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fixedType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($fixedType); ?>" <?php echo e(@old('fixed_loan_type') == $fixedType ? 'selected' : ''); ?> <?php echo e(isset($loan) && ($loan->fixedType == $fixedType) ? 'selected' : ''); ?>><?php echo e(str_to_upper($fixedType)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('installment_interval')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('fixed_loan_type')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Loan Start Date')); ?>

                            <span class="astric">*</span>

                        </label>
						   
                        <div class="form-group-sub">
                            <input  value="<?php echo e($loan && $loan->start_date ?$loan->start_date:null); ?>"  required type="date" id="start-date" name="start_date" class="form-control number interval-calcs" placeholder="<?php echo e(__('Loan Start Date')); ?> <?php echo e(__('Autoload')); ?>  .." />
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Loan Amount')); ?>

                            <span class="astric">*</span>
                        </label>
                        <?php if(isset($longTermFunding)): ?>
                        <input type="hidden" name="company_id" value="<?php echo e($longTermFunding->company_id); ?>">
                        <input type="hidden" name="financial_id" value="<?php echo e($longTermFunding->financial_id); ?>">
                        <input type="hidden" name="long_term_funding_id" value="<?php echo e($longTermFunding->id); ?>">

                        <?php elseif(Request()->has('financial_id')): ?>
                        <input type="hidden" name="long_term_funding_id" value="<?php echo e($longTermFunding ? $longTermFunding->id : Request('long_term_funding_id')); ?>">
                        <input type="hidden" name="company_id" value="<?php echo e(Request()->segment(3)); ?>">
                        <input type="hidden" name="financial_id" value="<?php echo e(Request()->get('financial_id')); ?>">

                        <?php endif; ?>


                        <div class="form-group-sub">
                            <input 
                            value="<?php echo e($loan ? $loan->loan_amount : 0); ?>"
                            type="number" step="any" id="loan_amount" name="loan_amount" class="form-control number" placeholder="<?php echo e(__('Loan Amount')); ?> .." required />
                            <?php if($errors->has('loan_amount')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('loan_amount')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Base Rate % ')); ?>

                            <span class="astric">*</span>
                        </label>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->base_rate): ?>
                            value="<?php echo e($loan->base_rate ?: old('base_rate')); ?>"
                            <?php endif; ?>
                            type="number" step="any" id="base_rate" name="base_rate" class="form-control number pricing-calc-item" placeholder="<?php echo e(__('Base Rate')); ?> .." required />
                            <?php if($errors->has('base_rate')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('base_rate')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Margin Rate % ')); ?>

                            <span class="astric">*</span>
                        </label>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->margin_rate): ?>
                            value="<?php echo e($loan->margin_rate ?: old('margin_rate')); ?>"
                            <?php endif; ?>
                            type="number" step="any" id="margin_rate" name="margin_rate" class="form-control number pricing-calc-item" placeholder="<?php echo e(__('Margin Rate')); ?> .." required />
                            <?php if($errors->has('margin_rate')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('margin_rate')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Pricing %')); ?>

                            
                        </label>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->pricing): ?>
                            value="<?php echo e($loan->pricing ?: old('pricing')); ?>"

                            <?php else: ?>
                            value="<?php echo e(@old('pricing')); ?>"
                            <?php endif; ?>

                            disabled type="number" step="any" min="0" id="pricing" name="pricing" class="form-control number pricing-calc-item" placeholder="<?php echo e(__('Pricing')); ?> .." required />
                            <?php if($errors->has('pricing')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('pricing')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Tenor (Duration In Months) ')); ?>

                        </label><span class="astric">*</span>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->duration): ?>
                            value="<?php echo e($loan->duration ?: old('duration')); ?>"

                            <?php else: ?>
                            value="<?php echo e(@old('duration')); ?>"
                            <?php endif; ?>

                            type="number" step="1" min="1" max="600" id="duration" name="duration" class="form-control number grace_period_calc max-tenor-limit installment_condition" placeholder="<?php echo e(__('Duration In Months')); ?> .." required />
                            <?php if($errors->has('duration')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('duration')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Grace Period')); ?> ( <?php echo e(__('Months')); ?> )
                            <span class="astric">*</span>
                        </label>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->grace_period): ?>
                            value="<?php echo e($loan->grace_period ?: old('grace_period')); ?>"

                            <?php else: ?>
                            value="<?php echo e(@old('grace_period')); ?>"
                            <?php endif; ?>

                            type="text" step="any" id="grace_periodid" name="grace_period" class="form-control number grace_period_calc installment_condition" placeholder="<?php echo e(__('Grace Period')); ?> .." />
                            <?php if($errors->has('grace_period')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('grace_period')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Capitalization Type')); ?></label>
                        <div class="form-group-sub">
                            <select disabled name="capitalization_type" id="capitalization_type" class="form-control">
                                <option value="with_capitalization" 
								<?php echo e($loan && $loan->is_with_capitalization ? 'selected' : ''); ?>


                                    ><?php echo e(__('With Capitalization')); ?></option>
                                <option 
								
								<?php echo e($loan && !$loan->is_with_capitalization ? 'selected' : ''); ?>


                                    value="without_capitalization" <?php echo e(@old('capitalization_type') == 'without_capitalization' ? 'selected' : ''); ?>><?php echo e(__('Without Capitalization')); ?></option>
                            </select>
                            <?php if($errors->has('capitalization_type')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('capitalization_type')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Installment Payment Interval')); ?></label><span class="astric">*</span>
                        <div class="form-group-sub">
                            <select name="installment_interval" id="installment_interval" class="form-control installment_condition">
                                <option value="" selected disabled><?php echo e(__('Select')); ?> ..</option>
                                <option <?php if($loan && $loan->installment_interval == 'monthly'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="monthly" <?php echo e(@old('installment_interval') == 'monthly' ? 'selected' : ''); ?> data-order="1"><?php echo e(__('Monthly')); ?></option>
                                <option <?php if($loan && $loan->installment_interval == 'quartly'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="quartly" <?php echo e(@old('installment_interval') == 'quartly' ? 'selected' : ''); ?> data-order="2"><?php echo e(__('Quarterly')); ?></option>
                                <option <?php if($loan && $loan->installment_interval == 'semi annually'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="semi annually" <?php echo e(@old('installment_interval') == 'semi annually' ? 'selected' : ''); ?> data-order="3"><?php echo e(__('Semi-annually')); ?></option>
                            </select>
                            <?php if($errors->has('installment_interval')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('installment_interval')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Step-up Rate ( % ) ')); ?>

                            
                        </label><span class="astric">*</span>
                        <div class="" id="step-up-id">
                            <div class="form-group-sub">
                                <input <?php if($loan && $loan->step_up_rate): ?>
                                value="<?php echo e($loan->step_up_rate ?: old('step_up_rate')); ?>"

                                <?php else: ?>
                                value="<?php echo e(@old('step_up_rate')); ?>"
                                <?php endif; ?>

                                type="number" step="any" min="0" max="100" id="step_up_rate" name="step_up_rate" class="form-control number" placeholder="<?php echo e(__('Step-up Rate')); ?> .." required />
                                <?php if($errors->has('step_up_rate')): ?>
                                <div class="invalid-feedback"><?php echo e($errors->first('step_up_rate')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Step-up Interval')); ?></label><span class="astric">*</span>
                        <div class="form-group-sub">
                            <select name="step_up_interval" id="step_up_interval" class="form-control interval-calcs">
                                <option value="" selected disabled><?php echo e(__('Select')); ?> ..</option>
                                
                                <option <?php if($loan && $loan->step_up_interval == 'quartly'): ?>
                                    selected

                                    <?php endif; ?>


                                    value="quartly" <?php echo e(@old('step_up_interval') == 'quartly' ? 'selected' : ''); ?>><?php echo e(__('Quarterly')); ?></option>
                                <option <?php if($loan && $loan->step_up_interval == 'semi annually'): ?>
                                    selected

                                    <?php endif; ?>


                                    value="semi annually" <?php echo e(@old('step_up_interval') == 'semi annually' ? 'selected' : ''); ?>><?php echo e(__('Semi-annually')); ?></option>
                                <option <?php if($loan && $loan->step_up_interval == 'annually'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="annually" <?php echo e(@old('step_up_interval') == 'annually' ? 'selected' : ''); ?>><?php echo e(__('Annually')); ?></option>
                            </select>
                            <?php if($errors->has('step_up_interval')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('step_up_interval')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take">
                            <?php echo e(__('Step-down Rate ( % ) ') . ' ' . __('Please Insert Negative Number')); ?>

                            
                        </label>
                        <div class="form-group-sub">
                            <input <?php if($loan && $loan->step_down_rate): ?>
                            value="<?php echo e($loan->step_down_rate ?: old('step_down_rate')); ?>"

                            <?php else: ?>
                            value="<?php echo e(@old('step_down_rate')); ?>"
                            <?php endif; ?>


                            type="text"


                            step="any"  id="step_down_rate" name="step_down_rate" value="<?php echo e(@old('step_down_rate')); ?>" class="form-control negative-numbers" placeholder="<?php echo e(__('Step-down Rate')); ?> .." required />
                            <?php if($errors->has('step_down_rate')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('step_down_rate')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 item-main-parent" style="display: none">
                    <div class="form-group validated">
                        <label class="col-form-label take"><?php echo e(__('Step-down Interval')); ?></label> <span class="astric">*</span>
                        <div class="form-group-sub">
                            <select name="step_down_interval" id="step_down_interval" class="form-control interval-calcs">
                                <option value="" selected disabled><?php echo e(__('Select')); ?> ..</option>
                                <option <?php if($loan && $loan->step_down_interval == 'quartly'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="quartly" <?php echo e(@old('step_down_interval') == 'quartly' ? 'selected' : ''); ?>><?php echo e(__('Quarterly')); ?></option>
                                <option <?php if($loan && $loan->step_down_interval == 'semi annually'): ?>
                                    selected
                                    <?php endif; ?>

                                    value="semi annually" <?php echo e(@old('step_down_interval') == 'semi annually' ? 'selected' : ''); ?>><?php echo e(__('Semi-annually')); ?></option>
                                <option <?php if($loan && $loan->step_down_interval == 'annually'): ?>
                                    selected

                                    <?php endif; ?>

                                    value="annually" <?php echo e(@old('step_down_interval') == 'annually' ? 'selected' : ''); ?>><?php echo e(__('Annually')); ?></option>
                            </select>
                            <?php if($errors->has('step_down_interval')): ?>
                            <div class="invalid-feedback"><?php echo e($errors->first('step_down_interval')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
    

            </div>
        </div>
    </div>



    <div class="kt-portlet">
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-12">
                        <div class="<?php echo e(__('right')); ?> text-right">
                            <button type="submit" class="btn active-style ">Calculate</button>
                            
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>





</form>
<div>
<?php if(isset($fixedAtEndResult) && count($fixedAtEndResult)): ?>
<table class='table table-striped table-bordered table-hover table-checkable'>
	<thead>
		   <th class="text-center"><?php echo e(__("Payment No.")); ?></th>
                            <th class="text-center"><?php echo e(__("Date")); ?></th>
                            <th class="text-center"><?php echo e(__("Begining Balance")); ?></th>
                            <th class="text-center"><?php echo e(__("Schedule Payment")); ?></th>
                            <th class="text-center"><?php echo e(__("Interest Amount")); ?></th>
                            <th class="text-center"><?php echo e(__("Principle Amount")); ?></th>
                            <th class="text-center"><?php echo e(__("End Balance")); ?></th>
							
	</thead>
	<tbody>
	<?php
		$index = 1 ;
	?>
		<?php $__currentLoopData = $loanDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($index); ?></td>
			<td><?php echo e($date); ?></td>
			<td><?php echo e(number_format($fixedAtEndResult['beginning'][$date] ?? 0)); ?></td>
			<td><?php echo e(number_format($fixedAtEndResult['schedulePayment'][$date] ?? 0)); ?></td>
			<td><?php echo e(number_format($fixedAtEndResult['interestAmount'][$date] ?? 0)); ?></td>
			<td><?php echo e(number_format($fixedAtEndResult['principleAmount'][$date] ?? 0)); ?></td>
			<td><?php echo e(number_format($fixedAtEndResult['endBalance'][$date] ?? 0)); ?></td>
		</tr>
		<?php
			$index++;
		?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
		<tr class="custom-color-for-last-tr">
			<th><?php echo e(__('Total')); ?></th>
			<th>-</th>
			<th>-</th>
			<th>-</th>
			<th> <?php echo e(number_format($fixedAtEndResult['totals']['totalSchedulePayment'] ?? 0)); ?> </th>
			<th> <?php echo e(number_format($fixedAtEndResult['totals']['totalPrincipleAmount'] ?? 0 )); ?> </th>
			<th> <?php echo e(number_format($fixedAtEndResult['totals']['totalInterestAmount'] ?? 0)); ?> </th>
		</tr>
	</tbody>
</table>
<?php endif; ?> 
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<script>
    $(document).on('change', 'input', function(e) {

    })
    $(document).on('change', 'select', function(e) {

    })

</script>

<script>
    var type = "fixed";


</script>

<script>
    let start_date = '';

    //on change for the borrowing rate
    $(document).on('keyup', '#borrowing_rate', function() {
        loanInterest();
    });
    //on change for the margin_interest rate
    $(document).on('keyup', '#margin_interest', function() {
        loanInterest();
    });
    //calculate loaninterest
    function loanInterest() {
        var margin_interest = +$('#margin_interest').val();
        var borrowing_rate = +$('#borrowing_rate').val();
        var total = borrowing_rate + margin_interest;
        $('#loan_interest').val(total + " % ");
    }




    //installment_interval
    function installmentIntervalChange() {

        var interval = $('#installment_interval').val();
        var select = '';
        if (interval != '') {
            $('#interest_interval option:not(:first)').remove();
            var loan_amount = +$('#loan_amount').val();
            var repayment_duration = +$('#repayment_duration').val();
            var installment_amount = 0;
            if (interval == 'monthly') {
                select = '<option value="monthly">Monthly</option>\n';

                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / (repayment_duration);
                }

            } else if (interval == 'quartly') {
                select = '<option value="monthly"><?php echo e(__("Monthly")); ?></option>\n' +
                    '<option value="quartly"><?php echo e(__("Quarterly")); ?></option>\n';
                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / ((repayment_duration / 12) * 4);
                }
            } else if (interval == 'semi annually') {

                select = '<option value="monthly"><?php echo e(__("Monthly")); ?></option>\n' +
                    '<option value="quartly"><?php echo e(__("Quarterly")); ?></option>\n' +
                    '<option value="semi annually"><?php echo e(__("Semi-annually")); ?></option>\n';

                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / ((repayment_duration / 12) * 2);
                }
            }

            $('#interest_interval').append(select);
            $('#installment_amount').val(installment_amount.toFixed(2));
        }
    }

    function installmentIntervalOld(loan_interval) {
        var interval = $('#installment_interval').val();
        var select = '';
        if (interval != '') {
            if (interval == 'monthly') {

                select = '<option value="monthly" selected ><?php echo e(__("Monthly")); ?></option>\n';


            } else if (interval == 'quartly') {
                if (loan_interval == 'monthly') {
                    select = '<option value="monthly" selected><?php echo e(__("Monthly")); ?></option>\n' +
                        '<option value="quartly" ><?php echo e(__("Quarterly")); ?></option>\n';
                } else {
                    select = '<option value="monthly"><?php echo e(__("Monthly")); ?></option>\n' +
                        '<option value="quartly" selected><?php echo e(__("Quarterly")); ?></option>\n';
                }


            } else if (interval == 'semi annually') {
                if (loan_interval == 'monthly') {
                    select = '<option value="monthly" selected><?php echo e(__("Monthly")); ?></option>\n' +
                        '<option value="quartly"><?php echo e(__("Quarterly")); ?></option>\n' +
                        '<option value="semi annually"><?php echo e(__("Semi-annually")); ?></option>\n';
                } else if (loan_interval == 'quartly') {
                    select = '<option value="monthly"><?php echo e(__("Monthly")); ?></option>\n' +
                        '<option value="quartly" selected><?php echo e(__("Quarterly")); ?></option>\n' +
                        '<option value="semi annually">Semi-<?php echo e(__("Annually")); ?></option>\n';
                } else {
                    select = '<option value="monthly"><?php echo e(__("Monthly")); ?></option>\n' +
                        '<option value="quartly"><?php echo e(__("Quarterly")); ?></option>\n' +
                        '<option value="semi annually" selected><?php echo e(__("Semi-annually")); ?></option>\n';
                }

            }

            $('#interest_interval').append(select);
        }
    }
    $(document).on('change', '#installment_interval', function() {
        installmentIntervalChange();

    });
    //Installment Amount

    function instalmentAmount() {
        var interval = $('#installment_interval').val();
        if (interval != '') {
            var loan_amount = +$('#loan_amount').val();
            var repayment_duration = +$('#repayment_duration').val();
            var installment_amount = 0;
            if (interval == 'monthly') {
                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / (repayment_duration);
                }

            } else if (interval == 'quartly') {
                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / ((repayment_duration / 12) * 4);
                }
            } else if (interval == 'semi annually') {
                if (loan_amount != '' && repayment_duration != '') {
                    var installment_amount = loan_amount / ((repayment_duration / 12) * 2);
                }
            }

            $('#installment_amount').val(installment_amount.toFixed(0));
        }
    }
    $(document).on('change', '#repayment_duration', function() {
        instalmentAmount();
    });
    $(document).on('change', '#loan_amount', function() {
        instalmentAmount();
    });




    $(document).on('keypress', '.number', function(e) {
        var keyCode = (e.which) ? e.which : e.keyCode;;
        /*
        8 - (backspace)
        32 - (space)
        48-57 - (0-9)Numbers
        */
        if ((keyCode != 8 || keyCode == 32) && (keyCode != 46 && keyCode > 31) && (keyCode < 48 || keyCode > 57)) {
            return false;
        }
    });

</script>




<script>
    $('#fixed_loan_type').on('change', function() {
        let loanType = $(this).val();
        if (loanType == 'step-up' ||
            loanType == 'grace_step-up_with_capitalization' ||
            loanType == 'grace_step-up_without_capitalization'
        ) {
            $('#step_up_rate').closest('.item-main-parent').fadeIn(300);
            $('#step_up_interval').closest('.item-main-parent').fadeIn(300);
        } else {

            $('#step_up_rate').val(0).closest('.item-main-parent').fadeOut(300);
            $('#step_up_interval').val(0).closest('.item-main-parent').fadeOut(300);
        }


        if (loanType == 'step-down' ||
            loanType == 'grace_step-down_with_capitalization' ||
            loanType == 'grace_step-down_without_capitalization'

        ) {
            $('#step_down_rate').closest('.item-main-parent').fadeIn(300);
            $('#step_down_interval').closest('.item-main-parent').fadeIn(300);
        } else {

            $('#step_down_rate').val(0).closest('.item-main-parent').fadeOut(300);
            $('#step_down_rate').val(0).trigger('change');
            $('#step_down_interval').val(0).closest('.item-main-parent').fadeOut(300);
        }

        if (loanType != 'normal' && loanType != 'step-down' && loanType != 'step-up') {
            $('#grace_periodid').closest('.item-main-parent').fadeIn(300);
            $('#capitalization_type').val(0).closest('.item-main-parent').fadeIn(300);
            if (loanType == 'grace_step-up_with_capitalization' || loanType == 'grace_period_with_capitalization' ||
                loanType == 'grace_step-down_with_capitalization'

            ) {
                $('#capitalization_type').find('option:nth-child(1)').prop('selected', true);

            } else {
                $('#capitalization_type').find('option:nth-child(2)').prop('selected', true);
            }
        } else {
            $('#grace_periodid').closest('.item-main-parent').fadeOut(300);
            $('#capitalization_type').closest('.item-main-parent').fadeOut(300);
        }


    }).trigger('change')


    $(document).on('keyup', '.pricing-calc-item', function() {
        let base_rate = $('#base_rate').val();
        let margin_rate = $('#margin_rate').val();
        if (isPercentageNumber(base_rate) && isPercentageNumber(margin_rate)) {
            let pricing = parseFloat(base_rate) + parseFloat(margin_rate);
            $('#pricing').val(pricing);
        } else if (isPercentageNumber(base_rate)) {
            let pricing = parseFloat(base_rate);
            $('#pricing').val(pricing);
        } else if (isPercentageNumber(margin_rate)) {
            let pricing = parseFloat(margin_rate);
            $('#pricing').val(pricing);
        } else {
            $('#pricing').val(0);
        }

    })

    $(document).on('keyup', '.grace_period_calc', function() {
        let duration = parseFloat($('#duration').val());
        let gracePeriod = parseFloat($('#grace_periodid').val()) ? parseFloat($('#grace_periodid').val()) : 0;
        if (gracePeriod != 0 && gracePeriod >= duration - 1) {
            $('#grace_periodid').val(duration - 2);
        }
    });
    // $('#fixed_loan_type')

</script>


<script>
    $(document).on('click', '.submit', function(e) {

        e.preventDefault();
        let visiableFields = getVisiablFields();
        if (!visiableFields.length && visiableFields.emptyFields.length) {
            alert("please Enter " + visiableFields.emptyFields[0].name)
            return;
        }

        let fixedType = $('#fixed_loan_type').val();

        let start_date = $('#start-date').val();

        let step_up = $('#step_up_interval').val();

        let step_down = $('#step_down_interval').val();
        let stepRate = (fixedType == 'step-up' || fixedType == 'grace_step-up_with_capitalization' ||
            fixedType == 'grace_step-up_without_capitalization'

        ) ? parseFloat($('#step_up_rate').val()) : (
            (fixedType == 'step-down' || fixedType == 'grace_step-down_with_capitalization' ||
                fixedType == 'grace_step-down_without_capitalization'

            )
        ) ? parseFloat($('#step_down_rate').val()) : 0;
        stepRate = stepRate / 100;

        let applied_step =
            (fixedType == 'step-up' || fixedType == 'grace_step-up_with_capitalization' ||
                fixedType == 'grace_step-up_without_capitalization'

            ) ? step_up : (
                (fixedType == 'step-down' || fixedType == 'grace_step-down_with_capitalization' ||
                    fixedType == 'grace_step-down_without_capitalization'

                )
            ) ? step_down : 0

        let period = parseFloat($('#duration').val());
        let start_date_formatted = new Date(start_date);
        let end_date_end = addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0));

        let end_date_formatted = addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0)).getFullYear() + '-' + (addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0)).getMonth() + 1) + '-' + addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0)).getDate();
        let interval = 0;
        let installment_interval = $('#installment_interval').val();
        let loanAmount = parseFloat($('#loan_amount').val())
        let gracePeriod = parseFloat($('#grace_periodid').val()) ? parseFloat($('#grace_periodid').val()) : 0;
        if ($('#store-by-ajax').length) {
            let base_rate = $('#base_rate').val();
            let margin_rate = $('#margin_rate').val();
            $.ajax({
                url: "<?php echo e(route('save.fixed.at.end',['company'=>$company->id])); ?>"
                , data: {
                    "_token": "<?php echo e(__(csrf_token())); ?>"
                    , 'gracePeriod': gracePeriod
                    , 'loanAmount': loanAmount
                    , 'installment_interval': installment_interval
                    , 'start_date': start_date
                    , 'end_date': end_date_formatted
                    , "period": period
                    , "applied_step": applied_step
                    , "stepRate": stepRate
                    , "fixedType": fixedType
                    , "step_down": step_down
                    , "step_up": step_up
                    , "step_down_rate": $('#step_down_rate').val()
                    , "step_up_rate": $('#step_up_rate').val()
                    , 'base_rate': base_rate
                    , 'margin_rate': margin_rate
                    , 'margin_interest': $('#margin_interest').val()
                    , 'pricing': $('#pricing').val()
                    , 'duration': $('#duration').val()
                    , 'step_up_interval': $('#step_up_interval').val()
                    , 'loan_interest': $('#loan_interest').val()
                    , 'min_interest': $('#min_interest').val()
                    , 'repayment_duration': $('#repayment_duration').val()
                    , 'installment_amount': $('#installment_amount').val()
                    , "loanType": $('#loanTypeId').val()
                    , 'company_id': "<?php echo e($company->id); ?>"
                    , 'financial_id': $('input[name="financial_id"]').val()
                    , 'long_term_funding_id': $('input[name="long_term_funding_id"]').val()
                , }
                , type: "POST"
                , success: function(res) {

                    $.ajax({
                        url: "<?php echo e(route('save.loan.dates',['company'=>$company->id])); ?>"
                        , data: {
                            "_token": "<?php echo e(csrf_token()); ?>"
                            , "data": window['dataToAjax']
                            , "loan_id": res.loan_id,

                        }
                        , type: "POST"
                    , })


                    // saveToalForLoan()
                }
            })
        }


        if (installment_interval) {
            switch (installment_interval) {
                case 'monthly':
                    installment_payment_interval = 1;
                    break;

                case 'quartly':
                    installment_payment_interval = 3;
                    break;

                case 'semi annually':
                    installment_payment_interval = 6;
                    break;


            }



        }
        switch (applied_step) {
            case 'quartly':
                interval = 3;
                break;

            case 'semi annually':
                interval = 6;
                break;

            case 'annually':
                interval = 12;
                break;

            default:
                interval = 1;
                break;
        }
        // alert(interval);

        let installmentStartDate = getInstallmentStartDate(new Date(start_date_formatted.getTime()), gracePeriod, installment_payment_interval);
        let stepFactor = calcStepFactor(period, interval, new Date(installmentStartDate.getTime()), addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0))); // object

        let daysCount = calDaysCount(new Date(start_date_formatted.getTime()), period, installment_payment_interval);

        let pricing = parseFloat($('#pricing').val()) / 100
        let intersetFactor = calcIntersetFactor(daysCount, pricing);

        let loanFactories = calcLoanFactor(fixedType, loanAmount, intersetFactor, gracePeriod, installment_payment_interval, new Date(start_date_formatted.getTime()), period
            , addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0))

        );

        let installmentFactories = calcInstallmentFactor(new Date(installmentStartDate.getTime()), intersetFactor, stepRate, stepFactor, period, installment_payment_interval);
        let installmentAmountArr = getInstallmentAmount(loanFactories, installmentFactories, stepRate, stepFactor, new Date(installmentStartDate.getTime()), addMonths(new Date(start_date_formatted.getTime()), (period ? period : 0))
            , period, installment_payment_interval, interval);

        let FormattedData = {
            ...daysCount
            , ...intersetFactor
            , ...installmentAmountArr
        };
        let newDat = [];
        for (index in FormattedData.daysCount) {
            newDate = FormattedData.daysCount[index].date;
            obj = {};
            obj.date = newDate;
            var searchedDaysCount = FormattedData.daysCount.find((item) => {
                return item.date == getDateFormatted(new Date(FormattedData.daysCount[index].date))
            });

            var searchedInstallmentAmount = FormattedData.InstallmentAmountArr.find((item) => {
                return item.date == getDateFormatted(new Date(FormattedData.daysCount[index].date))
            });
            var searchedIntersetFactor = FormattedData.interestFactor.find((item) => {
                return item.date == getDateFormatted(new Date(FormattedData.daysCount[index].date))
            });
            obj.val = {
                "daysCount": searchedDaysCount.daysDiff
                , "InstallmentAmount": searchedInstallmentAmount ? searchedInstallmentAmount.amount : 0
                , "interestFactor": searchedIntersetFactor ? searchedIntersetFactor.interestFactor : 0
            };

            newDat.push(obj);
        }
        formatTable(newDat, loanAmount, fixedType);
    })

    function calcIntersetFactor(daysCount, pricing) {
        intersetFactor = [];
        for (let i = 0; i < daysCount.daysCount.length; i++) {
            interset = (pricing / 360) * (daysCount.daysCount[i].daysDiff);
            obj = {};
            obj.date = daysCount.daysCount[i].date;
            obj.interestFactor = interset;
            intersetFactor.push(obj);

        }

        return {
            "interestFactor": intersetFactor
        };
    }

    function calDaysCount(start_date, interval, installment_payment_interval) {
        days = [];

        obj = {};
        obj.date = getDateFormatted(new Date(start_date.getTime()));
        obj.daysDiff = 0;
        days.push(obj);
        for (let i = 0; i < interval; i = i + installment_payment_interval) {
            firstMonth = new Date(start_date.getTime());
            let secondMonth = addMonths(start_date, installment_payment_interval);
            let diffInDays = getDifferenceBetweenTwoDatesInDays(firstMonth, secondMonth);

            obj = {};
            obj.date = getDateFormatted(new Date(secondMonth.getTime()));
            obj.daysDiff = diffInDays;
            days.push(obj);

            start_date = new Date(secondMonth.getTime());


        }

        return {
            "daysCount": days
        };
    }

    function addMonths(date, months) {

        let currentDate = parseInt($('#start-date').val().split('-')[2]);

        let newDate = date.addMonths(months);
        if (false) {

        } else if (currentDate <= 30) {
            if (newDate.getMonth() == 01) // feb
            {
                if (currentDate <= 28) {
                    return new Date(newDate.setDate(currentDate));
                } else {
                    return new Date(newDate.setDate(new Date(newDate.getFullYear(), newDate.getMonth() + 1, 0).getDate()));
                }
            } else {
                return new Date(newDate.setDate(
                    currentDate
                ));
            }

        } else {
            return new Date(newDate.setDate(new Date(newDate.getFullYear(), newDate.getMonth() + 1, 0).getDate()));

        }


        let formDate = $('#start-date').val();
        let formDay = parseFloat(formDate.split('-')[2]);
        let formMonth = parseFloat(formDate.split('-')[1])
        if (formDay == 31) {

            day = (new Date(date.getFullYear(), date.getMonth() + months, 0)).getDate();
            currentMonth = (new Date(date.getFullYear(), date.getMonth() + months, 0)).getMonth() + 1;
            currentYear = (new Date(date.getFullYear(), date.getMonth() + months, 0)).getFullYear();
            return new Date(currentYear + '-' + currentMonth + '-' + day);
        } else {
            date.setMonth(date.getMonth() + months);
        }

        return date;
    }

    function getDifferenceBetweenTwoDatesInDays(a, b) {
        const _MS_PER_DAY = 1000 * 60 * 60 * 24;
        // Discard the time and time-zone information.
        const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

        return Math.floor((utc2 - utc1) / _MS_PER_DAY);
    }

    function calcStepFactor(period, interval, installmentStartDate, end_date) {
        counter = 0;
        let stepFactor = [];

        for (let i = 0; i <= period; i++) {
            if (i % interval == 0 && i != 0) {
                counter = counter + 1;
            }

            obj = {};
            obj.date = getDateFormatted(addMonths(new Date(installmentStartDate.getTime()), i));
            obj.factory = counter;
            stepFactor.push(obj);

            if (end_date.getTime() == addMonths(new Date(installmentStartDate.getTime()), i).getTime()) {
                break;
            }

        }
        return {
            "stepFactors": stepFactor
        };

    }

    function calcLoanFactor(fixedLoanType, loanAmount, intersetFactor, gracePeriodVal, installment_payment_interval, start_date, interval, end_date_end) {
        // معامل القرض
        let gracePeriod = gracePeriodVal;

        if (fixedLoanType == 'grace_step-up_without_capitalization' || fixedLoanType == 'grace_step-down_without_capitalization' ||
            fixedLoanType == 'grace_period_without_capitalization'
        ) {
            loanFactorStartDate = addMonths(new Date(start_date.getTime()), installment_payment_interval + gracePeriod);
            var searchedInterestFactor = intersetFactor['interestFactor'].find((item) => {
                return item.date == getDateFormatted(loanFactorStartDate)
            });

            var loanFactor = loanAmount * (1 + searchedInterestFactor.interestFactor);

        } else {
            loanFactorStartDate = addMonths(new Date(start_date.getTime()), installment_payment_interval);
            var searchedInterestFactor = intersetFactor['interestFactor'].find((item) => {
                return item.date == getDateFormatted(loanFactorStartDate)
            });
            var loanFactor = loanAmount * (1 + searchedInterestFactor.interestFactor);
        }



        let loanFactoriesArr = [];

        obj = {};

        obj.date = getDateFormatted((new Date(start_date)));
        console.log('first', obj.date);
        obj.loanFactor = 0;
        loanFactoriesArr.push(obj);


        obj = {};
        obj.date = getDateFormatted((new Date(loanFactorStartDate)));
        console.log('second', obj.date);
        obj.loanFactor = loanFactor;
        loanFactoriesArr.push(obj);

        for (let i = 1; i <= (interval / installment_payment_interval); i++) {

            loopDate = addMonths(loanFactorStartDate, installment_payment_interval);
            searchedInterestFactor = intersetFactor['interestFactor'].find((item) => {
                return item.date == getDateFormatted(loopDate)
            });


            loanFactor = loanFactor + (loanFactor * searchedInterestFactor.interestFactor)


            obj = {};
            obj.date = getDateFormatted(new Date(loopDate.getTime()));
            obj.loanFactor = loanFactor;
            loanFactoriesArr.push(obj);

            if (end_date_end.getTime() == loopDate.getTime()) {
                break;
            }

        }
        return {
            "loanFactories": loanFactoriesArr
        };

    }

    function getInstallmentStartDate(loanStartDate, gracePeriod, installment_payment_interval) {

        let installmentDate = addMonths(loanStartDate, gracePeriod + installment_payment_interval);
        return installmentDate;
    }

    function getDateFormatted(yourDate) {
        const offset = yourDate.getTimezoneOffset()
        yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000))
        return yourDate.toISOString().split('T')[0]
    }

    function calcInstallmentFactor(installmentStartDate, intersetFactor, stepRate, stepFactor, interval, installment_payment_interval) {
        let firstInstallmentStartDate = installmentStartDate;
        installmentFactors = [];
        installmentFactor = -1;

        obj = {};
        obj.date = getDateFormatted(new Date(installmentStartDate.getTime()));
        obj.installmentFactor = -1;
        installmentFactors.push(obj);

        for (let i = 1; i <= interval / installment_payment_interval; i++) {
            loopDate = addMonths(installmentStartDate, installment_payment_interval);

            searchedInterestFactor = intersetFactor['interestFactor'].find((item) => {
                return item.date == getDateFormatted(loopDate)
            });

            stepFactorOfDate = stepFactor['stepFactors'].find((item) => {
                return item.date == getDateFormatted(loopDate)
            });

            if (!searchedInterestFactor) {
                break;
            } else {
                installmentFactor = installmentFactor + (installmentFactor * searchedInterestFactor.interestFactor) - (1 * parseFloat(Math.pow((1 + parseFloat(stepRate)), parseFloat(stepFactorOfDate.factory))))
                obj = {};
                obj.date = getDateFormatted(new Date(loopDate.getTime()));
                obj.installmentFactor = installmentFactor;
                installmentFactors.push(obj);
            }


        }

        return {
            "installmentFactors": installmentFactors
        };




    }


    function getInstallmentAmount(loanFactor, InstallmentFactor, stepRate, stepFactor, installmentStartDate, end_date, period, installment_payment_interval, interval) {
        // let end_date_formatted = end_date;
        installmentsAmounts = [];

        loanFactoryAtEndDate = loanFactor['loanFactories'].find((item) => {
            return item.date == getDateFormatted(end_date)
        });


        installmentFactorAtEndDate = InstallmentFactor['installmentFactors'].find((item) => {
            return item.date == getDateFormatted(end_date)
        });

        installmentAmount = loanFactoryAtEndDate.loanFactor / (installmentFactorAtEndDate.installmentFactor * -1);
        obj = {};
        obj.date = getDateFormatted(installmentStartDate);
        obj.amount = installmentAmount;
        installmentsAmounts.push(obj);

        for (let i = 1; i <= (period / installment_payment_interval); i++) {

            loopDate = addMonths(installmentStartDate, installment_payment_interval);

            stepFactorOfDate = stepFactor['stepFactors'].find((item) => {
                return item.date == getDateFormatted(loopDate)
            });

            if (!stepFactorOfDate) {
                break
            } else {
                if ((i % (interval / installment_payment_interval)) == 0 && i != 0) {
                    installmentAmount = installmentAmount * (parseFloat(Math.pow((1 + parseFloat(stepRate)), 1)))
                } else {
                    installmentAmount = installmentAmount
                }

                obj = {};
                obj.date = getDateFormatted(new Date(loopDate.getTime()));
                obj.amount = installmentAmount;
                installmentsAmounts.push(obj);

            }
        }
        return {
            "InstallmentAmountArr": installmentsAmounts
        };





    }

    function formatTable(data, loanAmount, loanType) {
        table = `<table class='table table-striped table-bordered table-hover table-checkable' id="dynamic-datatable">
        <thead>
             <tr>
                            <th class="text-center"><?php echo e(__("Payment No.")); ?></th>
                            <th class="text-center"><?php echo e(__("Date")); ?></th>
                            <th class="text-center"><?php echo e(__("Days Count")); ?></th>
                            <th class="text-center"><?php echo e(__("Interest Factor")); ?></th>
                            <th class="text-center"><?php echo e(__("Begining Balance")); ?></th>
                            <th class="text-center"><?php echo e(__("Schedule Payment")); ?></th>
                            <th class="text-center"><?php echo e(__("Interest Amount")); ?></th>
                            <th class="text-center"><?php echo e(__("Principle Amount")); ?></th>
                            <th class="text-center"><?php echo e(__("End Balance")); ?></th>
                          
                        </tr>
        </thead>    

        <tbody> `;

        // return 
        let order = 0;
        totalPrincpleAmount = 0;
        totalSchedulePayment = 0;
        totalInterestAmount = 0;
        let dataToAjax = [];
        for (let i = 0; i < data.length; i++) {
            table += `<tr>
            <td>
                ${ order++ }
            </td>
            <td>
            ${formatDate(new Date(data[i].date))}
            </td>            

            <td>
                ${data[i].val.daysCount}
            </td>    
			<td>
                ${data[i].val.interestFactor}
            </td>
			
			`
            i == 0 ? (Begining = loanAmount) : Begining = endBalance;

            intresetAmount = Begining * data[i].val.interestFactor;
            totalInterestAmount += intresetAmount

            table += `
            
            <td> 
            
            
            `;
            table += `
               ${numberFormat(Begining)}
            </td>
            <td>`
            let withoutCapitalization = loanType.split('_').includes('without') && loanType.split('_').includes('capitalization')

            schedulePayment = (withoutCapitalization) && data[i].val.InstallmentAmount == 0 ? intresetAmount : data[i].val.InstallmentAmount;
            totalSchedulePayment = totalSchedulePayment + schedulePayment
            table +=

                `
                ${ number_format(schedulePayment,2)}
            </td>
           `;


            table +=
                `
            <td>
            
            ${number_format(intresetAmount,2)}
            </td>
            <td> `;
            // alert(schedulePayment)
            // alert(intresetAmount)
            principleAmout = parseFloat(schedulePayment) - intresetAmount;

            // principleAmout = data[i].val.InstallmentAmount - intresetAmount ;
            totalPrincpleAmount = totalPrincpleAmount + principleAmout;
            table +=
                `
                ${(number_format(principleAmout,2)) }
            </td>

            <td>`;
            endBalance = Begining + intresetAmount - schedulePayment;
            dataToAjax.push({
                'date': formatDate(new Date(data[i].date))
                , 'beginningBalance': Begining
                , 'principle': principleAmout
                , 'endBalance': endBalance
                , 'new_interest_amount': intresetAmount
                , 'financial_id': $('input[name="financial_id"]').val()
            });

            table += ` 
            ${ numberFormat(endBalance) == '-0' ? 0 : numberFormat(endBalance) } 
            </td>
            </tr>`
        }
        window['dataToAjax'] = dataToAjax;

        table += `
        <tr class="custom-color-for-last-tr">
        <th>
        
        <?php echo e(__('Total')); ?>

        </th>
        <th>
        -
        </th>

        <th>
        -
        </th>
 <th>
        -
        </th>

        <th>
        -
        </th>


                <th>
        
        ${number_format(totalSchedulePayment,2)}
        
        </th>
        <th>
        ${number_format(totalInterestAmount,2)}
        </th>

        <th>
        ${number_format(totalPrincpleAmount,2)}
        </th>

        <th>

        -
        
        </th>


        </tr> `

        table +=

            `</tbody>
        </table>
        
        
        `;



        $('#append-table-id').empty().append(table);

        $('#dynamic-datatable').DataTable({
            paginate: false
            , searching: false
            , ordering: false
            , fixedHeader: {
                header: true
                , footer: false
                , headerOffset: 78
            }
            , dom: 'Bfrtip'
            , buttons: ['copy', 'csv', {
                "extend": "excel"
                , title: ''
                , filename: 'Fixed Payments At The End'
                , customize: function(xlsx) {

                    exportToExcel(xlsx)

                }
            }, 'pdf', 'print']
        });




    }

    function formatDate(d) {
        return ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" +
            d.getFullYear()
    }

    function numberFormat(number) {
        // num = number.toFixed();
        return number.toLocaleString('en-US').split('.')[0]
    }

    $(document).on('keyup', '.negative-numbers', function(e) {
        let val = $(this).val();

        var re = /^-?\d*\.?\d{0,6}$/;
        var text = $(this).val();

        var isValid = (text.match(re) !== null);

        if (!isValid || val > 0) {
            $(this).val(0);
        }
    })

</script>

<script>
    $('.max-tenor-limit').on('keyup', function() {
        let val = parseFloat($(this).val());
        if (val > 420) {
            $(this).val(420).trigger('change')
        }
    })
    // $('#gracePeriodId')

</script>




<script>
    $('#installment_interval').on('change', function() {
        let selectedOption = $(this).find('option:selected').data('order');
        $('#step_up_interval').find('option').each(function(index, opt) {
            if ($(opt).data('order') < selectedOption) {
                $(opt).prop('disabled', true);
                $(opt).css('display', 'none');
            } else {
                $(opt).prop('disabled', false);
                $(opt).css('display', 'initial');

            }
        });



        $('#step_down_interval').find('option').each(function(index, opt) {
            if ($(opt).data('order') < selectedOption) {
                $(opt).prop('disabled', true);
                $(opt).css('display', 'none');
            } else {
                $(opt).prop('disabled', false);
                $(opt).css('display', 'initial');

            }
        });
        if (!$('#step_up_interval').find('option:nth-child(4):selected').length) {
            if (!$('#page-is-loading').length) {
                $('#step_up_interval').find('option:nth-child(1)').prop('selected', 1);

            }
        }

        if (!$('#step_down_interval').find('option:nth-child(4):selected').length) {
            if (!$('#page-is-loading').length) {
                $('#step_down_interval').find('option:nth-child(1)').prop('selected', 1);
            }
        }

        $('#page-is-loading').remove();
    }).trigger('change');

</script>
<script>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" type="text/javascript">

</script>
<script>


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/admin/loan2/test-loan-php.blade.php ENDPATH**/ ?>