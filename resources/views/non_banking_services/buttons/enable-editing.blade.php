 				@if($inEditMode)
					 <button  
					can-show-funding-structure="{{ $inEditMode  }}" id="toggleEditBtn" in-edit-mode="{{ $inEditMode }}" class="btn active-style ">
						 {{ __('Enable Edit') }}
					 </button>
					 @endif
