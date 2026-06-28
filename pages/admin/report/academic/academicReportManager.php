<?php
$examFilter = preg_replace('/[^0-9]/', '', (string) ($_GET['exam'] ?? ''));
$sessionFilter = preg_replace('/[^0-9]/', '', (string) ($_GET['session'] ?? ''));

$examOptions = $db_conn->query('SELECT id, approval_abbrv, approval_name FROM approval_type_tbl ORDER BY approval_abbrv ASC')->fetchAll(PDO::FETCH_ASSOC);
$sessionOptions = $db_conn->query('SELECT id, session FROM academicsession_tbl ORDER BY session DESC')->fetchAll(PDO::FETCH_ASSOC);

$where = [];
$params = [];
if ($examFilter !== '') {
    $where[] = 'ar.examination = ?';
    $params[] = $examFilter;
}
if ($sessionFilter !== '') {
    $where[] = 'ar.examYear = ?';
    $params[] = $sessionFilter;
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$summaryStmt = $db_conn->prepare("
    SELECT
        COUNT(DISTINCT ar.schCode) AS schools,
        COUNT(*) AS reports,
        COALESCE(SUM(ar.numCandidates), 0) AS candidates,
        COALESCE(SUM(ar.aboveCandidates), 0) AS above_candidates,
        COALESCE(SUM(ar.avgCandidates), 0) AS average_candidates,
        COALESCE(SUM(ar.belowCandidates), 0) AS below_candidates
    FROM academicreport ar
    {$whereSql}
");
$summaryStmt->execute($params);
$summary = $summaryStmt->fetch(PDO::FETCH_ASSOC) ?: [];

$comparisonStmt = $db_conn->prepare("
    SELECT
        ar.schCode,
        school.sch_name,
        exam.approval_abbrv,
        exam.approval_name,
        acad_session.session,
        COUNT(*) AS reports,
        COALESCE(SUM(ar.numCandidates), 0) AS candidates,
        COALESCE(SUM(ar.aboveCandidates), 0) AS above_candidates,
        COALESCE(SUM(ar.avgCandidates), 0) AS average_candidates,
        COALESCE(SUM(ar.belowCandidates), 0) AS below_candidates,
        CASE
            WHEN COALESCE(SUM(ar.numCandidates), 0) > 0
            THEN ROUND((SUM(ar.aboveCandidates) / SUM(ar.numCandidates)) * 100, 2)
            ELSE 0
        END AS above_rate,
        CASE
            WHEN COALESCE(SUM(ar.numCandidates), 0) > 0
            THEN ROUND((SUM(ar.belowCandidates) / SUM(ar.numCandidates)) * 100, 2)
            ELSE 0
        END AS below_rate
    FROM academicreport ar
    LEFT JOIN _tbl_sch_corporate_data school ON school.sch_code = ar.schCode
    LEFT JOIN approval_type_tbl exam ON exam.id = ar.examination
    LEFT JOIN academicsession_tbl acad_session ON acad_session.id = ar.examYear
    {$whereSql}
    GROUP BY ar.schCode, school.sch_name, exam.approval_abbrv, exam.approval_name, acad_session.session
    ORDER BY above_rate DESC, below_rate ASC, school.sch_name ASC
");
$comparisonStmt->execute($params);
$comparisons = $comparisonStmt->fetchAll(PDO::FETCH_ASSOC);

$detailStmt = $db_conn->prepare("
    SELECT
        ar.*,
        school.sch_name,
        exam.approval_abbrv,
        exam.approval_name,
        acad_session.session,
        cls.className
    FROM academicreport ar
    LEFT JOIN _tbl_sch_corporate_data school ON school.sch_code = ar.schCode
    LEFT JOIN approval_type_tbl exam ON exam.id = ar.examination
    LEFT JOIN academicsession_tbl acad_session ON acad_session.id = ar.examYear
    LEFT JOIN tbl_classes cls ON cls.id = ar.classid
    {$whereSql}
    ORDER BY acad_session.session DESC, exam.approval_abbrv ASC, school.sch_name ASC, cls.className ASC
");
$detailStmt->execute($params);
$details = $detailStmt->fetchAll(PDO::FETCH_ASSOC);

$candidateTotal = (int) ($summary['candidates'] ?? 0);
$aboveRate = $candidateTotal > 0 ? round(((int) $summary['above_candidates'] / $candidateTotal) * 100, 2) : 0;
$belowRate = $candidateTotal > 0 ? round(((int) $summary['below_candidates'] / $candidateTotal) * 100, 2) : 0;
$topSchool = $comparisons[0] ?? null;
$watchList = array_filter($comparisons, function ($row) {
    return (float) $row['below_rate'] >= 30;
});
?>

<div class="border shadow-xs card mb-4">
    <div class="card-header border-bottom pb-0">
        <div class="d-sm-flex align-items-center">
            <div>
                <h6 class="font-weight-semibold text-lg mb-0">Academic Report Analysis</h6>
                <p class="text-sm">Compare submitted examination reports across schools, sessions and classes.</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="get" action="index.php" class="row g-3">
            <input type="hidden" name="pageid" value="<?php echo base64_encode('academicReportManager'); ?>">
            <div class="col-md-5">
                <label class="form-control-label">Examination</label>
                <select name="exam" class="form-control">
                    <option value="">All examinations</option>
                    <?php foreach ($examOptions as $exam): ?>
                        <option value="<?php echo (int) $exam['id']; ?>" <?php echo $examFilter === (string) $exam['id'] ? 'selected' : ''; ?>>
                            <?php echo $utility->escape($exam['approval_abbrv'] . ' - ' . $exam['approval_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-control-label">Session</label>
                <select name="session" class="form-control">
                    <option value="">All sessions</option>
                    <?php foreach ($sessionOptions as $session): ?>
                        <option value="<?php echo (int) $session['id']; ?>" <?php echo $sessionFilter === (string) $session['id'] ? 'selected' : ''; ?>>
                            <?php echo $utility->escape($session['session']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-dark w-100 mb-0">Analyse</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php
    $cards = [
        ['label' => 'Schools', 'value' => (int) ($summary['schools'] ?? 0)],
        ['label' => 'Reports', 'value' => (int) ($summary['reports'] ?? 0)],
        ['label' => 'Candidates', 'value' => $candidateTotal],
        ['label' => 'Above Average', 'value' => $aboveRate . '%'],
        ['label' => 'Below Average', 'value' => $belowRate . '%'],
    ];
    foreach ($cards as $card):
    ?>
        <div class="col-lg col-md-4 col-sm-6 mb-4">
            <div class="border shadow-xs card h-100">
                <div class="card-body">
                    <p class="text-sm mb-1 text-secondary"><?php echo $utility->escape($card['label']); ?></p>
                    <h4 class="mb-0"><?php echo $utility->escape((string) $card['value']); ?></h4>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="border shadow-xs card mb-4">
    <div class="card-header border-bottom pb-0">
        <h6 class="font-weight-semibold text-lg mb-0">Analysis Notes</h6>
    </div>
    <div class="card-body">
        <?php if ($candidateTotal < 1): ?>
            <p class="text-sm mb-0">No academic report matches the selected filter.</p>
        <?php else: ?>
            <p class="text-sm mb-2">
                Across the selected reports, <?php echo $aboveRate; ?>% of candidates are above average while <?php echo $belowRate; ?>% are below average.
            </p>
            <?php if ($topSchool): ?>
                <p class="text-sm mb-2">
                    Highest above-average rate: <strong><?php echo $utility->escape(($topSchool['sch_name'] ?? $topSchool['schCode']) . ' (' . $topSchool['above_rate'] . '%)'); ?></strong>.
                </p>
            <?php endif; ?>
            <p class="text-sm mb-0">
                Schools on watch list: <strong><?php echo count($watchList); ?></strong> with at least 30% of candidates below average.
            </p>
        <?php endif; ?>
    </div>
</div>

<div class="border shadow-xs card mb-4">
    <div class="card-header border-bottom pb-0">
        <h6 class="font-weight-semibold text-lg mb-0">School Comparison</h6>
    </div>
    <div class="card-body px-0 py-0">
        <div class="table-responsive">
            <table class="table table-flush js-datatable">
                <thead class="thead-light">
                    <tr>
                        <th>School</th>
                        <th>Exam</th>
                        <th>Session</th>
                        <th>Reports</th>
                        <th>Candidates</th>
                        <th>Above</th>
                        <th>Average</th>
                        <th>Below</th>
                        <th>Above Rate</th>
                        <th>Below Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comparisons as $row): ?>
                        <tr>
                            <td>
                                <strong><?php echo $utility->escape($row['schCode']); ?></strong><br>
                                <span class="text-sm"><?php echo $utility->escape($row['sch_name'] ?? ''); ?></span>
                            </td>
                            <td><?php echo $utility->escape($row['approval_abbrv'] ?? ''); ?></td>
                            <td><?php echo $utility->escape($row['session'] ?? ''); ?></td>
                            <td><?php echo (int) $row['reports']; ?></td>
                            <td><?php echo (int) $row['candidates']; ?></td>
                            <td><?php echo (int) $row['above_candidates']; ?></td>
                            <td><?php echo (int) $row['average_candidates']; ?></td>
                            <td><?php echo (int) $row['below_candidates']; ?></td>
                            <td><?php echo $utility->escape($row['above_rate']); ?>%</td>
                            <td><?php echo $utility->escape($row['below_rate']); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="border shadow-xs card">
    <div class="card-header border-bottom pb-0">
        <h6 class="font-weight-semibold text-lg mb-0">Submitted Academic Reports</h6>
    </div>
    <div class="card-body px-0 py-0">
        <div class="table-responsive">
            <table class="table table-flush js-datatable">
                <thead class="thead-light">
                    <tr>
                        <th>School</th>
                        <th>Exam</th>
                        <th>Session</th>
                        <th>Class</th>
                        <th>Above</th>
                        <th>Average</th>
                        <th>Below</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $row): ?>
                        <tr>
                            <td>
                                <strong><?php echo $utility->escape($row['schCode']); ?></strong><br>
                                <span class="text-sm"><?php echo $utility->escape($row['sch_name'] ?? ''); ?></span>
                            </td>
                            <td><?php echo $utility->escape(($row['approval_abbrv'] ?? '') . ' - ' . ($row['approval_name'] ?? '')); ?></td>
                            <td><?php echo $utility->escape($row['session'] ?? ''); ?></td>
                            <td><?php echo $utility->escape($row['className'] ?? ''); ?></td>
                            <td><?php echo (int) $row['aboveCandidates']; ?></td>
                            <td><?php echo (int) $row['avgCandidates']; ?></td>
                            <td><?php echo (int) $row['belowCandidates']; ?></td>
                            <td><?php echo (int) $row['numCandidates']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
