@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
    .kt-portlet {
        overflow: visible !important;
    }
input.form-control[disabled] {
            background-color: #CCE2FD !important;
            font-weight: bold !important;
        }
</style>
@endsection
@section('sub-header')
{{ __('Money Received Form') }}
@endsection
@section('content')

 <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1" role="tab">
                            <i class="fa fa-money-check-alt"></i> Cheques Received Table
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                            <i class="fa fa-money-check-alt"></i>Incoming Transfer Table
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_3" role="tab">
                            <i class="fa fa-money-check-alt"></i>Cash Received Table
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content  kt-margin-t-20">

                <!--Begin:: Tab Content-->
                <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    {{ __('Cheques Received Table') }}
                                </h3>
                            </div>
                            {{-- Export --}}
                            <x-export href="{{route('create.money.receive',['company'=>$company->id])}}"/>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                                <thead>
                                    <tr class="table-standard-color">
                                        <th>{{ __('Customer Name') }}</th>
                                        <th>{{ __('Invoice/Contract') }}</th>
                                        <th>{{ __('Receiving Date') }}</th>
                                        <th>{{ __('Cheque Number') }}</th>
                                        <th>{{ __('Cheque Amount') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        <th>{{ __('Drawee Bank') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Due After Days') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Control') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Customer A</td>
                                        <td>COD2025</td>
                                        <td>10-March-2021</td>
                                        <td>202156</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>30-June-2021</td>
                                        <td>80</td>
                                        <td>In Safe</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Status Update" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer B</td>
                                        <td>COD2025</td>
                                        <td>10-March-2021</td>
                                        <td>202156</td>
                                        <td>2,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>30-June-2021</td>
                                        <td>80</td>
                                        <td>Under Collection</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Status Update" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer C</td>
                                        <td>COD2025</td>
                                        <td>10-March-2021</td>
                                        <td>202156</td>
                                        <td>4,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>30-June-2021</td>
                                        <td>80</td>
                                        <td>Discounted</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Status Update" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer D</td>
                                        <td>COD2025</td>
                                        <td>10-March-2021</td>
                                        <td>202156</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>30-June-2021</td>
                                        <td>80</td>
                                        <td>Collected</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Status Update" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer A</td>
                                        <td>COD2025</td>
                                        <td>10-March-2021</td>
                                        <td>202156</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>30-June-2021</td>
                                        <td>80</td>
                                        <td>Rejected</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Status Update" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <!--End:: Tab Content-->

                <!--Begin:: Tab Content-->
                <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    {{ __('Incoming Transfer Table') }}
                                </h3>
                            </div>
                            {{-- Export --}}
                            <x-export href="{{route('create.money.receive',['company'=>$company->id])}}"/>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                                <thead>
                                    <tr class="table-standard-color">
                                        <th>{{ __('Beneficiary Name') }}</th>
                                        <th>{{ __('Invoice/Contract') }}</th>
                                        <th>{{ __('Receiving Date') }}</th>
                                        <th>{{ __('Receiving Bank') }}</th>
                                        <th>{{ __('Transfer Amount') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        <th>{{ __('Payment Bank') }}</th>
                                        <th>{{ __('Due After Days') }}</th>
                                        <th>{{ __('Sub-account Number') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Control') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Customer A</td>
                                        <td>COD2025</td>
                                        <td>30-March-2021</td>
                                        <td>AAIB</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>20</td>
                                        <td>1112485</td>
                                        <td>Not Received Yet</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer B</td>
                                        <td>COD2025</td>
                                        <td>30-Jan-2021</td>
                                        <td>AAIB</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>--</td>
                                        <td>1112485</td>
                                        <td>Recevied</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer A</td>
                                        <td>COD2025</td>
                                        <td>30-March-2021</td>
                                        <td>AAIB</td>
                                        <td>1,250,000</td>
                                        <td>EGP</td>
                                        <td>HSBC</td>
                                        <td>20</td>
                                        <td>1112485</td>
                                        <td>Not Received Yet</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>

                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>

                <!--End:: Tab Content-->


                <!--Begin:: Tab Content-->
                <div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    {{ __('Cash Received Table') }}
                                </h3>
                            </div>
                            {{-- Export --}}
                            <x-export href="{{route('create.money.receive',['company'=>$company->id])}}"/>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                                <thead>
                                    <tr class="table-standard-color">
                                        <th>{{ __('Customer Name') }}</th>
                                        <th>{{ __('Invoice/Contract') }}</th>
                                        <th>{{ __('Receiving Date') }}</th>
                                        <th>{{ __('Branch') }}</th>
                                        <th>{{ __('Received Amount') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        <th>{{ __('Receipt Number') }}</th>
                                        <th>{{ __('Control') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Customer A</td>
                                        <td>COD2025</td>
                                        <td>15-Feb-2021</td>
                                        <td>Cairo</td>
                                        <td>50,000</td>
                                        <td>EGP</td>
                                        <td>03065</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer B</td>
                                        <td>COD2025</td>
                                        <td>15-Feb-2021</td>
                                        <td>Alex</td>
                                        <td>5,000</td>
                                        <td>EGP</td>
                                        <td>03065</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer C</td>
                                        <td>COD2025</td>
                                        <td>15-Feb-2021</td>
                                        <td>Cairo</td>
                                        <td>10,000</td>
                                        <td>EGP</td>
                                        <td>03065</td>
                                        <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                            data-autohide-disabled="false">
                                            <span style="overflow: visible; position: relative; width: 110px;">
                                                <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href=""><i class="fa fa-pen-alt"></i></a>
                                                {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" title="Renew" href=""><i class="fa fa-sync-alt"></i></a> --}}
                                                <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></a>
                                            </span>
                                        </td>
                                    </tr>




                                </tbody>
                            </table>

                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>

                <!--End:: Tab Content-->
            </div>
        </div>
    </div>
	
@endsection
@section('js')
<!--begin::Page Scripts(used by this page) -->
<script src="{{ url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
<script>

</script>
<script>
    $('#money_type').change(function() {
        selected = $(this).val();
        if (selected == 'cash') {
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
            $('#cash').removeClass('hidden');
        } else if (selected == 'cheques') {
            $('#incoming_transfer').addClass('hidden');
            $('#cash').addClass('hidden');
            $('#cheques').removeClass('hidden');
        } else if (selected == 'incoming_transfer') {
            $('#cash').addClass('hidden');
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').removeClass('hidden');
        } else if (selected == '') {
            $('#cash').addClass('hidden');
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
        }

    });
    $('#money_type').trigger('change')

</script>
<script src="/custom/money-receive.js">

</script>


{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}
@endsection
