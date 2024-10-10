 <form method="post" action="<?php echo e(isset($model) ? route('update.foreign.exchange.rate',['company'=>$company->id, 'foreignExchangeRate'=>$model->id]) :route('store.foreign.exchange.rate',['company'=>$company->id ])); ?>" class="kt-form kt-form--label-right">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($model)): ?>
                            <?php echo method_field('patch'); ?>
                            <?php endif; ?>
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title head-title text-primary">
                                            <?php echo e(__('Foreign Exchange Rates Section')); ?>

                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="form-group row">
                                        <div class="col-md-2 mb-4">
                                            <label><?php echo e(__('Date')); ?> </label>
                                            <input name="date" type="date" class="form-control" value="<?php echo e(now()->format('Y-m-d')); ?>" max="<?php echo e(now()->format('Y-m-d')); ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label><?php echo e(__('From Currency')); ?>

                                                <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </label>
                                            <div class="input-group">
                                                <select name="from_currency" id="from-currency" class="form-control js-change-currency">
                                                    
                                                    <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getFromCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'USD' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <label><?php echo e(__('To Currency')); ?>

                                                <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </label>
                                            <div class="input-group">
                                                <select name="to_currency" id="to-currency" class="form-control js-change-currency ">
                                                    
                                                    <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getToCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="" class="visibility-hidden">d</label>
                                            <input id="from-currency-input" type="text" value="1 <?php echo e($currentTab); ?> = " disabled class="form-control"> <span></span>
                                        </div>
                                        <div class="col-md-2 mb-4">
                                            <label><?php echo e(__('Exchange Rate')); ?> </label>
                                            <input name="exchange_rate" type="text" class="form-control only-greather-than-zero" value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>">
                                        </div>
                                        <div class="col-md-1">
                                            <label for="" class="visibility-hidden">d</label>
                                            <input id="to-currency-input" type="text" value="EGP" disabled class="form-control"> <span></span>
                                        </div>

                                        <div class="col-md-1">
                                            <label for="" class="visibility-hidden">d</label>
                                            <button type="submit" class="btn active-style save-form form-control"><?php echo e(__('Save')); ?></button>
                                        </div>


                                    </div>
                                </div>
                            </div>



                        </form>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/foreign-exchange-rate/_form.blade.php ENDPATH**/ ?>