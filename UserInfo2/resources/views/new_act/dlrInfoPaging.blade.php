<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: inherit !important;
        border: 1px solid rgba(0, 0, 0, 0.3);
        background-color: rgba(230, 230, 230, 0.1);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(230, 230, 230, 0.1)), color-stop(100%, rgba(0, 0, 0, 0.1)));
        background: -webkit-linear-gradient(top, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        background: -moz-linear-gradient(top, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        background: -ms-linear-gradient(top, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        background: -o-linear-gradient(top, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        background: linear-gradient(to bottom, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        color: inherit !important;
        border: 1px solid transparent;
        border-radius: 2px;
    }

    #drlInfoTable_length {
        display: none
    }
</style>
<table class="table table-bordered table-hover" id="drlInfoTable">
    <thead>
        <tr style="text-wrap: nowrap;">
            <th>Dealer Information</th>
            <th>Contact Details</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @if ($data)
            @foreach ($data as $row)
                <tr data-dlrcode="{{ $row->dlrCode }}" class="selectedDlr">
                    <td> Dlr Code : {{ $row->dlrCode }} <br>
                         Comp Name : {{ $row->DlrCompany }} <br>
                         CP : {{ $row->DlrPerson }}
                    </td>
                    <td>
                        Mob : {{ $row->DlrMobile }} <br>
                        LL : {{ $row->DlrPhone }} <br>
                        Email : {{ $row->DlrEmail }}
                    </td>
                    <td>
                        {{ $row->DlrAddress }} <br>
                        City : {{ $row->DlrCity }} <br>
                        District : {{ $row->DlrDistrict }} <br>
                        State : {{ $row->DlrState }}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
