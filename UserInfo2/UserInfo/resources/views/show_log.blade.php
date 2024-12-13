<style type="text/css">
    body,
    td,
    th {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
    }

    .style1 {
        font-size: 16px;
        color: #0066FF;
    }

    .impFld {
        color: #F27900;
        font-weight: bold;
        font-size: 10px;
    }

    .safe-react {
        color: #3DB801;
        font-weight: bold;
        font-size: 12px;
    }

    .pin-react {
        color: #E92B25;
        font-weight: bold;
        font-size: 12px;
    }

    /* .table-bordered th {
      font-size: 12px! important;
    } */

    .show_log_table td {
        font-size: 10px ! important;
        background-color: rgb(209, 255, 198);
    }

    .brdcell {
        color: #15428b;
        font-weight: bold;
        font-size: 11px !important;
        font-family: tahoma, arial, verdana, sans-serif;
        background-image: url(public/backend/assets/images/white-top-bottom.gif);
        border: solid #A3BDC0 1px;
        border-collapse: collapse;
    }


    @media (min-width: 992px) {

        .modal-lg,
        .modal-xl {
            max-width: 875px;
        }
    }
</style>
<!-- show log modal content -->
<div id="ShowLogModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ShowLogLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title style1">Automatic Reactivation Log</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <table class="table table-bordered show_log_table">
                        <thead>
                            <tr>
                                <th class="brdcell">SR</th>
                                <th class="brdcell">NPAV Key</th>
                                <th class="brdcell">React Type</th>
                                <th class="brdcell">Matched Field</th>
                                <th class="brdcell">Reactivation Given because</th>
                                <th class="brdcell">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($LogInfo as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->LicNo }}</td>
                                    <td>
                                        @if ($value->ReactType == 'SAFE')
                                            <span class='safe-react'>SAFE Reactivation</span>
                                        @else
                                            <span class='pin-react'>PIN Reactivation</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->ReactType == 'SAFE')
                                            Matched Field: <span class='impFld'>{{ $value->MatchedField }}</span><br />
                                            Matched In: <span class='impFld'>{{ $value->MatchedIn }}</span>
                                        @else
                                            Secret PIN: <span class='impFld'>{{ $value->SecretPIN }}</span><br />
                                            PIN Sent Mob: <span class='impFld'>{{ $value->PINMobile }}</span>


                                            @if (!empty($value->userInputMobile))
                                                <br />PIN Request Mob: <span
                                                    class='impFld'>{{ $value->userInputMobile }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $value->WhyReactGiven }}</td>
                                    <td>{{ $value->fReactDate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
