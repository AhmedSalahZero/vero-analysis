@extends('layouts.dashboard')
@section('css')
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('SECTIONS')}}
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <?php $row = isset($companySection) ? $companySection : old(); ?>

        <form class="kt-form kt-form--label-right" method="POST" action=@if (isset($company_row)) @if (isset($companySection) ) {{ route('edit.admin.company',[$company_row,$companySection])}} @else {{ route('admin.company',$company_row)}} @endif @elseif (isset($companySection) ) {{route('companySection.update',$companySection)}} @else {{route('companySection.store')}} @endif enctype="multipart/form-data">
            @csrf
            {{isset($companySection) ?  method_field('PUT'): ""}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="form-group row col-12">
                        @foreach ($langs as $lang_row)
                        <div class="col-6">
                            <label>{{__('Company Name ') . $lang_row->name}} @include('star')</label>
                            <div class="kt-input-icon">
                                <input type="text" name="name[{{$lang_row->code}}]" value="{{@$row['name'][$lang_row->code]}}" class="form-control" placeholder="{{__('Company Name ') . $lang_row->name}}" required>
                                <x-tool-tip title="{{__('Kash Vero')}}" />
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Company Information')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">



                    <div class="form-group row col-12">
                        <div class="col-md-4">
                            <label>{{ __('Systems') }} <span class=""></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required id="role-id" name="systems[]" multiple data-live-search="true" data-actions-box="true" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select">
                                        @foreach(\App\Models\CompanySystem::getAllSystemNames() as $currentSystemName)
                                        <option value="{{ $currentSystemName }}" @if(in_array($currentSystemName,old('systems',[]))) selected @elseif(isset($companySection) && $companySection->hasSystem($currentSystemName) ) selected @endif >{{ str_to_upper($currentSystemName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <label>{{__('Main Functional Currency') . $lang_row->name}} @include('star')</label>
                            <div class="kt-input-icon">
                                <select name="main_functional_currency" class="form-control">
                                    @foreach(getCurrencies() as $currencyName => $currencyNameFormatted)
                                    <option value="{{ $currencyName  }}"> {{ $currencyNameFormatted }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <label>{{__('Company Image')}}</label>
                            <div class="kt-input-icon">
                                <input type="file" class="form-control" name="image">
                                <x-tool-tip title="{{__('Kash Vero')}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
			
			
			
			 <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Oddo Integration')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">



                    <div class="form-group row col-12">
                 

 					 <div class="col-3">
                            <label>{{__('Database URL')  }}</label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_url" value="{{@$row['oddo_db_url']}}" class="form-control" placeholder="{{__('Oddo  Database URL')}}" >
                            </div>
                        </div>
						  <div class="col-3">
                            <label>{{__('Database Name')  }}</label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_name" value="{{@$row['oddo_db_name']}}" class="form-control" placeholder="{{__('Oddo  Database Name')}}" >
                            </div>
                        </div>
                    <div class="col-3">
                            <label>{{__('User Name')  }}</label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_username" value="{{@$row['oddo_username']}}" class="form-control" placeholder="{{__('Oddo  User Name')}}" >
                            </div>
                        </div>
						
						 
						
						<div class="col-3">
                            <label>{{__('Password')  }}</label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_password" value="{{@$row['oddo_db_password']}}" class="form-control" placeholder="{{__('Oddo  Database Password')}}" >
                            </div>
                        </div>
						

                       
                    </div>
                </div>
            </div>
			
            <x-submitting />
        </form>

        <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>
@endsection
@section('js')
<!--begin::Page Scripts(used by this page) -->
<script src="{{url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
<script>
    $('.company_type').change(function() {
        val = $(this).val();
        if (val == 'single') {
            $('#num_of_companies').addClass('hidden');
            $('.num_of_companies').val('');
        } else {
            $('#num_of_companies').removeClass('hidden');
        }
    });

</script>
<!--end::Page Scripts -->
@endsection
