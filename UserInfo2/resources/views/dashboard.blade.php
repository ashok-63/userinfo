@extends('master')
@section('title')
    Dashboard
@stop
@section('content')
    <style>
        body,
        td,
        th {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            line-height: 20px;
        }

        .fa-clipboard {
            cursor: pointer;
        }

        .txtMatched {
            background-color: #CEF1CD;
            padding: 1px 1px 1px 1px;
        }

        .txtMatchedWith {
            background-color: #C1F9B9;
            padding: 1px 1px 1px 1px;
        }

        .txtNotMatched {
            background-color: #FFE1D7;
            padding: 1px 1px 1px 1px;
        }


    </style>
    <div class=" mt-2 main_container">
        <div class="row">
            @php
                $loggedUserName = auth()->user()->User_Name;
                $bookmarks = DB::connection('mysql6')
                    ->table('userpermissionmaster')
                    ->where('User_Name', $loggedUserName)
                    ->value('Kayako');
            @endphp
            <div class="col-md-12">
                <form method="POST" id="SearchKeyDetails" action="#" data-form-url="{{ 'SearchByKey' }}">
                    @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-3 selectBoxDiv">
                                    <div class="form-group">
                                        <select class="form-control select2_search_by-" name="search_by" id="search_by">
                                            <option value="lic">Key Number</option>
                                            <option value="ic">Installation code </option>
                                            @if (
                                                $loggedUserName == 'sumeet' ||
                                                    $loggedUserName == 'yogeshg' ||
                                                    $loggedUserName == 'bhagwatb' ||
                                                    $loggedUserName == 'kanchanb' ||
                                                    $loggedUserName == 'tusharb' ||
                                                    $loggedUserName == 'sandeepb')
                                                <option value="lan">Lan card number</option>
                                            @endif
                                            <option value="uc">Unlock Code</option>
                                            <option value="hdd">HDD2</option>
                                            <option value="cn">Computer Name</option>
                                            @if ($loggedUserName == 'sumeet' || $loggedUserName == 'kanchanb' || $loggedUserName == 'sandeepb')
                                                <option value="fn">Company Name</option>
                                            @endif
                                            <option value="" disabled>-------------------------</option>
                                            <option value="cNo">Customer No</option>
                                            <option value="cp">Customer Name</option>
                                            <option value="cm">Customer Mobile</option>
                                            <option value="ce">Customer Email</option>
                                            <option value="add">Address</option>
                                            <option value="" disabled>-------------------------</option>
                                            <option value="DlrCode">Dlr Code</option>
                                            <option value="DlrMob">Dlr Mobile</option>
                                            <option value="Dlr">Dealer</option>
                                            <option value="myAct" data-select2-id='not apply'>MyActs</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 inputBoxDiv">
                                    <div class="form-group">
                                        <input type="text" class="form-control search_txt" id="search_txt"
                                            placeholder="Enter Search Text" name="search_txt"
                                            @if ($keyNo) value="{{ $keyNo }}"
                                             @else
                                             value="" @endif
                                            value="" required list="keylist" />
                                    </div>
                                    <datalist id="keylist">
                                    </datalist>
                                </div>
                                <div class="col-1 txtICDiv" style="display: none">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="txtIC" placeholder=""
                                            name="txtIC" value="">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-success" id="btn-search"
                                        style="width: max-content"> <i class="fa fa-search"
                                            aria-hidden="true"></i>Search</button>
                                </div>
                                <div class="col-4">
                                    @if ($bookmarks == 1)
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="addToBookMarks"
                                            title="Add Bookmark">
                                            <i class="fa fa-star" aria-hidden="true"></i> <i
                                                class="fa fa-duotone fa-spinner fa-spin-pulse spinner d-none"></i> Add
                                            BK</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="bookMarkedKeys"
                                            title="View Bookmark">
                                            <i class="fa fa-bookmark" aria-hidden="true"></i> View BK</button>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-outline-success" id="searchInUpd2Uc"
                                        title="Search In Upd2uc">
                                        <i class="fa fa-search" aria-hidden="true"></i> Search upd2uc</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="total_record_count">
                                Total Count :
                                <span id="DBcount"> 0 </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- col-md-8 -->
        </div> <!-- row -->
        @include('layouts.navigation-buttons')
        <div class="row mt-1" style="font-size: 14px;">
            <strong style="color: #009900;">Online Purchase or Renewal-&gt;</strong><strong>
                <span class="style9">
                    1 PC : 1 Year Rs. 750, 3 Years Rs. 1380</span>&nbsp;| &nbsp;<span class="style10">2 PC : 1 Year Rs.
                    1460, 3 Years Rs. 2500&nbsp;</span>|&nbsp; <span class="style11">3 PC : 1 Year Rs. 2145, 3 Years Rs.
                    3600&nbsp;</span>&nbsp;| &nbsp;<a href="http://www.indiaantivirus.com/CreditCard.html"
                    target="_blank">More&gt;&gt;</a></strong>
        </div>
        <div class="row">
            <div class="table-responsive" id="table_data">
                {{-- include table pagination page --}}
                {{-- @include('dashboard_tbl_pagination') --}}
            </div>
        </div>
        <div class="hw_modal_body" data-form-url="{{ 'FetchHWDetails1' }}">
        </div>
        <div class="user_details_modal_body">
        </div>
        <div class="reactive_modal_body">
        </div>
        <div class="block_unlockcode_modal_body">
        </div>
        <div class="dealer_score_modal_body">
        </div>
        <div class="gen_reactive_modal_body">
        </div>
        <div class="show_log_modal_body">
        </div>
        <div class="bookMarkBody">
        </div>

        <div id="unlockCodeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="unlockCodeModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 8px 15px;">
                        <h6 class="modal-title">Unlock Code</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="response_div" style="background: #9abf9a;" class="p-3"></div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        {{-- Convert LIC Modal Start --}}
        <div id="ConvertLicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ConvertLicModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 8px 15px;">
                        <h6 class="modal-title">Convert Lic From : E/X-To S-, A- To T- , S- To E-, T- To A-</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="" class="p-3 col-12">
                        <form action="javascript:void(0)" method="post" id="convertLicForm">
                            @csrf
                            <div class="row col-12 my-2">
                                <div class="col-4" style="text-align: center;">Enter LIC </div>
                                <div class="col-1"> : </div>
                                <div class="col-5">
                                    <label for="">Enter each new key on new line...</label>
                                    <textarea name="licNo" id="licNo" cols="4" rows="4" class="form-control form-control-sm"></textarea>
                                    <strong style="font-weight: 600"> (Only E-,A-,S-,T-,X- keys are allowed)</strong>
                                </div>
                            </div>
                            <div class="row col-12 my-2">
                                <div class="col-4" style="text-align: center;">Corp Id </div>
                                <div class="col-1"> : </div>
                                <div class="col-4">
                                    <input type="text" name="CorpId" id="CorpId"
                                        class="form-control form-control-sm" placeholder="Corp Id">
                                </div>
                            </div>
                            <div class="row col-12 my-2">
                                <div class="col-4" style="text-align: center;">Reason </div>
                                <div class="col-1"> : </div>
                                <div class="col-4">
                                    <textarea name="reason" id="reason" cols="5" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                            <div class="row col-12 my-2">
                                <div class="col-4" style="text-align: center;">Password </div>
                                <div class="col-1"> : </div>
                                <div class="col-4">
                                    <input type="password" name="convertPass" id="convertPass"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row col-12" style="flex-direction: row-reverse;">
                                <button type="reset" class=" btn btn-sm btn-warning col-1 mx-2 closeLicConvModal"
                                    data-bs-dismiss="modal" aria-label="Close"> Close</button>
                                <button class="btn btn-sm btn-primary col-1" type="submit"> Convert</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Convert LIC Modal End --}}

        {{-- RewardKey Modal Start --}}
        <div id="rewardKeyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rewardKeyModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 8px 15px;">
                        <h6 class="modal-title">Get New Reward Key</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="" class="p-3 col-12">
                        <form action="javascript:void(0)" method="post" id="fetchNewRewardKeyForm">
                            @csrf
                            <div class="row col-12 my-2">

                                <input type="hidden" name="oldLic" id="oldLic" value="">
                                <div class="col-4" style="text-align: center;">Enter Dlr Code </div>
                                <div class="col-1"> : </div>
                                <div class="col-5">
                                    <input type="text" name="SentToDlr" id="SentToDlr"
                                        class="form-control form-control-sm" placeholder="Dlr Code" value="">
                                </div>
                            </div>
                            <div class="row col-12 my-2">
                                <div class="col-4" style="text-align: center;">Dlr Mobile </div>
                                <div class="col-1"> : </div>
                                <div class="col-5">
                                    <input type="text" name="DlrMobile" id="DlrMobile"
                                        class="form-control form-control-sm" placeholder="Dlr Mobile" value="">
                                </div>
                            </div>


                            <div class="row col-12 mt-3" style="justify-content: center;">
                                <button type="reset" class=" btn btn-sm btn-warning col-1 mx-2 closeLicConvModal"
                                    data-bs-dismiss="modal" aria-label="Close"> Close</button>
                                <button class="btn btn-sm btn-primary col-1" type="submit"> Save</button>
                            </div>
                        </form>

                        <div class="text-center col-auto m-5" id="newKeyViewer" style="font-size: 17px;;">
                            New Fetched Reward key
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- RewardKey Modal End --}}











        {{-- BookMark Modal Start --}}
        <div id="BookMarkModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="BookMarkModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 8px 15px;">
                        <h6 class="modal-title">Bookmarked Keys</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modalContent" class="p-4" style="">

                        <div class="row col-12">


                            <table class="table table-bordered" id="bookMarksTbl" style="text-wrap : nowrap">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Key / Search Text</th>
                                        <th>AddedBy</th>
                                        <th>Indate</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- BookMark Modal End --}}

    </div> <!-- container-fluid -->
    <script src="{{ url('/public/backend/assets/js/include/dashboard.js') }}"></script>
@endsection('content')
