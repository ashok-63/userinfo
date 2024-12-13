<style>
    .col-md-1 {
        width: 2.33333% !important;
    }

    .modal-body {
        padding: 0.6rem !important;
    }
</style>
<!-- hardware modal content -->
<div id="HW1Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="HW1ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">HW1 | Srv : Activation | DB : installinfo | Table : ActHwMaster | (Latest Record) <br> Hardware Details of
                    {{ !empty($objrs) ? $objrs->SerialNo : '' }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    {{-- <div class="row"> <div class='col-md-3'>Key No</div><div class='col-md-8'>{{ !empty($objrs)?$objrs->SerialNo:'' }}</div>
                  </div> --}}
                    <div class="row">
                        <div class='col-md-3'>Lancard No 1</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc1No : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard No 2</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc2No : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard No 3</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc3No : '' }}</div>
                    </div>

                    <div class="row">
                        <div class='col-md-3'>Lancard-1 Name</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc1Name : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard-2 Name</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc2Name : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard-3 Name</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc3Name : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3 hwDetailsColHead'>Manufacturer</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Manufacturer : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3 hwDetailsColHead'>Model</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Model : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3 hwDetailsColHead'>CPUName</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->CPUName : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard-1 Ip</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc1Ip : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard-2 Ip</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc2Ip : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>Lancard-3 Ip</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->Lc3Ip : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>HDD1</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->HDD1 : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>HDD2</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->HDD2 : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>HDDModels</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->HDDModels : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>CPUSpeed</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->CPUSpeed : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>MachineName</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->MachineName : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>MBID</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->MBID : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>OS</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->OS : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>BITS</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->BITS : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>CDVSN</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->CDVSN : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>DDVSN</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->DDVSN : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>HDDInstCode</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->HDDInstCode : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>LCInstCode</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->LCInstCode : '' }}</div>
                    </div>
                    <div class="row">
                        <div class='col-md-3'>MBInstCode</div>
                        <div class="col-md-1">:</div>
                        <div class='col-md-8'>{{ !empty($objrs) ? $objrs->MBInstCode : '' }}</div>
                    </div>

                    {{-- <div class="row">
                    <div class='col-md-4'>InstCode:</div><div class='col-md-8'>3434</div>
                  </div> --}}


                </div>

            </div><!-- /.modal-body -->
            {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary waves-effect"
                      data-bs-dismiss="modal">Close</button>

              </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
