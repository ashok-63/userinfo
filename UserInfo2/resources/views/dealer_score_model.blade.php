<style>
    .col-md-1 {
        width: 2.33333% !important;
    }

    .modal-body {
        padding: 0.6rem !important;
    }
</style>
<div id="dealerScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dealerScoreModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Dealer Score Details | <i class="fas fa-copy CopyDealerDetails"></i> </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form method="post" action="javascript:void(0)" class="form-inline" id=""> --}}
            <div class="modal-body">
                <div class="modal_custom_box">
                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>DlrCode</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7 '> <span class="DlrCode">{{ $DealerDetails->dlrCode }}</span> <span
                                style="color: transparent">|</span></div>
                    </div>

                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>Firm Name</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>{{ $DealerDetails->DlrCompany }} <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>Contact Person</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>{{ $DealerDetails->DlrPerson }} <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>City / District / State</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>
                            {{ $DealerDetails->DlrCity . ',' . $DealerDetails->DlrCity . ',' . $DealerDetails->DlrState }}
                            <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>Email ID</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>
                            {{ !empty($DealerDetails->DlrEmail) ? $DealerDetails->DlrEmail : 'N/A' }} <span
                                style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-md-4 modal_cust_label'>Mobile</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>{{ $DealerDetails->DlrMobile }} <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row skip">
                        <div class='col-md-4 modal_cust_label'>Current Score</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>{{ $DealerDetails->CurrentDays }}
                            @php
                                $PrevCount = DB::connection('mysql3')
                                    ->table('LOGSMASTER')
                                    ->select('ID')
                                    ->where('ADDSUB', '=', 'S')
                                    ->where('DLRCODE', '=', $DealerDetails->dlrCode)
                                    ->where('DAYS', '=', 365)
                                    ->orderBy('ID', 'desc')
                                    ->first();
                                $PrevCount = !empty($PrevCount) ? $PrevCount->ID : '0';
                                $RewardCount = DB::connection('mysql3')
                                    ->table('LOGSMASTER')
                                    ->where('ADDSUB', '=', 'A')
                                    ->where('ID', '>', $PrevCount)
                                    ->where('DLRCODE', '=', $DealerDetails->dlrCode)
                                    ->count();
                                echo '(' . $RewardCount . ' packs activated from last reward key sent.)';
                            @endphp
                            <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row skip">
                        <div class='col-md-4 modal_cust_label'>Total Rewards</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>
                            {{ !empty($DealerDetails->TotalRewards) ? $DealerDetails->TotalRewards : '0' }}
                            <span style="color: transparent">|</span>
                        </div>
                    </div>

                    <div class="row skip">
                        <div class='col-md-4 modal_cust_label'>Registration Date</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-7'>
                            {{ !empty($DealerDetails->fInDate) ? $DealerDetails->fInDate : 'N/A' }}
                        </div>
                    </div>
                </div>
                <div class="mt-3 reward_table_data">
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </div>
            {{-- </form> --}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    fetch_data()
    // $(document).on('click', '#pagination a', function(event) {
    //     event.preventDefault();
    //     $('li').removeClass('active');
    //     $(this).parent('li').addClass('active');
    //     var url = $(this).attr('href');
    //     var page = $(this).attr('href').split('page=')[1];
    //     fetch_data(page);
    // });

    function fetch_data() {
        var _token = $("input[name=_token]").val();
        let dealer_code = $('.DlrCode').text();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/fetchRewardLog',
            method: "POST",
            data: {
                'dealer_code': dealer_code,
                // 'page': page
            },
            beforeSend: function() {
                $('#divLoading').show() //show loader
            },
            success: function(data) {
                if ($.fn.DataTable.isDataTable('#custom_datatable')) {
                    $('#custom_datatable').DataTable().destroy();
                }
                $(".reward_table_data").empty().html(data);
                setTimeout(() => {
                    $('#lblRecord').html($('#total_records').text())
                    $('#total_records').hide()
                }, 1000);

                $('#custom_datatable').DataTable({
                    info: false,
                    paging: true,
                    searching: false,
                    pageLength: 10,
                    fixedHeader: true,
                });

                // location.hash = page;
                $('#divLoading').hide() //hide loader
            },
            error: function(err) { // if error occured
                sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
                $('#divLoading').hide() //hide loader
            }
        });
    }

    $(document).on("click", ".resendRewardEmail", function(e) {
        var _token = $("input[name=_token]").val();
        let id = $(this).data('id');
        let dlr_code = $(this).data('dlr_code');
        let sent_lic = $(this).data('sent_lic');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + "/SendRewardMail",
            method: "POST",
            data: {
                'id': id,
                'dlr_code': dlr_code,
                'sent_lic': sent_lic
            },
            beforeSend: function() {
                $('#divLoading').show() //show loader
            },
            success: function(data) {
                Swal.fire('Good job!', data.msg, data.class)
                $('#divLoading').hide() //hide loader
            },
            error: function(err) { // if error occured
                Swal.fire('Oops...', 'Something is Wrong. Please Try Again', "error")
                $('#divLoading').hide() //hide loader
            }
        });
    })
</script>
