<?php

class Model
{
    private PDO $db;

    public function __construct(PDO $db_conn)
    {
        $this->db = $db_conn;
    }

    public function select_all($tablename)
    {
        $table = $this->safeTable($tablename);
        $query = $this->db->prepare("SELECT * FROM {$table}");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_data($table, $data)
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }

        $table = $this->safeTable($table, false);
        $columns = [];
        $placeholders = [];

        foreach ($data as $key => $val) {
            $column = $this->safeIdentifier($key);
            $columns[] = $column;
            $placeholders[] = ':' . $this->placeholderName($key);
        }

        $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $query = $this->db->prepare($sql);

        foreach ($data as $key => $val) {
            $query->bindValue(':' . $this->placeholderName($key), $val);
        }

        $insert = $query->execute();
        return $insert ? $this->db->lastInsertId() : false;
    }

    public function getRows($table, $conditions = array())
    {
        $params = [];
        $isCountQuery = ($conditions['return_type'] ?? null) === 'count' && !array_key_exists('group_by', $conditions);
        $select = $isCountQuery
            ? 'COUNT(*) AS row_count'
            : (array_key_exists('select', $conditions) ? $this->safeSqlFragment($conditions['select']) : '*');
        $sql = 'SELECT ' . $select . ' FROM ' . $this->safeTable($table);

        $sql .= $this->buildJoins($conditions);

        $where = $this->buildWhere($conditions, $params);
        if ($where !== '') {
            $sql .= ' WHERE ' . $where;
        }

        if (array_key_exists('group_by', $conditions)) {
            $sql .= ' GROUP BY ' . $this->safeColumnList($conditions['group_by']);
        }

        if (array_key_exists('order_by', $conditions)) {
            $sql .= ' ORDER BY ' . $this->safeOrderBy($conditions['order_by']);
        }

        if (array_key_exists('start', $conditions) && array_key_exists('limit', $conditions)) {
            $sql .= ' LIMIT ' . max(0, (int) $conditions['start']) . ',' . max(1, (int) $conditions['limit']);
        } elseif (!array_key_exists('start', $conditions) && array_key_exists('limit', $conditions)) {
            $sql .= ' LIMIT ' . max(1, (int) $conditions['limit']);
        }

        $query = $this->db->prepare($sql);
        foreach ($params as $name => $value) {
            $query->bindValue($name, $value);
        }
        $query->execute();

        if (array_key_exists('return_type', $conditions) && $conditions['return_type'] != 'all') {
            switch ($conditions['return_type']) {
                case 'count':
                    if ($isCountQuery) {
                        $row = $query->fetch(PDO::FETCH_ASSOC);
                        return (int) ($row['row_count'] ?? 0);
                    }
                    return $query->rowCount();
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    return !empty($data) ? $data : false;
                default:
                    return '';
            }
        }

        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return !empty($data) ? $data : false;
    }

    public function countRows($table, $conditions = array())
    {
        $params = [];
        $sql = 'SELECT COUNT(*) as total_row FROM ' . $this->safeTable($table);
        $where = $this->buildWhere($conditions, $params);

        if ($where !== '') {
            $sql .= ' WHERE ' . $where;
        }

        $query = $this->db->prepare($sql);
        foreach ($params as $name => $value) {
            $query->bindValue($name, $value);
        }
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['total_row'] ?? 0);
    }

    public function upDate($table, $data, $conditions)
    {
        if (empty($data) || !is_array($data) || empty($conditions) || !is_array($conditions)) {
            return false;
        }

        $table = $this->safeTable($table, false);
        $set = [];
        $params = [];
        $i = 0;

        foreach ($data as $key => $val) {
            $param = ':set_' . $i++;
            $set[] = $this->safeIdentifier($key) . ' = ' . $param;
            $params[$param] = $val;
        }

        $where = [];
        foreach ($conditions as $key => $value) {
            $param = ':where_' . $i++;
            $where[] = $this->safeIdentifier($key) . ' = ' . $param;
            $params[$param] = $value;
        }

        $sql = "UPDATE {$table} SET " . implode(', ', $set) . ' WHERE ' . implode(' AND ', $where);
        $query = $this->db->prepare($sql);

        foreach ($params as $name => $value) {
            $query->bindValue($name, $value);
        }

        $update = $query->execute();
        return $update ? $query->rowCount() : false;
    }

    public function delete($table, $conditions)
    {
        if (empty($conditions) || !is_array($conditions)) {
            return false;
        }

        $table = $this->safeTable($table, false);
        $where = [];
        $params = [];
        $i = 0;

        foreach ($conditions as $key => $value) {
            $param = ':delete_' . $i++;
            $where[] = $this->safeIdentifier($key) . ' = ' . $param;
            $params[$param] = $value;
        }

        $sql = "DELETE FROM {$table} WHERE " . implode(' AND ', $where);
        $query = $this->db->prepare($sql);

        foreach ($params as $name => $value) {
            $query->bindValue($name, $value);
        }

        $delete = $query->execute();
        return $delete ? $query->rowCount() : false;
    }

    public function log_out_user()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public function redirect($url, $fallback = './')
    {
        $target = is_string($url) ? trim($url) : $fallback;

        if ($target === '' || preg_match('/[\r\n]/', $target)) {
            $target = $fallback;
        }

        if (preg_match('#^https?://#i', $target)) {
            $host = parse_url($target, PHP_URL_HOST);
            $currentHost = $_SERVER['HTTP_HOST'] ?? '';
            if ($host === false || strcasecmp((string) $host, $currentHost) !== 0) {
                $target = $fallback;
            }
        }

        if (!headers_sent()) {
            header('Location: ' . $target, true, 302);
        }
        exit;
    }

    private function buildJoins(array $conditions): string
    {
        $sql = '';

        if (array_key_exists('join', $conditions)) {
            $sql .= ' INNER JOIN ' . $this->safeSqlFragment($conditions['join']);
        }

        if (array_key_exists('leftjoin', $conditions)) {
            $sql .= ' LEFT JOIN ' . $this->safeSqlFragment($conditions['leftjoin']);
        }

        if (array_key_exists('joinx', $conditions)) {
            foreach ($conditions['joinx'] as $key => $value) {
                $sql .= ' INNER JOIN ' . $this->safeTable($key, false) . $this->safeJoinClause($value);
            }
        }

        if (array_key_exists('joinl', $conditions)) {
            foreach ($conditions['joinl'] as $key => $value) {
                $sql .= ' LEFT JOIN ' . $this->safeTable($key, false) . $this->safeJoinClause($value);
            }
        }

        return $sql;
    }

    private function buildWhere(array $conditions, array &$params): string
    {
        $clauses = [];
        $i = 0;

        $this->appendValuePredicates($clauses, $params, $i, $conditions['where'] ?? [], '=');
        $this->appendValuePredicates($clauses, $params, $i, $conditions['where_not'] ?? [], '!=');
        $this->appendValuePredicates($clauses, $params, $i, $conditions['where_greater_equals'] ?? [], '>=');
        $this->appendValuePredicates($clauses, $params, $i, $conditions['where_lesser_equals'] ?? [], '<=');
        $this->appendValuePredicates($clauses, $params, $i, $conditions['where_lesser'] ?? [], '<');
        $this->appendValuePredicates($clauses, $params, $i, $conditions['where_greater'] ?? [], '>');

        if (!empty($conditions['null_check']) && is_array($conditions['null_check'])) {
            foreach ($conditions['null_check'] as $key => $value) {
                $normalized = strtoupper(trim((string) $value));
                if (!in_array($normalized, ['IS NULL', 'IS NOT NULL'], true)) {
                    throw new InvalidArgumentException('Unsafe NULL predicate.');
                }
                $clauses[] = $this->safeIdentifier($key) . ' ' . $normalized;
            }
        }

        return implode(' AND ', $clauses);
    }

    private function appendValuePredicates(array &$clauses, array &$params, int &$i, $predicates, string $operator): void
    {
        if (empty($predicates) || !is_array($predicates)) {
            return;
        }

        foreach ($predicates as $key => $value) {
            $param = ':w_' . $i++;
            $clauses[] = $this->safeIdentifier($key) . " {$operator} " . $param;
            $params[$param] = $value;
        }
    }

    private function safeTable($identifier, bool $allowAlias = true): string
    {
        $identifier = trim((string) $identifier);
        $pattern = $allowAlias
            ? '/^[A-Za-z0-9_`]+(?:\s+(?:AS\s+)?[A-Za-z0-9_`]+)?$/i'
            : '/^[A-Za-z0-9_`]+$/';

        if (!preg_match($pattern, $identifier)) {
            throw new InvalidArgumentException('Unsafe table identifier.');
        }

        return $identifier;
    }

    private function safeIdentifier($identifier): string
    {
        $identifier = trim((string) $identifier);
        if (!preg_match('/^[A-Za-z0-9_`]+(?:\.[A-Za-z0-9_`]+)?$/', $identifier)) {
            throw new InvalidArgumentException('Unsafe SQL identifier.');
        }

        return $identifier;
    }

    private function safeColumnList($columns): string
    {
        $columns = trim((string) $columns);
        if (!preg_match('/^[A-Za-z0-9_`.]+(?:\s*,\s*[A-Za-z0-9_`.]+)*$/', $columns)) {
            throw new InvalidArgumentException('Unsafe column list.');
        }

        return $columns;
    }

    private function safeOrderBy($orderBy): string
    {
        $orderBy = trim((string) $orderBy);
        $item = '[A-Za-z0-9_`.]+(?:\s+(?:ASC|DESC))?';
        if (!preg_match('/^' . $item . '(?:\s*,\s*' . $item . ')*$/i', $orderBy)) {
            throw new InvalidArgumentException('Unsafe order by clause.');
        }

        return $orderBy;
    }

    private function safeJoinClause($clause): string
    {
        $clause = $this->safeSqlFragment($clause);
        if (!preg_match('/^ON\s+[A-Za-z0-9_`.]+\s*=\s*[A-Za-z0-9_`.]+\s*$/i', $clause)) {
            throw new InvalidArgumentException('Unsafe join clause.');
        }

        return ' ' . $clause;
    }

    private function safeSqlFragment($fragment): string
    {
        $fragment = trim((string) $fragment);
        if ($fragment === '' || preg_match('/;|--|\/\*|\*\//', $fragment)) {
            throw new InvalidArgumentException('Unsafe SQL fragment.');
        }

        return $fragment;
    }

    private function placeholderName($key): string
    {
        return preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key);
    }
}
