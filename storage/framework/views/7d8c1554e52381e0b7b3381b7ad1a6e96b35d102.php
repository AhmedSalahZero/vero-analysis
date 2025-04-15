   <th class="view-table-th <?php echo e(isset($excludeMaxWith) ? 'exclude-max-width' : ''); ?>  bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Date')); ?>

                                        </th>
										
<th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Number')); ?>

                                        </th>
										
										<?php if(isset($showInvoiceCurrency) && $showInvoiceCurrency): ?>
                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Currency')); ?>

                                        </th>
										<?php endif; ?> 
										

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Net Invoice Amount')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Withhold Amount')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Total Deductions')); ?>

                                        </th>
                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                        <?php echo e(__('Total Collections')); ?>

                                        </th>



                                        <th class="view-table-th   bg-lighter header-th  align-middle text-center">
                                            <?php echo e(__('Invoice Due Date')); ?>

                                        </th>



                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Net Balance')); ?>

                                        </th>

                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Status')); ?>

                                        </th>
                                        <th class="view-table-th   bg-lighter  header-th  align-middle text-center">
                                            <?php echo e(__('Aging')); ?>

                                        </th>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/invoice-report-th.blade.php ENDPATH**/ ?>