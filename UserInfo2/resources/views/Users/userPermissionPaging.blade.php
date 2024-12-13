<table id="usersTable" class="table table-bordered table-striped">
    <thead style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
        <tr>
            <th>Sr</th>
            <th class="" style="z-index: 9;background-color: #73c686!important; ">
                Username</th>
            <th></th>
            <th>NewAct</th>
            <th>DlrScore</th>
            <th>MyAct</th>
            <th>PriceList</th>
            <th>DlrReg</th>
            <th>DlrActCount</th>
            <th>OnlinePurchasePDF</th>
            <th>AndroidAct</th>
            <th>Articles</th>
            <th>AddDays</th>
            <th>TechSupportNo</th>
            <th>SendEmail</th>
            <th>K2State Policy</th>
            <th>FindOrder</th>
            <th>StateActCnt</th>
            <th>ActGraph</th>
            <th>UpdDlrInfo</th>
            <th>BlockKeys</th>
            <th>ScratchKeys</th>
            <th>ReleaseKeys</th>
            <th>APKSMS</th>
            <th>LastActs</th>
            <th>Bookmarks</th>
            <th>changeIP</th>
            <th>OTP Master</th>
            <th>ManageUsers</th>
            <th>LoginHistory</th>
            <th>UserPermission</th>

            <th>Convert LIC</th>
            <th>Grant Access</th>
        </tr>
    </thead>
    <tbody>
        @if ($getData)
            @php
                $count = 1;
            @endphp
            @foreach ($getData as $key => $row)
                <tr>
                    <td class="text-center"><b>{{ $count++ }}</b></td>
                    <td class="">
                        <span> <button class="btn btn-sm btn-primary grantAccess" type="submit"
                                data-username="{{ $row->User_Name }}"> <i class="fa fa-save" aria-hidden="true"></i>
                            </button></span>
                        <span><b>{{ $row->User_Name }}</b></span>
                    </td>
                    <td> <input value="" type="checkbox" name="checkAll" id="checkAll" class="checkAll"
                            title="Check All Row">
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="NewAct" id="NewAct"
                            {{ $row->NewAct == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="DlrScore" id="DlrScore"
                            {{ $row->DlrScore == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="MyAct" id="MyAct"
                            {{ $row->MyAct == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="PriceList" id="PriceList"
                            {{ $row->PriceList == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="DlrReg" id="DlrReg"
                            {{ $row->DlrReg == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="DlrActCount" id="DlrActCount"
                            {{ $row->DlrActCount == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="OnlinePurchasePDF" id="OnlinePurchasePDF"
                            {{ $row->OnlinePurchasePDF == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="AndroidAct" id="AndroidAct"
                            {{ $row->AndroidAct == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="Articles" id="Articles"
                            {{ $row->Articles == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="AddDays" id="AddDays"
                            {{ $row->AddDays == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="TechSupportNo" id="TechSupportNo"
                            {{ $row->TechSupportNo == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="SendEmail" id="SendEmail"
                            {{ $row->SendEmail == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="PndReq" id="PndReq"
                            {{ $row->PndReq == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="FindOrder" id="FindOrder"
                            {{ $row->FindOrder == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="StateActCnt" id="StateActCnt"
                            {{ $row->StateActCnt == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="ActGraph" id="ActGraph"
                            {{ $row->ActGraph == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="UpdDlrInfo" id="UpdDlrInfo"
                            {{ $row->UpdDlrInfo == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="BlockKeys" id="BlockKeys"
                            {{ $row->BlockKeys == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="ScratchKeys" id="ScratchKeys"
                            {{ $row->ScratchKeys == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="ReleaseKeys" id="ReleaseKeys"
                            {{ $row->ReleaseKeys == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="APKSMS" id="APKSMS"
                            {{ $row->APKSMS == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="LastActs" id="LastActs"
                            {{ $row->LastActs == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="Kayako" id="Kayako"
                            {{ $row->Kayako == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="changeIP" id="changeIP"
                            {{ $row->changeIP == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="OTPmaster" id="OTPmaster"
                            {{ $row->OTPmaster == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="ManageUsers" id="ManageUsers"
                            {{ $row->ManageUsers == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="LoginHistory" id="LoginHistory"
                            {{ $row->LoginHistory == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="UserPermission" id="UserPermission"
                            {{ $row->UserPermission == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">
                        <input value="" type="checkbox" name="ConvertLic" id="ConvertLic"
                            {{ $row->ConvertLic == '1' ? 'checked' : '' }}>
                    </td>
                    <td class="text=center">
                        <span>
                            <button class="btn btn-sm btn-primary grantAccess" type="submit"
                                data-username="{{ $row->User_Name }}">
                                <i class="fa fa-save" aria-hidden="true"></i>
                            </button>
                        </span>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
