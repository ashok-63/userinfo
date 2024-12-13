<div class="fw-bold" style="position: relative">
    <span id="">Total : {{ $getAllUsers->count() }}</span>
</div>
<div class="table-responsive">
    <table id="usersTable" class="table table-bordered table-striped text-nowrap">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th>Sr</th>
                <th>Username</th>
                <th>Password</th>
                <th>Display Name</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Mobile</th>
                <th>Email</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($getAllUsers)
                @php
                    $count = 1;
                @endphp
                @foreach ($getAllUsers as $key => $row)
                    <tr>
                        <td class="text-center"><b>{{ $count++ }}</b></td>
                        <td class="">
                            <span class=""> {{ $row->User_Name }}</span>
                        </td>
                        <td class="">
                            <span class="">
                                <input type="password" value="{{ $row->Password }}" style="border: none" readonly>
                                <i class="togglePass fa fa-eye " aria-hidden="true" title="View Password"></i>
                                <i class="fa fa-pen-to-square mx-2 openChangePassModal" data-username="{{ $row->User_Name }}"
                                    data-id="{{ $row->id }}" data-password="{{ $row->Password }}" title="Update Password"></i>
                            </span>

                        </td>
                        <td class="">
                            <span class=""> {{ $row->Display_Name }}</span>
                        </td>
                        <td class="">
                            <span class=""> {{ $row->FullName }}</span>
                            <span class="d-none">
                                <input type="text" name="FullName" id="FullName"
                                    class="form-control FullName form-control-sm" value=" {{ $row->FullName }}">
                            </span>
                        </td>
                        <td class="">
                            @if ($row->IsActive && $row->IsActive == '1')
                                <input type="checkbox" value="" class="Status" name="Status" id="Status"
                                    data-username={{ $row->User_Name }} checked>
                            @else
                                <input type="checkbox" value="" class="Status" name="Status" id="Status"
                                    data-username={{ $row->User_Name }}>
                            @endif
                        </td>
                        <td class="contact_details">
                            <span class=""> {{ $row->Mobile }}</span>
                            <span class="d-none">
                                <input type="text" name="Mobile" id="Mobile"
                                    class="form-control Mobile form-control-sm" value=" {{ $row->Mobile }}"
                                    maxlength="10">
                            </span>

                        </td>
                        <td class="contact_details">

                            <span class=""> {{ $row->Email }}</span>
                            <span class="d-none">
                                <input type="email" name="Email" id="Email"
                                    class="form-control Email form-control-sm" value=" {{ $row->Email }}">
                            </span>
                        </td>
                        <td>
                            <span class="">
                                <button class="btn btn-primary btn-sm btnEdit_contactdetails"
                                    data-username="{{ $row->User_Name }}"> <i class="fa fa-pen-to-square"
                                        aria-hidden="true"></i> Edit
                                </button>
                                <button class="btn btn-warning btn-sm btnDelete_user"
                                    data-username="{{ $row->User_Name }}" data-id="{{ $row->id }}"> <i
                                        class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>
                            </span>


                            <span class="d-none">
                                <button class="btn btn-success btn-sm btnSave_contactdetails"
                                    data-username="{{ $row->User_Name }}">
                                    <i class="fa fa-save" aria-hidden="true"></i> Save
                                </button>

                                <button class="btn btn-danger btn-sm btnCancel_contactdetails"> <i class="fa fa-close"
                                        aria-hidden="true"></i> Cancel
                                </button>

                            </span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
