<?php
namespace m35\thecsv;

class theCsv {

    public static function export($parameter)
    {
        if (is_string($parameter)) {
            $parameter = ['table' => $parameter];
            $db= \Yii::$app->getDb();
            $tables = $db->schema->getTableNames();
        }
        if (is_array($parameter)) {
            if ( ! empty($parameter['table'])) {
                if ( ! in_array($parameter['table'], $tables)) {
                    throw new \yii\web\HttpException(500, "table '{$parameter['table']}' not exists!");
                }
                $query = (new \yii\db\Query)->from($parameter['table']);
                if ( ! empty($parameter['limit'])) {
                    $query->limit($parameter['limit']);
                }
                if ( ! empty($parameter['orderby'])) {
                    $query->orderBy($parameter['orderby']);
                }
                if ( ! empty($parameter['condition'])) {
                    $query->where($parameter['condition']);
                }
                
                if ( ! empty($parameter['fields'])) {
                    $columns = $db->getSchema()->getTableSchema($parameter['table'])->getColumnNames();
                    $parameter['fields'] = array_intersect($parameter['fields'], $columns);
                    if ( ! empty($parameter['exceptFields'])) {
                        $parameter['fields'] = array_diff($columns, $parameter['fields']);
                    }
                    $query->select($parameter['fields']);
                }
                if (empty($parameter['header'])) {
                    $parameter['header'] = [];
                    foreach($db->getSchema()->getTableSchema($parameter['table'])->columns as $item) {
                        if (empty($parameter['fields']) or (! empty($parameter['fields']) && in_array($item->name, $parameter['fields']))) {
                            $parameter['header'][] = (empty($item->comment) ? \yii\helpers\Inflector::camel2words($item->name, true) : $item->comment) . '(' . $item->name . ')';
                        }
                    }
                }
                if (empty($parameter['name'])) {
                    $parameter['name'] = $parameter['table'] . '.csv';
                }
            } elseif ( ! empty($parameter['sql'])) {
                $command = $db->createCommand($parameter['sql']);
                if ( ! empty($parameter['bind'])) {
                    $command->bindValues($parameter['bind']);
                }
                $reader = $command->query();
            } elseif (! empty($parameter['query']) && empty($query)) {
                $query = $parameter['query'];
            } elseif (! empty($parameter['reader']) && empty($reader)) {
                $reader = $parameter['reader'];
            } elseif (empty($parameter['data'])) {
                throw new \yii\web\HttpException(500, "Not a valid parameter!");
            }

            if (empty($parameter['name'])) {
                $parameter['name'] = date('Y-m-d_H-i-s') . '.csv';
            }
            
            if ( ! empty($parameter['fp']) && is_resource($parameter['fp'])) {
                $fp =& $parameter['fp'];
            } else {
                if ( ! empty($parameter['target'])) {
                    $fp = fopen($parameter['target'] . $parameter['name'], 'w');
                } else {
                    header('Content-Type: text/csv');
                    header("Content-Disposition: attachment;filename={$parameter['name']}");
                    $fp = fopen('php://output', 'w');
                }
            }
            
            fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
            if ( ! empty($parameter['header']) && is_array($parameter['header'])) {
                fputcsv($fp, $parameter['header']);
            }
            if (isset($query)) {
                foreach ($query->each() as $row) {
                    fputcsv($fp, $row);
                }
            } elseif (isset($reader)) {
                foreach ($reader as $row) {
                    fputcsv($fp, $row);
                }
            } else if (isset($parameter['data'])) {
                foreach ($parameter['data'] as $row) {
                    fputcsv($fp, $row);
                }
            }
            return true;
        }
        throw new \yii\web\HttpException(500, "Not a valid parameter!");
    }

}