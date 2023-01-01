<ul class="kt-menu__nav ">
        {{-- <li class="kt-menu__item  kt-menu__item" aria-haspopup="true"><a href="{{ route('dashboard', $company) }}"
                class="kt-menu__link 
                @if($active == 'sales_dashboard')
                active-button
                @endif 
                
                "><span class="kt-menu__link-text 
                     @if($active == 'sales_dashboard')
                active-text
                    @endif 
                
                ">{{ __('Sales Dashboard') }}</span></a>
        </li> --}}
        <li class="kt-menu__item  kt-menu__item 
        
        @if($active == 'breadkdown_dashboard')
                active-button
                @endif 

        " aria-haspopup="true"><a href="{{ route('dashboard.breakdown.incomeStatement', $company) }}"
                class="kt-menu__link "><span class="kt-menu__link-text
                
                @if($active == 'breadkdown_dashboard')
                active-text
                    @endif 

                ">Breakdown Dashboard</span></a>
        </li>
        <li class="kt-menu__item  kt-menu__item 
          @if($active == 'interval_dashboard')
                   active-button
                    @endif 

        
        " aria-haspopup="true"><a href="{{ route('dashboard.intervalComparing', $company) }}"
                class="kt-menu__link 
                
                
                "><span class="kt-menu__link-text 
                
                
                  @if($active == 'interval_dashboard')
                   active-text
                    @endif 
                    ">{{__("Interval Comparing Dashboard")}}</span></a>
        </li>

    </ul>