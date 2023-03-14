@php
$tableId = 'kt_table_1';
@endphp
<style>
    .dt-buttons.btn-group {
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }

    td {
        color: black;
        font-weight: bold;
    }

    .btn-border-radius {
        border-radius: 10px !important;
    }

</style>
<div class="table-custom-container position-relative  ">

    <x-tables.basic-view class="position-relative  main-table-class" id="{{ $tableId }}">
        <x-slot name="filter">
            @include('admin.financial-statement.filter' , [
            'type'=>'filter'
            ])
        </x-slot>

        <x-slot name="export">
            @include('admin.financial-statement.export' , [
            'type'=>'export'
            ])
        </x-slot>


        <x-slot name="headerTr">
            <tr class="header-tr " data-model-name="{{ $modelName }}">
                @if($hasChildRows)
                {{-- <th class="view-table-th header-th trigger-child-row-1" >
                {{ __('Expand') }}
                </th> --}}
                @endif

                <th class="view-table-th header-th" data-db-column-name="id" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('#') }}
                </th>
                <th class="view-table-th header-th" data-db-column-name="name" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Name') }}
                </th>

                <th class="view-table-th header-th" data-db-column-name="duration" data-relation-name="" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Duration') }}
                </th>

                <th class="view-table-th header-th" data-db-column-name="duration_type" data-relation-name="" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Duration Type') }}
                </th>

                <th class="view-table-th header-th" data-db-column-name="start_from" data-relation-name="" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Start From') }}
                </th>



                {{-- <th class="view-table-th header-th" data-db-column-name="name" data-is-relation="1" data-relation-name="creator" class="header-th" data-is-json="0">
                    {{ __('Creator Name') }}
                </th>
                <th class="view-table-th header-th" data-db-column-name="created_at" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Created At') }}
                </th> --}}
                <th class="view-table-th" class="header-th">
                    {{ __('Income Statement') }}
                </th>
                <th class="view-table-th" class="header-th">
                    {{ __('Balance Sheet') }}
                </th>
                <th class="view-table-th" class="header-th">
                    {{ __('Cash Flow Statement') }}
                </th>
                <th class="view-table-th" class="header-th">
                    {{ __('Actions') }}
                </th>
            </tr>

        </x-slot>

        <x-slot name="js">
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    (function() {
                        // Add event listener for opening and closing details
                        $(document).on('click', '.trigger-child-row-1', function() {
                            var table = $(this).closest('table').DataTable();
                            var tr = $(this).closest('tr');

                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                // This row is already open - close it
                                row.child.hide();
                                tr.removeClass('shown');
                                $('#maintable-1-row-class' + row.data().id).closest('tbody').find('.subtable-1-class').DataTable().destroy();

                            } else {
                                modelName = 'ServiceCategory';
                                // Open this row
                                window['row_' + row.data().id] = row.data();
                                dd = formatsubrow1(row.data());
                                row.child(dd).show();
                                var data = [];
                                row.data().serviceCategories.forEach(function(item) {
                                    // do not change [1] index of item.id
                                    serviceCategoryId = item.id;
                                    mainRowId = row.data().id;
                                    data.push([mainRowId, serviceCategoryId, getExpandAndCollpaseIcon(), item.name, ` <a data-model-name="${modelName}" data-table-id="subtable-level-1-id" data-record-id="${serviceCategoryId}"   class="btn btn-sm btn-clean  delete-record-btn btn-icon btn-icon-md" title="{{ __('Delete') }}"><i class="la la-trash"></i></a>`])
                                })
                                $('#subtable-1-id' + row.data().id).DataTable({
                                    dom: 't'
                                    , "processing": false
                                    , "ordering": false
                                    , "serverSide": false
                                    , "responsive": true
                                    , "pageLength": 88888
                                    , createdRow: function(row, data, dataIndex, cells) {
                                        // $(row).addClass('subtable-1-row-class'+(data[0]));
                                        $(cells).filter(".editable").attr('contenteditable', true).attr('data-is-relation', 1)
                                            .attr('data-db-column-name', 'name').attr('data-relation-name', "serviceCategories")
                                            .attr('data-is-collection-relation', 1).attr('data-collection-item-id', data[1])
                                            .attr('data-model-name', 'RevenueBusinessLine').attr('data-model-id', data[0])
                                            .attr('data-table-id', "{{$tableId}}");
                                    }
                                    , columnDefs: [{
                                        target: [0, 1]
                                        , visible: false
                                    }]
                                    , columns: [
                                        null
                                        , null
                                        , null
                                        , {
                                            className: 'trigger-child-row-2'
                                        }
                                        , {
                                            className: 'editable'
                                        }
                                        , null
                                        , null
                                        , null
                                        , null
                                        , {
                                            className: 'second-subrow-last-td'
                                        }
                                    , ]
                                    , "data": data
                                , });
                                tr.addClass('shown');
                            }
                        })



                        function formatsubrow1(d) {
                            // `d` is the original data object for the row
                            let subtable = `<table id="subtable-1-id${d.id}" class="subtable-1-class table table-striped-  table-hover table-checkable position-relative dataTable no-footer dtr-inline" > <thead style="display:none"><tr><td></td> <td></td> <td></td> <td></td><td></td></tr> </thead> `;

                            subtable += '</table>';

                            return (subtable);
                        }

                        "use strict";
                        var KTDatatablesDataSourceAjaxServer = function() {

                            var initTable1 = function() {
                                var tableId = '#' + "{{ $tableId }}";

                                var table = $(tableId);
                                // begin first table
                                table.DataTable({


                                        dom: 'Bfrtip',
                                        // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        "ajax": {
                                            "url": "{{ $getDataRoute }}"
                                            , "type": "GET"
                                            , "dataSrc": "data", // they key in the jsom response from the server where we will get our data
                                            "data": function(d) {
                                                // tableId +'_filter'+ ' label input'
                                                d.search_input = $(getSearchInputSelector(tableId)).val();
                                                //  d.service_category_id = $('#filter_service_category_id').val();
                                                // d.revenue_business_line_id = $('#filter_revenue_business_line_id').val();
                                                // d.service_item_id = $('#filter_service_item_id').val();
                                            }

                                        }
                                        , "processing": false
                                        , "ordering": false
                                        , "serverSide": true
                                        , "responsive": true
                                        , "pageLength": 25
                                        , "columns": [{
                                                data: 'order'
                                                , searchable: false
                                                , orderable: false
                                            }
                                            , {
                                                data: 'name'
                                                , searchable: false
                                                , orderable: false
                                                , className: 'editable'
                                            },
                                            // {
                                            //     render: function(d, b, row) {
                                            //         return row['revenueBusinessLineName']
                                            //     } ,
                                            //     data:'order',
                                            //     className:'editable'
                                            // }, 

                                            {
                                                render: function(d, b, row) {
                                                    // return " " ;
                                                    return row['duration']
                                                }
                                                , data: 'order'
                                                , className: 'editable text-center'
                                            },

                                            {
                                                render: function(d, b, row) {

                                                    let durations = ['Monthly', 'Quarterly', 'Semi Annually', 'Annually'];

                                                    var select = `<select data-financial-statement-id="${row.id}" class="select select2-select change-duration-type">`;
                                                    durations.forEach((duration) => {

                                                        var durationTranslated = duration // need to be translated
                                                        var selected = slugify(duration) == row.duration_type ? 'selected' : '';
                                                        select += ` <option ${selected} value=" ${slugify(duration)} "> ${durationTranslated}  </option>`
                                                    })
                                                    select += '</select>';
                                                    // dddd
                                                    if (row.can_edit_duration_type) {
                                                        return select;
                                                    }

                                                    return (row['duration_type'])
                                                }
                                                , data: 'order'
                                                , className: 'text-center text-capitalize',

                                            }
                                            , {
                                                data: 'start_from'
                                                , searchable: false
                                                , render(d, b, row) {
                                                    return '<span class="datepicker-input">' + row['start_from'] + '</span>'
                                                }
                                                , orderable: false
                                                , className: 'text-center date'
                                            }
                                            // , {
                                            //     data: 'creator_name'
                                            //     , searchable: false
                                            //     , orderable: false
                                            //     , className: "text-center"
                                            // }
                                            // , {
                                            //     data: 'created_at_formatted'
                                            //     , searchable: false
                                            //     , orderable: false
                                            //     , className: 'text-nowrap text-center'
                                            // }
                                            , {
                                                data: 'id'
                                                , searchable: false
                                                , orderable: false
                                                , className: "text-left",


                                                render: function(d, b, row) {
                                                    var actual = `
			<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/income-statement/${row.income_statement_id}/actual-report"  data-id="${row.income_statement_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:#087A7B !important;color:#fff !important" title="{{ __('Edit Actual Income Statement Report') }}">
				
				{{ __('Actual') }}
				
                        </a>
						`;

                                                    var adjusted = `
					<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/income-statement/${row.income_statement_id}/adjusted-report"  data-id="${row.income_statement_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:rgb(37,150,190) !important;color:#fff !important;margin-right:10px;" title="{{ __('View Adjusted Income Statement Report') }}">{{ __('Adjusted') }}</a>
						`;

                                                    var modified = `
							<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/income-statement/${row.income_statement_id}/modified-report"  data-id="${row.income_statement_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:#087A7B !important;color:#fff !important" title="{{ __('Edit Modified Income Statement Report') }}">{{ __('Modified') }}</a>
						`;

                                                    if (row.type == 'actual') {
                                                        return actual;
                                                    }
                                                    var forecast = `<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/income-statement/${row.income_statement_id}/forecast-report"  data-id="${row.income_statement_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:rgb(37,150,190) !important;color:#fff ;margin-right:10px;" title="{{ __('Edit Forecast Income Statement Report') }}">{{ __('Forecast') }}</a>`

                                                    if (row.can_view_income_statement_actual_report) {
                                                        return forecast + actual + ' <br> <br>' + adjusted + modified;
                                                    } else {
                                                        return forecast;
                                                    }




                                                    // <a data-model-name="{{$modelName}}" data-table-id="${tableId.replace('#','')}" data-record-id="${row.financial_statement_able_id}"   class="btn btn-sm btn-clean delete-record-btn btn-icon btn-icon-md" title="{{ __('Delete') }}">
                                                    //   <i class="la la-trash icon-lg"></i>
                                                    // </a>

                                                    ;
                                                }
                                            }
                                            , {
                                                data: 'id'
                                                , searchable: false
                                                , orderable: false
                                                , className: "text-left",


                                                render: function(d, b, row) {
                                                    var actual = `
			<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/balance-sheet/${row.balance_sheet_id}/actual-report"  data-id="${row.balance_sheet_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:#087A7B !important;color:#fff !important" title="{{ __('Edit Actual Balance Sheet Report') }}">
				
				{{ __('Actual') }}
				
                        </a>
						`;

                                                    var adjusted = `
					<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/balance-sheet/${row.balance_sheet_id}/adjusted-report"  data-id="${row.balance_sheet_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:rgb(37,150,190) !important;color:#fff !important;margin-right:10px;" title="{{ __('View Adjusted Balance Sheet Report') }}">{{ __('Adjusted') }}</a>
						`;

                                                    var modified = `
							<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/income-statement/${row.balance_sheet_id}/modified-report"  data-id="${row.balance_sheet_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:#087A7B !important;color:#fff !important" title="{{ __('Edit Modified Balance Sheet Report') }}">{{ __('Modified') }}</a>
						`;

                                                    if (row.type == 'actual') {
                                                        return actual;
                                                    }
                                                    var forecast = `<a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/balance-sheet/${row.balance_sheet_id}/forecast-report"  data-id="${row.balance_sheet_id}" data-model-name="{{$modelName}}" class="btn cursor-pointer  btn-sm" style="background-color:rgb(37,150,190) !important;color:#fff ;margin-right:10px;" title="{{ __('Edit Forecast Balance Sheet Report') }}">{{ __('Forecast') }}</a>`

                                                    if (row.can_view_balance_sheet_actual_report) {
                                                        return forecast + actual + ' <br> <br>' + adjusted + modified;
                                                    } else {
                                                        return forecast;
                                                    }
                                                }
                                            }
                                            , {
                                                data: 'id'
                                                , searchable: false
                                                , orderable: false
                                                , className: "text-left",


                                                render: function(d, b, row) {
                                                    return `
     

                        <a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/cash-flow-statement/${row.financial_statement_able_id}/report"  data-id="${row.financial_statement_able_id}" data-model-name="{{$modelName}}" class="btn btn-sm cursor-pointer btn-clean btn-icon btn-icon-md" title="{{ __('Edit Balance Sheet Report') }}">
                          <i class="la la-money icon-lg"></i>
                        </a>

                          

                        
                        `

                                                    ;
                                                    // 							<a data-model-name="{{$modelName}}" data-table-id="${tableId.replace('#','')}" data-record-id="${row.financial_statement_able_id}"   class="btn btn-sm btn-clean delete-record-btn btn-icon btn-icon-md" title="{{ __('Delete') }}">
                                                    //    <i class="la la-trash icon-lg"></i>
                                                    //  </a>

                                                }
                                            }
                                            , {
                                                data: 'id'
                                                , searchable: false
                                                , orderable: false
                                                , className: "text-center",


                                                render: function(d, b, row) {
                                                    return `
     

                        <a href="/` + $('body').data('lang') + '/' + $('body').data('current-company-id') + `/financial-statement/${row.id}/report"  data-id="${row.id}" data-model-name="{{$modelName}}" class="btn btn-sm cursor-pointer btn-clean btn-icon btn-icon-md" title="{{ __('Edit Financial Statement Report') }}">
                          <i class="la la-money icon-lg"></i>
                        </a>

						<a data-model-name="{{$modelName}}" data-table-id="${tableId.replace('#','')}" data-record-id="${row.id}"   class="btn btn-sm btn-clean delete-record-btn btn-icon btn-icon-md" title="{{ __('Delete') }}">
                          <i class="la la-trash icon-lg"></i>
                        </a>
                          

                     

                        `

                                                    ;
                                                }
                                            }
                                        ]
                                        , columnDefs: [{
                                            targets: 0
                                            , defaultContent: 'salah'
                                            , className: 'red reset-table-width'
                                        }]
                                        , buttons: [{
                                                "text": '<span class="plus-class">+</span>' + "{{ __('Create') }}"
                                                , 'className': 'btn btn-bold btn-secondary  flex-1 flex-grow-0 btn-border-radius mr-auto'
                                                , "action": function() {
                                                    window.location.href = "{{ $createRoute }}"
                                                }
                                            },

                                            {
                                                "attr": {
                                                    'data-table-id': tableId.replace('#', ''),
                                                    // 'id':'test'
                                                }
                                                , "text": '<svg style="margin-right:10px;position:relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"/></g></svg>' + '{{ __("Filter") }}'
                                                , 'className': 'btn btn-bold btn-secondary ml-2 d-none filter-table-btn  flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away'
                                                , "action": function() {
                                                    $('#filter_form-for-' + tableId.replace('#', '')).toggleClass('d-none');
                                                }
                                            }
                                            , {
                                                "text": '<svg style="margin-right:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" id="Path-103" fill="#000000" fill-rule="nonzero" opacity="0.3"/><rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="2" width="2" height="12" rx="1"/><path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" id="Path-104" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000) "/></g></svg>' + '{{ __("Export") }}'
                                                , 'className': 'btn btn-bold btn-secondary  flex-1 flex-grow-0 btn-border-radius ml-2 do-not-close-when-click-away'
                                                , "action": function() {
                                                    $('#export_form-for-' + tableId.replace('#', '')).toggleClass('d-none');
                                                }
                                            },

                                        ]
                                        , createdRow: function(row, data, dataIndex, cells) {
                                            $(row).addClass('edit-info-row').attr('data-model-id', data.id).attr('data-model-name', '{{ $modelName }}');
                                            $(cells).filter(".editable").attr('contenteditable', true);





                                        }
                                        , initComplete() {
                                            reinitializeSelect2();
                                            $(document).find('.datepicker-input').datepicker({
                                                dateFormat: 'mm-dd-yy'
                                                , autoclose: true
                                            }).on('changeDate', function(dataObject) {
                                                let dateString = formatDate(new Date(dataObject.date));
                                                let financialStatementId = $(this).closest('tr').data('model-id')
                                                $(this).focus().html(dateString).blur();
                                                $.ajax({
                                                    url: "{{ route('admin.update.financial.statement.date',getCurrentCompanyId()) }}"
                                                    , data: {
                                                        "date": dateString
                                                        , "financial_statement_id": financialStatementId
                                                    , }
                                                })
                                            });

                                            // Shows the datepicker when clicking on the content editable div
                                            $(document).on('click', '.date', function() {
                                                $(this).parent().find('.datepicker-input').datepicker("show");
                                            });
                                        }
                                        , drawCallback: function(settings) {
                                            reinitializeSelect2();
                                        }



                                    }

                                );
                            };

                            return {

                                //main function to initiate the module
                                init: function() {
                                    initTable1();
                                },

                            };

                        }();

                        jQuery(document).ready(function() {
                            KTDatatablesDataSourceAjaxServer.init();
                        });
                    })(jQuery);
                });

                function getSearchInputSelector(tableId) {
                    return tableId + '_filter' + ' label input';
                }

                // $(document).ready(function(){

                // })

            </script>
        </x-slot>
        @push('js')
        <script>
            Object.defineProperty(String.prototype, 'capitalize', {
                value: function() {
                    return this.charAt(0).toUpperCase() + this.slice(1);
                }
                , enumerable: false
            });

        </script>
        <script>
            $(function() {
                $(document).on('change', '.change-duration-type', function() {
                    let durationType = $(this).val();
                    let financialStatementId = $(this).closest('tr').data('model-id');
                    if (durationType) {
                        $.ajax({
                            url: "{{ route('admin.update.financial.statement.duration.type',getCurrentCompanyId()) }}"
                            , data: {
                                durationType
                                , financialStatementId
                            }
                            , type: 'delete'
                        })
                    }
                });
                $(document).on('click', '.submit-modal-class:not(.copy-btn)', function(e) {
                    $('.submit-modal-class').prop('disabled', true);
                    e.preventDefault();

                    const formData = {
                        user_name: $(this).closest('form').find('input[name="user_name"]').val()
                        , shareable_id: $(this).closest('form').data('shareable-id')
                        , shareable_type: $(this).closest('form').data('shareable-type')
                    }


                });
            })

        </script>
        @endpush
    </x-tables.basic-view>
</div>
