<style>
    @media (min-width: 576px) {
        .col-sm-4 {
            width: 26.33333% !important;
        }
    }
</style>
<!-- user details modal content -->
<div id="UserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">User Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="user_details_form">
                <input type="hidden" name="customer_no" value="{{ $UserData->customerNumber }}">
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="txtName" class="col-sm-4 col-form-label">Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="txtName" name="txtName"
                                value="{{ $UserData->Name }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtCp" class="col-sm-4 col-form-label">Contact Person:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="txtCp" name="txtCp"
                                value="{{ $UserData->contactPerson }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtCustMob" class="col-sm-4 col-form-label">Mobile:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="txtCustMob" name="txtCustMob"
                                value="{{ $UserData->CustMobile }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtEmail" class="col-sm-4 col-form-label">Email Id:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control form-control-sm" id="txtEmail" name="txtEmail"
                                value="{{ $UserData->emailID }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtAdd" class="col-sm-4 col-form-label">Address:</label>
                        <div class="col-sm-8">
                            <textarea name="txtAdd" cols="40" rows="4" id="txtAdd" onkeyup="CharCounter();" required>{{ $UserData->Address }}</textarea>
                            <p><small>Address Character Limit:<span id="char_count" class="warning-msg"></span></small>
                            </p>
                        </div>
                    </div>

                </div><!-- /.modal-body -->
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $(document).ready(function() {
        CharCounter();

        $("#user_details_form").submit(function(event) {
            event.preventDefault();
            var _token = $("input[name=_token]").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if ($('#user_details_form').valid()) {
                $.ajax({
                    url: url + '/UpdateUserDetails',
                    method: "POST",
                    data: $("#user_details_form").serialize(),
                    beforeSend: function() {
                        $('#divLoading').show() //show loader
                    },
                    success: function(data) {
                        $('#btn-search').trigger('click')
                        Swal.fire('Good job!', data.msg, data.class)
                        $('#UserModal').modal('hide')
                        $('#divLoading').hide() //hide loader
                    },
                    error: function(err) { // if error occured
                        $('#divLoading').hide() //hide loader
                    }
                });
            }
        });

        var max = 255;
        $('textarea#txtAdd').keypress(function(e) {
            if (e.which < 0x20) {
                return; // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });

    });

    function CharCounter() {
        if ($('#txtAdd').val() != "") {
            let charlength = $('#txtAdd').val().length;
            $('#char_count').html(' ' + charlength + ' /255');
            if (charlength > 255) {
                alert("Address Character Limit Exceeded! Only 255 characters are allowed in one sms.");
                return true;
            }
        } else {
            $('#char_count').html('0')
        }

    }
</script>
