 <td class="sub-text-bg text-center  <?php echo e(isset($excludeMaxWith) ? 'exclude-max-width' : ''); ?> text-nowrap "><?php echo e($invoice->getInvoiceDateFormatted()); ?></td>

                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getInvoiceNumber()); ?></td>
										<?php if(isset($showInvoiceCurrency) && $showInvoiceCurrency): ?>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getCurrency()); ?></td>
										<?php endif; ?>
                                        <td class="sub-text-bg text-center  text-nowrap ">
                                            <?php echo e($invoice->getNetInvoiceAmountFormatted()); ?>

                                            <?php if($currency != $company->getMainFunctionalCurrency()): ?>
                                            <i data-toggle="modal" data-target="#net-invoice-amount-modal-<?php echo e($invoice->id); ?>" class="flaticon2-information fs-15 kt-font-primary exclude-icon ml-2 cursor-pointer "></i>
                                            <div class="modal fade " id="net-invoice-amount-modal-<?php echo e($invoice->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-left" id="exampleModalLabel">
                                                                <?php echo e(__('Invoice Number #' . $invoice->getInvoiceNumber()  )); ?> <br>
                                                                <?php echo e(__('Dated') . ' ' . $invoice->getInvoiceDate()); ?>

                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <table class="table table-bordered ">
                                                                <thead>
                                                                    <th style="border-left:2px solid #ebedf2"><?php echo e(__('Item')); ?></th>
                                                                    <th><?php echo e(__('Value')); ?></th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left"><?php echo e(__('Amount In Main Currency')); ?></td>
                                                                        <td><?php echo e(number_format($invoice->getNetInvoiceInMainCurrencyAmount(),2)); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left"><?php echo e(__('Exchange Rate')); ?></td>
                                                                        <td><?php echo e(number_format($invoice->getExchangeRate(),4)); ?></td>
                                                                    </tr>

                                                                </tbody>

                                                            </table>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>


                                        </td>
										
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getWithholdAmountFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getTotalDeductionFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getTotalCollectedOrPaidFormatted()); ?></td>
                                        <td class="sub-text-bg text-center  text-nowrap "><?php echo e($invoice->getDueDateFormatted()); ?></td>
                                        <td class="sub-text-bg text-center text-nowrap"><?php echo e($invoice->getNetBalanceFormatted()); ?></td>
                                        <td class="sub-text-bg text-center text-wrap"><?php echo e($invoice->getStatusFormatted()); ?></td>
                                        <td class="sub-text-bg  text-center">
                                            <?php echo e($invoice->getAging()); ?>

                                        </td>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/invoice-report-td.blade.php ENDPATH**/ ?>