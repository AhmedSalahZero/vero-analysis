     <?php if($subSection->route != null && count($subSection->subSections) == 0): ?>
                                                    <?php
                                                    $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                    ?>
                                                        <?php if($subSection->id == 222 || $subSection->id == 223 || $subSection->id == 224 || $subSection->id == 225 || $subSection->id == 226): ?>
                                                            <?php
                                                                $show_route = 0 ;
                                                                $modified_seasonality =  App\Models\ModifiedSeasonality::where('company_id', $company->id)->first();
                                                                if (($subSection->id == 222 || $subSection->id == 226) && isset($modified_seasonality)  ) {
                                                                    $show_route = 1 ;
                                                                }
                                                                elseif ($subSection->id == 223 && isset($modified_seasonality) &&
                                                                (( App\Models\ExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 224) && isset($modified_seasonality) &&
                                                                ((App\Models\SecondExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 225  ) && isset($modified_seasonality) &&
                                                                ((App\Models\CollectionSetting::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }else {
                                                                    $show_route = 0;
                                                                }
                                                            ?>


                                                            <?php if($show_route == 1): ?>
                                                                <li class="kt-menu__item " aria-haspopup="true">
                                                                    <a href="<?php echo e(@$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company)); ?>"
                                                                        class="kt-menu__link "><i
                                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                            class="kt-menu__link-text"><?php echo e(__($subSection->name[$lang])); ?></span></a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php else: ?>


                                                            <li class="kt-menu__item " aria-haspopup="true">
                                                                <a href="<?php echo e(@$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company)); ?>"
                                                                    class="kt-menu__link "><i
                                                                        class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                        class="kt-menu__link-text"><?php echo e(__($subSection->name[$lang])); ?></span></a>
                                                            </li>

                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php
                                                        $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                        ?>

                                                        <li class="kt-menu__item " aria-haspopup="true">
                                                            <a href="<?php echo e(@$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company)); ?>"
                                                                class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text"><?php echo e(__($subSection->name[$lang])); ?></span></a>
                                                        </li>
                                                 
                                                    <?php endif; ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/print_sections.blade.php ENDPATH**/ ?>