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

## 3、参数
### 3.1、导出数据表（以user表为例子）
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

## 3.2、导出数据
```
theCsv::export([
    'data' => [
        ['a', 'b', 'c'],
        ['A', 'B', 'C'],
    ],
]);
```

## 3.3、其他示例
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
