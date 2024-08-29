<div class="btn-group button-space mr-3">
    <button type="button" class="btn btn-outline-success">
        <?php echo e(__('Add Debit Accounts')); ?>

    </button>
    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(141px, 36px, 0px);">
        
        
        <a class="dropdown-item" href="<?php echo e(route('financial.institution.add.account',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Add Current Account')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Certificate Of Deposit "CDs"')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Time Deposit "TDs"')); ?></a>

    </div>
</div>

<div class="btn-group">


    <button type="button" class="btn btn-outline-danger">
        <?php echo e(__('Add Credit Facilities')); ?>

    </button>

    <button type="button" class="btn btn-outline-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only"><?php echo e(__('Toggle Dropdown')); ?></span>
    </button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(141px, 36px, 0px);">
        <a class="dropdown-item" href="<?php echo e(route('view.fully.secured.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Fully Secured Overdraft')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.clean.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Clean Overdraft')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Overdraft Aganist Commercial Papers')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Overdraft Aganist Contracts Assignment')); ?></a>
        
        <a class="dropdown-item" href="<?php echo e(route('view.letter.of.guarantee.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Letter Of Guarantee')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('view.letter.of.credit.facility',['company'=>$company->id ,'financialInstitution'=>$financialInstitutionBank->id])); ?>"><?php echo e(__('Letter Of Credit')); ?></a>
        <a class="dropdown-item" href="<?php echo e(route('loans.index',['company'=>$company->id , 'financialInstitution'=>$financialInstitutionBank->id ])); ?>"><?php echo e(__('Medium Term Loans')); ?></a>
        

    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/financial-institution/dropdown-actions.blade.php ENDPATH**/ ?>