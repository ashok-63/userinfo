<div class="fw-bold" style="position: relative">
    <span id="">Total : {{ $districts->count() }}</span>
</div>
<div class="table-responsive">
    <table id="disttable" class="table table-bordered table-striped text-nowrap">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th>Sr</th>
                <th>State</th>
                <th>District</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($districts)
                @php
                    $count = 1;
                @endphp
                @foreach ($districts as $key => $row)
                    <tr>
                        <td class="text-center"><b>{{ $count++ }}</b></td>
                        <td class="">
                            <span class=""> {{ $row->StateName }}</span>
                        </td>
                        <td class="contact_details">
                            <span class=""> {{ $row->DISTRICT }}</span>
                            <span class="d-none">
                                <input type="text" name="DISTRICT" id="DISTRICT"
                                    class="form-control DISTRICT form-control-sm" value=" {{ $row->DISTRICT }}">
                            </span>

                        </td>
                        <td>
                            <span class="">
                                <button class="btn btn-primary btn-sm btnEdit_contactdetails"
                                    data-did="{{ $row->dID }}"> <i class="fa fa-pen-to-square"
                                        aria-hidden="true"></i> Edit
                                </button>

                            </span>


                            <span class="d-none">
                                <button class="btn btn-success btn-sm btnSave_contactdetails"
                                    data-did="{{ $row->dID }}">
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
