# yii2-thecsv
yii2 csv export extension

---
# yii2-thecsv（Yii2框架csv数据导出扩展）

## 1、安装
运行 `php composer.phar require m35/thecsv`  
或  
添加 `"m35/thecsv": "*"`

## 2、使用
```php
<?php
use m35\thecsv\theCsv;
theCsv::export('tableName'); // return true if success
```

## 3、参数及示例
### 3.0、参数列表
#### 3.0.1、string类型
直接指定表名称，下载该表所有数据，自动生成表字段名称。
#### 3.0.2、array类型参数
* 1. `table`：数据表名称 (`string`)
* 2. `fields`：要导出的表字段 (`array`)
* 3. `exceptFields`：是否是排除字段模式，默认false(`bool`)
* 4. `header`：自定义表头(`array`)
* 5. `condition`：导出表条件(`mixed`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-query.html#where()-detail
* 6. `limit`：限制数量(`int`)
* 7. `offset`：偏移(`int`)
* 8. `orderby`：排序(`mixed`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-querytrait.html#orderBy()-detail
* 9. `name`：自定义文件名(`string`)
* 10. `sql`：自定义SQL语句(`string`)
* 11. `bind`：与sql结合绑定参数(`array`)
* 12. `target`：导出目录，如果设置target，则默认行为由下载变为保存文件到服务器(`string`)
* 13. `fp`：直接导出数据到指定的资源(`resource`)
* 14. `data`：自定义导出数据(`array`)
* 15. `query`：Yii2框架Query类型资源(`yii\db\Query`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-query.html
* 16. `reader`：Yii2框架DataReader类型资源(`yii\db\DataReader`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-datareader.html

### 3.1、示例：导出数据表（以user表为例子）
#### 3.1.1、导出数据表完整数据
```php
theCsv::export('user');
```

### 3.1.2、导出user表的用户名和密码
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
]);
```

### 3.1.3、导出user表除status字段外的所有数据
```
theCsv::export([
    'table' => 'user',
    'fields' => ['status'],
    'exceptFields' => true,
]);
```

### 3.1.4、导出user表的用户名和密码，自定义表头
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
    'header' => ['账户', '密码'],
]);
```

### 3.1.5、导出user表的用户名和密码，不要表头
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
    'header' => 'no',
]);
```

### 3.1.6、导出user表有效用户，使用condition
```
theCsv::export([
    'table' => 'user',
    'condition' => ['status' => 1],
]);
```
condition请参考http://www.yiiframework.com/doc-2.0/yii-db-query.html#where()-detail

### 3.1.7、导出user表有效用户，使用orderby和limit
```
theCsv::export([
    'table' => 'user',
    'condition' => ['status' => 1],
    'orderby' => 'id DESC',
    'limit' => 10,
]);
```
### 3.1.8、自定义SQL
```
theCsv::export([
    'sql' => 'SELECT * FROM user',
]);
```

### 3.1.9、自定义SQL，绑定参数
```
theCsv::export([
    'sql' => 'SELECT * FROM user WHERE id = :id AND status = :status',
    'bind' => [':id' => 1, ':status' => 1],
]);
```

### 3.1.10、使用Query
```
theCsv::export([
    'query' => (new \yii\db\Query)->from('user'),
]);
```

### 3.1.11、使用reader
```
theCsv::export([
    'reader' => \Yii::$app->getDb()->createCommand('SELECT * FROM user')->query(),
]);
```

## 3.2、示例：导出数据
```
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
]);
```

## 3.3、示例：其他
### 3.3.1
```
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
    'name' => 'data.csv',
]);
```

### 3.3.2
```
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
    'name' => 'data.csv',    // 自定义导出文件名称
    'target' => './',        // 如果指定导出目录，则默认行为从下载变为保存到指定目录
]);
```

### 3.3.3
```
$fp = fopen('./data.csv', 'w');
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
    'fp' => $fp,    // 如果指定fp资源，则默认行为从下载变为直接写入该资源
]);
```
