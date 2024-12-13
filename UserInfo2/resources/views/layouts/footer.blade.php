                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                © @php
                                    echo date('Y');
                                @endphp
                                NPAV
                            </div>
                        </div>
                    </div>
                </footer>

                </div>
                </div>
                <div class="rightbar-overlay"></div>
                <!-- JAVASCRIPT -->
                {{-- <script src="{{ url('public/backend/assets/js/datepicker.min.js') }}"></script> --}}

                <script src="{{ url('/') }}/public/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Datatble Jquery-->
                {{-- <script src="{{ url('public/backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script> --}}

                <script src="{{ url('public/backend/assets/js/dataTables.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/dataTables.buttons.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/buttons.dataTables.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/jszip.min.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/pdfmake.min.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/vfs_fonts.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/buttons.html5.min.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/buttons.print.min.js') }}"></script>


                <script src="{{ url('/') }}/public/backend/assets/libs/metismenu/metisMenu.min.js"></script>
                <script src="{{ url('public/backend/assets/libs/select2/js/select2.min.js') }}"></script>


                <script src="{{ url('public/backend/assets/js/jquery-ui.min.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/jquery.toast.js') }}"></script>
                <script src="{{ url('public/backend/assets/js/flatpickr.js') }}"></script>

                <script src="{{ url('/') }}/public/backend/assets/js/custom.js"></script>
                <script>
                    var url = "{{ url('/') }}";
                    var current_user = "{{ auth()->user() ? auth()->user()->User_Name : '' }}";
                </script>


                </body>

                </html>
