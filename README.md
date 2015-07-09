# yii2-thecsv
yii2 csv export extension
## 1. Install
Run `php composer.phar require m35/thecsv`  
or  
Add `"m35/thecsv": "*"` in your composer.json file.

## 2. Usage
```php
<?php
use m35\thecsv\theCsv;
theCsv::export('tableName'); // return true if success
```

## 3. Parameters & Examples
### 3.0 Parameters
#### 3.0.1 string type
You can specify a table name as the parameter, and it would export all the data of the table and automatically generate the table fields name as csv header.

#### 3.0.2 array type

* 1. `table`：table name (`string`)
* 2. `fields`：the table fields you want to export, it would export all the fields if you not set (`array`)
* 3. `exceptFields`：except the table fields you set above if ture，default to false(`bool`)
* 4. `header`：the csv header(`array`)
* 5. `condition`：use the condition in where part with the table(`mixed`). for details: http://www.yiiframework.com/doc-2.0/yii-db-query.html#where()-detail
* 6. `limit`：limit with the table(`int`)
* 7. `offset`：offset with the table(`int`)
* 8. `orderby`：order by with the table(`mixed`). for details: http://www.yiiframework.com/doc-2.0/yii-db-querytrait.html#orderBy()-detail
* 9. `name`：the export file name. e.g. `'data.csv'`, automatically generate if you not set(`string`)
* 10. `sql`：use the SQL syntax to export the data(`string`)
* 11. `bind`：bind values with the SQL syntax(`array`)
* 12. `target`：the directory name you want to save the file, it would turn the behavior to save the file on server other than downloading the file(`string`)
* 13. `fp`：you can directly specify the resource to put the data(`resource`)
* 14. `data`：directly set the export data other than selecting from table(`array`)
* 15. `query`：Yii2 Framework Query object(`yii\db\Query`). for details: http://www.yiiframework.com/doc-2.0/yii-db-query.html
* 16. `reader`：Yii2 Framework DataReader object(`yii\db\DataReader`). for details: http://www.yiiframework.com/doc-2.0/yii-db-datareader.html


### 3.1 Examples: export the table data（assume we have a table named 'user'）
#### 3.1.1 Export all data from 'user' table
```php
theCsv::export('user');
```

### 3.1.2 Export just 'username' and 'password' fields of the 'user' table
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
]);
```

### 3.1.3 Export data without 'status' field
```
theCsv::export([
    'table' => 'user',
    'fields' => ['status'],
    'exceptFields' => true,
]);
```

### 3.1.4 Export just 'username' and 'password' fields of the 'user' table and specify the csv header
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
    'header' => ['Username', 'Password'],
]);
```

### 3.1.5 Export the data without header
```
theCsv::export([
    'table' => 'user',
    'fields' => ['username', 'password'],
    'header' => 'no',
]);
```

### 3.1.6 Export the active user data using condition 
```
theCsv::export([
    'table' => 'user',
    'condition' => ['status' => 1],
]);
```
for details: http://www.yiiframework.com/doc-2.0/yii-db-query.html#where()-detail

### 3.1.7 Export the active user data using condition, orderby and limit
```
theCsv::export([
    'table' => 'user',
    'condition' => ['status' => 1],
    'orderby' => 'id DESC',
    'limit' => 10,
]);
```
### 3.1.8 Using SQL syntax
```
theCsv::export([
    'sql' => 'SELECT * FROM user',
]);
```

### 3.1.9 Using SQL syntax and bind values
```
theCsv::export([
    'sql' => 'SELECT * FROM user WHERE id = :id AND status = :status',
    'bind' => [':id' => 1, ':status' => 1],
]);
```

### 3.1.10 Using Query object
```
theCsv::export([
    'query' => (new \yii\db\Query)->from('user'),
]);
```
for details: http://www.yiiframework.com/doc-2.0/yii-db-query.html

### 3.1.11 Using DataReader object
```
theCsv::export([
    'reader' => \Yii::$app->getDb()->createCommand('SELECT * FROM user')->query(),
]);
```
for details: http://www.yiiframework.com/doc-2.0/yii-db-datareader.html

## 3.2  Example: export data
```
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
]);
```

## 3.3、Examples: other
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
    'name' => 'data.csv',    // file name
    'target' => './',        // the directory you want to save the file other than downloading it
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
    'fp' => $fp,    // fp resource you want to put the data in
]);
```
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
* 15. `query`：Yii2框架Query类型对象(`yii\db\Query`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-query.html
* 16. `reader`：Yii2框架DataReader类型对象(`yii\db\DataReader`) 请参考http://www.yiiframework.com/doc-2.0/yii-db-datareader.html

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
