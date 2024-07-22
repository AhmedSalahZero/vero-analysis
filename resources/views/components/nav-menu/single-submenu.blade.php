                    @props([
                    'menuArr'
                    ])
					
                    @if($menuArr['show'])
                    <li @foreach(getAllDataKey($menuArr) as $k=>$v)
                        {{ $k.'='.$v }}
                        @endforeach

                        class="kt-menu__item " aria-haspopup="true"><a href="{{ $menuArr['link'] }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ $menuArr['title'] }}</span></a></li>
                    @endif
