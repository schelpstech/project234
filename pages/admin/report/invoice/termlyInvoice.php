<div class="border shadow-xs card">
  <div class="pb-0 card-header border-bottom">
    <div class="card-header border-bottom pb-0">
      <div class="d-sm-flex align-items-center">
        <div>
          <h6 class="font-weight-semibold text-lg mb-0">Termly Invoices of
            <?php echo $sch_corporate_data['sch_name'] ?>
          </h6>
        </div>
        <div class="ms-auto d-flex">
          <a type="button" href="../../app/adminRouter.php?pageid=<?php echo base64_encode('schInvoicePage') ?>&schCode=<?php echo $_SESSION['schCode'] ?>" class="mb-0 btn btn-sm btn-dark me-2">
            <strong>Back</strong>
          </a>
        </div>
      </div>
    </div>
    <div class="px-5 py-4 container-fluid">
      <div class="mt-3 mt-lg-4 row">
        <div class="mx-auto col-md-10 col-sm-10">
          <form class="" action="index.html" method="post">
            <div class="border border-white shadow-xs card blur my-sm-5">
              <div class="px-4 pt-4 text-center bg-transparent card-header">
                <div class="row justify-content-between">
                  <div class="mt-3 col-md-6 text-start">
                    <h6>
                      Christ the Redeemer's Schools Management(CRSM),
                      <br>The CRSM Secretariat,
                      <br>Km 46, The Redemption Camp,
                      <br>Lagos - Ibadan Express Road,
                      <br>Ogun state. Nigeria.
                    </h6>
                  </div>
                  <div class="mt-3 col-lg-3 col-md-6 text-md-end text-start">
                    <h6 class="mt-2 mb-0 d-block">Billed to: </h6>
                    <p class="text-secondary">
                      <?php echo $_SESSION['schCode'] ?? "" ?><br>
                      <?php echo $sch_corporate_data['sch_name'] ?? "" ?><br>
                    </p>
                  </div>
                </div>
                <br>
                <div class="row justify-content-md-between">
                  <div class="mt-auto col-md-4">
                    <h6 class="mb-0 text-start text-secondary">
                      Remittance Term
                    </h6>
                    <h5 class="mb-0 text-start">
                      <?php echo $termlyRemittance['termVariable'] ?? "" ?>
                    </h5>
                  </div>
                  <div class="mt-auto col-lg-5 col-md-7">
                    <div class="mt-4 row mt-md-5 text-md-end text-start">
                      <div class="col-md-6">
                        <h6 class="mb-0 text-secondary">Invoice date:</h6>
                      </div>
                      <div class="col-md-6">
                        <h6 class="mb-0 text-start">
                          <?php echo ltrim($termlyRemittance['invRecordTime'], 10) ?? "" ?>
                        </h6>
                      </div>
                    </div>
                    <div class="row text-md-end text-start">
                      <div class="col-md-6">
                        <h6 class="mb-0 text-secondary">Invoice #:</h6>
                      </div>
                      <div class="col-md-6">
                        <h6 class="mb-0 text-start">
                          <?php echo $termlyRemittance['invReference'] ?? "" ?>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-4 card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table class="table text-right">
                        <thead class="text-white bg-dark">
                          <tr>
                            <th scope="col" class="rounded-start pe-2 text-start ps-2">S/N</th>
                            <th scope="col" class="rounded-start pe-2 text-start ps-2">Class Name</th>
                            <th scope="col" class="pe-2">Population</th>
                            <th scope="col" class="pe-2" colspan="2">Tuition Fee</th>
                            <th scope="col" class="rounded-end pe-2">Remittance Due</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $count = 1;
                          if (!empty($enrolmentRecord)) {
                            foreach ($enrolmentRecord as $data) {
                              $total = (($data['population'] * $data['tuition']) * 0.02);
                              $allTotal = 0;
                              $allTotal += $total;
                          ?>
                              <tr>
                                <td class="text-sm text-dark ps-4">
                                  <?php echo $count++ ?>
                                </td>
                                <td class="text-sm text-dark text-start">
                                  <?php echo $data['className'] ?>
                                </td>
                                <td class="text-sm text-dark ps-4">
                                  <?php echo $data['population'] ?>
                                </td>
                                <td class="text-sm text-dark ps-4" colspan="2">
                                  <?php
                                  echo $utility->money($data['tuition'])
                                  ?>
                                </td>
                                <td class="text-sm text-dark ps-4">
                                  <?php
                                  echo $utility->money($total)
                                  ?>
                                </td>
                              </tr>
                          <?php
                            }
                          }
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="h5 ps-4" colspan="2">Bill Amount</th>
                            <th colspan="1" class="text-right h6 ps-4">
                              <?php
                              echo $utility->money($termlyRemittance['invAmount'] ?? 0)
                              ?>
                            </th>
                          </tr>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="h5 ps-4" colspan="2">Approved Rebate</th>
                            <th colspan="1" class="text-right h6 ps-4" style="color: red;">
                              <?php
                              echo $utility->money($termlyRemittance['rebateAmount'] ?? 0)
                              ?>
                            </th>
                          </tr>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="h5 ps-4" colspan="2">Amount Payable</th>
                            <th colspan="1" class="text-right h5 ps-4">
                              <?php
                              echo $utility->money($termlyRemittance['amountPayable'] ?? 0)
                              ?>
                            </th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="px-4 pb-4 mt-4 card-footer mt-md-5">
                      <div class="row">
                        <div class="text-left col-lg-8">
                          <h5>Payment Advice:</h5>
                          <p class="text-sm text-secondary"><strong> Destination Bank: <br>Account Number: <br>Account Name: CRSM </strong></p>
                          <h6 class="mb-0 text-secondary">
                            If you encounter any issues related to the invoice you can contact us at:
                            <span class="text-dark">finance@crsm.ng</span>
                          </h6>
                        </div>
                        <div class="mt-3 col-lg-2 text-md-end mt-md-0">
                          <button class="mb-0 text-white btn bg-info mt-lg-7" type="button" data-bs-toggle="modal" data-bs-target="#modal_invoice_validation" name="button"><i class="fa-solid fa-check me-2"></i>Validation Remarks</button>
                        </div>
                        <div class="mt-3 col-lg-2 text-md-end mt-md-0">  
                          <button class="mb-0 text-white btn bg-dark mt-lg-7" onClick="window.print()" type="button" name="button"><i class="fa-solid fa-print me-2"></i>Print</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_invoice_validation" tabindex="-1" role="dialog" aria-labelledby="modal_invoice_validation" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <form action="../../app/validator.php" method="post">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-notification">Termly Remittance Invoice Validation</h6>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="py-3 text-center">
            <i class="ni ni-bell-55 ni-3x"></i>
            <p class="mt-4 text-gradient text-dark">Validation remarks on the <?php echo $termlyRemittance['termVariable'] ?? "" ?> <br>2% Remittance Invoice of <br><?php echo $sch_corporate_data['sch_name'] ?>!</p>
          </div>
          <div class="col-md-12">
            <label for="example-text-input" class="form-control-label">Set data validation status</label>
            <select type="text" class="form-control" name="validation">
              <option value="">select</option>
              <option value="0">Invalidate</option>
              <option value="1">Validate</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="invoice_validation_remarks" value="<?php echo $termlyRemittance['invReference'] ?? "" ?>"  class="btn btn-info">Submit Remarks</button>
        </div>
      </form>
    </div>
  </div>
</div>