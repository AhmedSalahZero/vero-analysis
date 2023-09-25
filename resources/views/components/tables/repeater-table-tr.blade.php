      @props([
      'model'=>$model ?? null,
	  'isRepeater'=>$isRepeater,
	  'tds'=>$tds
      ])
      @php
      
      $type = 'create';
      @endphp

      <tr @if($isRepeater) data-repeater-item @endif>
          <td class="text-center">
              <div class="">
                  <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                  </i>
              </div>
          </td>

		  {{ $tds }}
      </tr>
