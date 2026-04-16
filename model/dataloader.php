<?php
class DataLoader {

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function load($page, $session) {

        switch ($page) {

            case 'dashboard':
                return $this->dashboard($session);

            case 'schPersonnelList':
                return [
                    'personnel' => $this->personnelList($session)
                ];

            case 'financeProfile':
                return [
                    'finance' => $this->finance($session)
                ];

            case 'ticketLog':
                return [
                    'tickets' => $this->tickets()
                ];

            default:
                return $this->dashboard($session);
        }
    }

    private function dashboard($session) {
        return [
            'currentTerm' => $this->model->getRows('tblcurrent_term', [
                'return_type' => 'single',
                'where' => ['termStatus' => 1]
            ])
        ];
    }

    private function personnelList($session) {
        if (!isset($session['schCode'])) return [];

        return $this->model->getRows('tbl_personnel_record', [
            'where' => ['schCode' => $session['schCode']]
        ]);
    }

    private function finance($session) {
        if (!isset($session['schCode'])) return [];

        return $this->model->getRows('_tbl_termlyinvoice', [
            'where' => ['schCode' => $session['schCode']]
        ]);
    }

    private function tickets() {
        return $this->model->getRows('_tbl_ticket', [
            'order_by' => 'RecordTime DESC'
        ]);
    }
}