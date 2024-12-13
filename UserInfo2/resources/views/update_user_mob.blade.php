<style>
    @media (min-width: 576px) {
        .col-sm-4 {
            width: 26.33333% !important;
        }
    }
</style>
<!-- user details modal content -->
<div id="UpdateUserMobModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="UpdateUserMobModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Update User Mobile</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="update_user_mob_form">
                <div class="modal-body">
                    <input type="hidden" name="CustNo" value="{{ $CustNo }}">
                    <input type="hidden" name="KeyNo" value="{{ $SerialNo }}">
                    <div class="mb-3 row">
                        <label for="txtMob2" class="col-sm-4 col-form-label">Mobile2:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="txtMob2" name="txtMob2"
                                value="{{ $MobNo }}" required>
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

        $("#update_user_mob_form").submit(function(event) {
            event.preventDefault();
            var _token = $("input[name=_token]").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if ($('#update_user_mob_form').valid()) {
                $.ajax({
                    url: url + '/UpdateUserMob',
                    method: "POST",
                    data: $('#update_user_mob_form').serialize(),
                    beforeSend: function() {
                        $('#divLoading').show() //show loader
                    },
                    success: function(data) {
                        if (data.class == 'success') {
                            Swal.fire('Good job!', data.msg, data.class)
                            $('#UpdateUserMobModal').modal('hide')


                            $("#btn-search").trigger("click");
                        } else {
                            Swal.fire('Error!', data.msg, data.class)
                        }

                        $('#divLoading').hide() //hide loader
                    },
                    error: function(err) { // if error occured
                        $('#divLoading').hide() //hide loader
                    }
                });
            }

        });


    });
</script>
