<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">National Educators Conference Registrants</h6>
                        <p class="text-sm">All submitted participant information</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <button type="button" class="mb-0 btn btn-sm btn-dark me-2" onclick="generatePDF();">
                            <strong>Print</strong>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Reg ID</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Full Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Gender</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Phone</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Email</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Education Section</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Certificate Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Reg Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $registrants = $model->select_all('educators_registrations');
                            if (!empty($registrants)) {
                                foreach ($registrants as $data) {
                                    ?>
                                    <tr>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['regid']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['fullname']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['gender']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['phone']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['email']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['education_section']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['certificate_name']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                                <?= htmlspecialchars($data['registration_date']) ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted">No records found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
