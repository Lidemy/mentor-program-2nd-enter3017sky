# week11 Express

> 我要解決什麼問題：將留言版移植到 _express_

### 設置環境與基礎配置

1. `yarn init` 初始化這個專案

2. `yarn add express` 安裝 _express_

3. 在 `index.js` 輸入這個範例並使用 `node index.js` 跑跑看，然後在瀏覽器輸入 `localhost:3000` 查看是否成功執行而顯示 __Hello World!__。

```js
/* 把 express import 進來 */
const express = require('express');
/* 執行 express Function ，就會有一個 app 的 instance */
const app = express();

/* 到這個 / 路徑會執行 callback function 執行些什麼事 */
app.get('/', (request, response) => {
    response.send('Hello World!');
})

/* 監聽 3000 port，或成功執行就 console.log 資訊出來 */
app.listen(3000)

app.listen(3000, () => {
    console.log('Example app listening on port 3000!')
})
```

做到這個步驟，就有一個 _Server_ 了。

---

- Route: 用決定 URL 會跑到哪一個 function 去

```js
app.get('/', function(req, res) {
    res.send('Hello World')
})

app.get('/test', function(req, res) {
    res.send('<h1>Hello World</h1>')
})
```

- 第一個範例，第一個參數 `/` 就代表路徑是根目錄 _localhost:3000/_ 會印出 `Hello World`

- 第二個範例，第一個參數是 `/test`，所以當你在 _localhost:3000/test_ 會印出 `<h1>Hello World</h1>`

---

使用 `app.get('/path', (request, response) => {})` 的 request 參數的 query 屬性要求資料，透過 response.send 取得資料。

```js
app.get('/test', (request, response) => {
    response.send(request.query);
    console.log(request.query);
})
```

當我們輸入 `http://localhost:3000/test?a=Hello&b=World`

- `response.send(request.query)`: 結果會輸出在網頁上，但自行轉成 JSON 格式了。

<!-- {"a":"Hello","b":"World"} -->

- `console.log(request.query)`: 輸出在 _console_ 上

<!-- { a: 'Hello', b: 'World' } -->

當我們輸入 `http://localhost:3000/test?name=barfoobaz` 就會顯示 _barfoobaz_


```js
app.get('/test', (request, response) => {
    response.send(`<h1>${request.query.name}</h1>`);
})
```

---

### Controller

通常會用來跟 Model 溝通，然後把資料傳進 View，把結果傳回去。

```js
app.get('/', (req, res) => {
    var data = Model.getPost(1)
    res.render("post", data)
})
```

### View

只用來處理顯示相關的邏輯，藉此把資料處理跟顯示切開，有多種模板引擎(template engine)


### 使用 template engine

> [EJS -- Embedded JavaScript templates](https://ejs.co/)

- 在專案目錄底下輸入 `yarn add ejs` 來安裝 EJS 模板引擎。

- 然後 `mkdir views` 新增一個 views 的資料夾

- 在 _views_ 資料下裡面 `touch index.ejs navbar.ejs` 新增 _index.ejs navbar.ejs_ 兩個檔案

```js
/* 此時目錄的結構 */
week11
    +---- views
    |       +--- index.ejs
    |       +--- navbar.ejs
    +--- app.js
```

- 在一開始的 _app.js_ 中，加上一行 `app.set('view engine', 'ejs')` 設定我們的模板引擎是 _EJS_。

- `app.get()` 裡面使用 `response.render()` 載入 ejs 的 view file。

- 第一個參數傳進 _views_ 的 _index.ejs_，第二個參數傳進一個物件，把 _request.query.name_ 傳去 _title_ 如果沒有用 get 傳入參數 title 就顯示 default。

> notes: EJS 預設的資料是 _views_，所以根目錄就是 views 之下。


```js
const express = require('express');
const app = express();

app.set('view engine', 'ejs')

/* Controller */
app.get('/', (request, response) => {
    // response.send('Hello World!');
    response.render('index', {
        title: request.query.name || 'default'
    })
})

app.listen(3000, () => {
    console.log('Example app listening on port 3000!')
})
```


### EJS

- `<%=` HTML escape 跳脫輸出

- `<%-` HTML unescape 不跳脫輸出


```js
Tags
<% 'Scriptlet' tag, for control-flow, no output
<%_ ‘Whitespace Slurping’ Scriptlet tag, strips all whitespace before it
<%= Outputs the value into the template (HTML escaped)
<%- Outputs the unescaped value into the template
<%# Comment tag, no execution, no output
<%% Outputs a literal '<%'
%> Plain ending tag
-%> Trim-mode ('newline slurp') tag, trims following newline
_%> ‘Whitespace Slurping’ ending tag, removes all whitespace after it

```

### Model

在 express 裡面沒有硬性規定要這一層，但加上去比較好透過 Model 來跟資料溝通。

```js
/* 示意 */
function getPost(id) {
    return ...// get data from database
}
```

- 在根目錄建立 _model_ 目錄，裡面新增一個 _user.js_。
- 把 _user.js_ export 出去，模擬從 database 拿取資料。

```js
/* user.js */
module.exports = {
    getUser: (id, callback) => {
        // get user from database
        callback({
            name: 'Clark',
            id: 123
        })
    }
}
```

```js
/* 此時目錄的結構 */
week11
    +--- views
    |       +--- index.ejs
    |       +--- navbar.ejs
    +--- model
    |       +--- user.js
    +--- app.js
```

- 在 _app.js_ 新增 `const userModel = require('./model/user');`

- `userModel.getUser(id, (user))` 這個部分要注意，

```js
const express = require('express');
const app = express();

const userModel = require('./model/user');

app.set('view engine', 'ejs')

app.get('/', (request, response) => {
    // response.send('Hello World!');
    const id = request.query.id
    userModel.getUser(id, (user) => {
        response.render('index', {
            title: user.name || 'default'
        });
    })
})

app.listen(3000, () => {
    console.log('Example app listening on port 3000!')
})
```

---

### mysql

> [mysqljs/mysql: A pure node.js JavaScript Client implementing the MySql protocol.](https://github.com/mysqljs/mysql)

- 輸入 `yarn add mysql` 安裝 node 驅動的 mysql

```js
/* Establishing connections 建立連接 */
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'http://enter3017sky.tw/phpmyadmin',
  user     : 'bob',
  password : 'secret'
});

connection.connect(function(err) {
  if (err) {
    console.error('error connecting: ' + err.stack);
    return;
  }

  console.log('connected as id ' + connection.threadId);
});
```

notes:

- `host: 'enter3017sky.tw/'`: host 路徑後面帶斜線會跳錯誤訊息
- `host: 'enter3017sky.tw'`: 連線正常。

```
error connecting: Error: getaddrinfo ENOTFOUND enter3017sky.tw/ enter3017sky.tw/:3306
    at GetAddrInfoReqWrap.onlookup [as oncomplete] (dns.js:57:26)
```


### express-session

- express-session 機制

- `yarn add express-session` 安裝中介軟體(middleware)

- `const session = require('express-session')` 引入這個模組。

```js
const express = require('express');
const session = require('express-session')
const app = express();

app.set('view engine', 'ejs')

app.use(session({
    secret:'keyboard cat',
    cookie: {
        maxAge:6000
    }
}))

app.get('/', (request, response) => {
    const id = request.query.id
    const username = request.session.username
    userModel.getUser(id, (user) => {
        response.render('index', {
            title: username ? username : 'not login'
        });
    })
})
app.get('/login', (request, response) => {
    request.session.username = 'enter3017sky'
    response.send('login success')
})
app.get('/logout', (request, response) => {
    request.session.destroy();
    response.send('clear session')
})
app.listen(3000, () => {
    console.log('Example app listening on port 3306!')
})
```

### express 與 static file

> 參考資料: [express.static 作用及用法](https://blog.csdn.net/DlMmU/article/details/55551147)

靜態檔案

- `app.use(express.static('public'))`
- app.use(express.static(__dirname + '/public')); // 設置靜態文件目錄
- app.use(express.static(path.join(__dirname, 'public'))); // 和上面是一樣的
正如註釋中寫的那樣，這句話的意思是，將靜態文件目錄設置為項目根目錄 + /public，當然你也可能是這麼寫的：

- 錯誤的寫法：`app.use(express.static('/public'))`: 多反斜線，這樣寫會有問題！

### Sequelize - ORM(物件關聯對映 Object Relational Mapping) for Node.js

直接用操作 Object 的方式與 DB 裡面的資料做對應。


1. 定義 MySQL 的架構(schema)

```js
const User = sequelize.define('user', {
    firstName: {
        type: Sequelize.STRING
    },
    lastName: {
        type: Sequelize.STRING
    }
});
```

2. 建立 database

```js
User.create({ firstName: 'foo', lastName: 'bar'})
    .then(task => {
        // 建立完成。
    })
User.findAll({
    where: {
        firstName: 'foo'
    }
})
```

#### Sequelize 參數設定

##### Sequelize-關閉提醒

![image](https://raw.githubusercontent.com/enter3017sky/mentor-program-2nd-blog/master/picture/%E8%9E%A2%E5%B9%95%E5%BF%AB%E7%85%A7%202019-02-20%2020.13.27.png)

突然覺得提示很煩，要把它們清除掉，最後「_sequelize deprecated String based operators are now deprecated_...」這段提示找了好一回兒，後來才發現原來預設的範例中就有這行了XD

- 添加這行 `operatorsAliases: false`

- 添加 `logging: false`: 關掉 _Executing (default)..._。

```js
//use sequelize without any operators aliases
const Sequelize = require('sequelize');
const sequelize = new Sequelize('database', 'username', 'password', {
    host: 'localhost',
    dialect: 'mysql'|'sqlite'|'postgres'|'mssql',

    operatorsAliases: false,
    logging: false,
});
```

```js
sequelize deprecated String based operators are now deprecated. Please use Symbol based operators for better security, read more at http://docs.sequelizejs.com/manual/tutorial/querying.html#operators node_modules/sequelize/lib/sequelize.js:242:13
Example app listening on port 3306!
Executing (default): SELECT 1+1 AS result
Connection has been established successfully.
```

參考資料：[Why does sequelize print the resulting SQL to console.log by default? · Issue #3018 · sequelize/sequelize](https://github.com/sequelize/sequelize/issues/3018#issuecomment-71808347)

[sequelize deprecated String based operators are now deprecated.](http://docs.sequelizejs.com/manual/tutorial/querying.html#operators)



```js
sequelize deprecated Model.find has been deprecated, please use Model.findOne instead node_modules/sequelize/lib/model.js:4212:9
```

```js
// model.js:4212:9
Model.find = function () {
  Utils.deprecate('Model.find has been deprecated, please use Model.findOne instead');
  return Model.findOne.apply(this, arguments);
};
```


#### body-parser 關閉提醒

```js
body-parser deprecated undefined extended: provide extended option app.js:14:20
```

- `app.use(bodyParser.urlencoded(__{ extended: false}__));`

1. extended - 当设置为false时，会使用 querystring 库解析URL编码的数据；
    当设置为true时，会使用qs库解析URL编码的数据。后没有指定编码时，使用此编码。默认为true

參考資料：[Express 中間件body-parser 原理分析](https://www.pandashen.com/2018/08/28/20180828022147/)

[Nodejs 進階：Express 常用中間件body-parser 實現解析- 程序猿小卡- 博客園](https://www.cnblogs.com/chyingp/p/nodejs-learning-express-body-parser.html)

---

### 使用 nodemon 自動刷新

> [nodemon | Yarn](https://yarnpkg.com/zh-Hans/package/nodemon)

- `yarn add nodemon`

- 在專案的 package.json 加上以下，就能在輸入 `$ yarn run start` 來執行這個插件的功能。

```js
  "scripts": {
    "start": "nodemon ./hw1/app.js"
  },
```


### Environment Variable 環境變數

> 將敏感資訊存在環境變數裡面帶進去 app 裡執行。

- _process.env.PWD_
- 指令由原本的 `node app.js` 變成 `PWD=1234 node app.js` 

```js
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'enter3017sky.tw/',
  user     : 'root',
  password : process.env.PWD || '',
  database: 'enter3017sky_db'
});
```

### Error notes

> 參考資料：[MySQL 5.7 排除錯誤 ERROR 1819 (HY000) - BrilliantCode.net](https://www.brilliantcode.net/404/mysql-5-7-error-1819-hy000-validate-password-policy/)

> [無法遠端連接MySQL：message from server: "Host xxx is not allowed to connect to this MySQL server" @ 符碼記憶](https://www.ewdna.com/2011/09/mysqlmessage-from-server-host-xxx-is.html)

- 關於 Mysql 連線，目前的理解是，當檔案放在遠端的資料庫，該檔案連線資料庫的 host 就是 localhost，但當你本機端的檔案要連線遠端的資料庫，host 就是遠端資料庫的 ip 或 DNS。

- 本機端連線到 ec2 mysql  顯示 `Error: connect ETIMEDOUT`，最後直接在 ec2 操作，host 改為 localhost 就一切正常了

> host     : '52.194.8.58',
> host     : 'localhost',

```js
 node app.js
Example app listening on port 3306!
/Users/enter3017sky/Documents/mentor-program-2nd-enter3017sky/homeworks/week11/hw1/app.js:23
    if (err) throw err;
             ^
Error: connect ETIMEDOUT
    at Connection._handleConnectTimeout (/Users/enter3017sky/Documents/mentor-program-2nd-enter3017sky/homeworks/week11/node_modules/mysql/lib/Connection.js:411:13)
```

- 經過這幾天踩了 mysql 的大坑，總算有點心得了，mysql 的 _root_ 預設不能當作遠端的帳號連線，出現以下的錯誤後 google 後才知道，local 端要連遠端的資料庫(aws ec2)，有兩種辦法，第一種是設定 _root_ 的權限，讓它可以作為遠端的連線，考量到安全性更推薦第二種做法，新增遠端連線並設定權限給使用者。
。

```
throw err; // Rethrow non-MySQL errors
^
Error: ER_HOST_NOT_PRIVILEGED: Host '122.100.79.168' is not allowed to connect to this MySQL server
```

#### 新增 mysql 遠端連線的使用者

補充資料：[Node.js-Backend見聞錄(11)：關於後端觀念(七)-如何設定資料庫
](https://ithelp.ithome.com.tw/articles/10194991)

1. 使用別名我設定的別名 `ssh ec2` 連線到 _AWS EC2_，連線後 `mysql -u root -p` 以我們最常使用的 _root_ 身份登入。

2. `use mysql;`：選擇 database。

3. ｀GRANT LL ON your_dbNAME.your_tableNAME TO your_USERNAME@'%' identified by 'your_PASSWORD';｀：輸入這行指令創建遠端連線用的使用者。

- 但是一直遇到這個錯誤訊息：`ERROR 1819 (HY000): Your password does not satisfy the current policy requirements`。

- 打上指令檢查 mysql 密碼的安全性規則，`select @@validate_password_length;` 、 `select @@validate_password_policy;`

```mysql
mysql> select @@validate_password_length;
+----------------------------+
| @@validate_password_length |
+----------------------------+
|                          8 |
+----------------------------+
1 row in set (0.00 sec)

mysql> select @@validate_password_policy;
+----------------------------+
| @@validate_password_policy |
+----------------------------+
| MEDIUM                     |
+----------------------------+
1 row in set (0.00 sec)

mysql> grant all on enter3017sky_db.* TO enter3017sky@'%' identified by '????';
Query OK, 0 rows affected, 1 warning (0.00 sec)
mysql> exit;
Bye
```

#### express - mysql: __Error: connect ETIMEDOUT__

一切都豁然開朗了！卡了好幾天的 mysql 連線時 __Error: connect ETIMEDOUT__ ，前因後果都連貫起來了。一直爬文但是一直搞不清楚到底是哪邊的問題，搞到後來都開始懷疑人生了。

原本不知道 root 預設不能使用遠端連線，所以像以下這樣在 local 端連線，才會一直噴 __Error: connect ETIMEDOUT__，EC2 的 _Security Group_ 設定好之後，錯誤訊息就變成： `Error: ER_ACCESS_DENIED_ERROR: Access denied for user 'root'@'122.100.79.168' (using password: YES)` ，然後我才知道原來是醬啊...

```js
var connection = mysql.createConnection({
    host     : 'enter3017sky.tw',
    user     : 'root',
    password : process.env.PWD || '',
    database: 'enter3017sky_db',
});
```

原來最大的問題是 _AWS EC2_ 的 _Instance_ 分配給它的 _Security Group_ 沒有設定好，個人目前的理解是 EC2 就是一台遠端的電腦，只是都用指令來操作，總而言之，在 _Security Group_ 的 _Inbound(入站規則)_ 裡面沒有打開給 mysql 的 port(3306)，所以才會噴出來的錯誤訊息總是 __Error: connect ETIMEDOUT__。

### AWS EC2 & express

> 參考資料:[Tutorial: Creating and managing a Node.js server on AWS, part 1](https://hackernoon.com/tutorial-creating-and-managing-a-node-js-server-on-aws-part-1-d67367ac5171)

- 我主機使用 AWS EC2，在練習的程式碼當中，譬如說監聽 port 3000，`app.listen(3000,...`，在 EC2 的 _Security Group_ 就要新增一個 _custom TCP rule_ 給我們的 express 使用。

```js
const express = require('express');
const app = express();
var mysql      = require('mysql');
var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : process.env.PWD || '',
    database: 'enter3017sky_db',
});
connection.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
  });
connection.query('SELECT 1 + 1 AS solution', function(err, rows, fields) {
  if (err) throw err;
  console.log('The solution is: ', rows[0].solution);
});
connection.end();
app.listen(3000, () => {
    console.log('Example app listening on port 3306!')
})
```

#### express 在 EC2 執行與停止的方式

> 參考資料：[Linux-中-fg、bg、jobs 指令](https://ehlxr.me/2017/01/18/Linux-%E4%B8%AD-fg%E3%80%81bg%E3%80%81jobs%E3%80%81-%E6%8C%87%E4%BB%A4/)

1. `node app.js` 執行，然後 _control + C_ 終止。

- 終止後 3000 port 就不能連線了。

```js
$ node app.js
Example app listening on port 3306!
Connected!
^C
```

2. `node app.js` 執行，然後 _control + z_ 將前台的任務丟到後台並暫停。

```js
$ node app.js
Example app listening on port 3306!
Connected!
^Z
[1]+  Stopped                 node app.js
```

- `bg %1`: 讓工作編號 1 的程序繼續執行。

- `kill %1`: 或終止工作編號 1 的程序。

- 也可以使用 `ps -ef` 查看程序的狀態，然後用 `kill PID` 終止程序。

> [程式扎記: [Linux 小學堂] Linux 程序管理 ( ps -l / ps aux / ps axjf )](http://puremonkey2010.blogspot.com/2011/02/linux-linux-ps-l-ps-aux-ps-axjf.html)


### Sequelize-auto

> 使用 Sequelize 要做有關 model(資料庫相關) 的操作發現定義資料庫的架構挺麻煩的，所以找到這個插件，可以幫助我們從資料庫自動產生 Sequelize 的 model。
> 參考資料: [sequelize-auto从数据库表自动生成Sequelize模型(Model)](https://itbilu.com/nodejs/npm/41mRdls_Z.html)


1. 怕操作不當，先從 phpmyadmin 匯出資料庫

    - 確定連線正常(-h 指定 host，以便連上 aws ec2-mysql)： `mysql -h hostname -u username -p password`


2. 安裝 `yarn add sequelize-auto`

- 執行 `
sequelize-auto -o "./models" -d your_db_name -h your_host_name -u your_username -p your_port -x your_password -e [資料庫類型。預設 mysql]
`

```js
// 結果出現
zsh: command not found: sequelize-auto
```

- `npm install -g sequelize-auto`

```js
/usr/local/bin/sequelize-auto -> /usr/local/lib/node_modules/sequelize-auto/bin/sequelize-auto
+ sequelize-auto@0.4.29
added 218 packages from 226 contributors in 27.342s
```

- 執行後

```
sequelize-auto -o "./models" -d Test_hw11_user -h enter3017sky.tw -u enter3017sky -p 3306 -x JI#94su3 -e mysql           12:54:01 
/usr/local/lib/node_modules/sequelize-auto/node_modules/sequelize/lib/dialects/mysql/connection-manager.js:24
      throw new Error('Please install mysql package manually');
      ^
Error: Please install mysql package manually
```

- `npm install -g mysql`

```
Executing (default): SHOW TABLES;
Executing (default): SELECT  ... 'enter3017sky_db';
Executing (default): DESCRIBE `Test_hw11_user`;
Executing (default): DESCRIBE `about`;
Executing (default): DESCRIBE `articles`;
Executing (default): DESCRIBE `blog_user`;
Executing (default): DESCRIBE `categories`;
Executing (default): DESCRIBE `comments`;
Executing (default): DESCRIBE `enter3017sky_comments`;
Executing (default): DESCRIBE `enter3017sky_user`;
Executing (default): DESCRIBE `jobs`;
Executing (default): DESCRIBE `jobs_audit`;
Executing (default): DESCRIBE `orders`;
Executing (default): DESCRIBE `products`;
Executing (default): DESCRIBE `taxonomy`;
Done!
```

## 模組使用心得

- 結果看一下檔案，因為語法跟老師範例中的不同，一時之間不知道怎麼使用，紀錄以下理解的過程。

- [第 8 章 - 模組 · 專為中學生寫的 JavaScript 程式書](https://ccckmit.gitbooks.io/javascript/content/ch8/chapter8.html) 從這裡說，以下的方式是靜態模組。

```js
// 老師的範例    /models/user.js

// 載入相依的模組(下面用得到)
const Sequelize = require('sequelize');
const sequelize = require('./conn')
const User = sequelize.define('user_blog', {
        username: {
            type: Sequelize.STRING
        },
        password: {
            type: Sequelize.STRING
        }
    }, {
        tableName: 'user_blog'
    })
module.exports = User


//  /controller/user.js
// 引入上面的檔案
const User = require('../models/user.js')

User.create(insertValue)
    .then((data) => {
        req.session.username = req.body.username;
        return res.redirect('/')
    }).catch((err) => {
        console.log(err)
    })
```

- 範例中的方式是在 model 底下的 _user.js_(處理會員登入註冊相關)，在文件開頭引入其他的相依模組。然後在 controller 底下的 _user.js_(處理使用者登入註冊操作過程的邏輯) 直接使用它。

- 下面範例中，語法更是簡潔了，與上面的 `const User = sequelize.define()...` 與 `module.exports = User`，先定義在導出相比，直接就來 `module.exports = ...` 了，讓我整個糊塗了，透過 sequelize-auto 從資料庫參照而自動生成的定義確實省下我不少時間，踩著坑繼續往上爬，省下的時間用來熟習語法之間的變化！

```js
// 透過 sequelize-auto 產生的 /models/user.js

module.exports = function(sequelize, DataTypes) {
    return sequelize.define('blog_user', {
        username: {
            type: DataTypes.STRING(256),
            allowNull: false,
            unique: true
        },
        password: {
            type: DataTypes.STRING(512),
            allowNull: false
        }
    }, {
        tableName: 'blog_user'
    });
};

```

- 參考至這篇的思路 [How to use Sequelize with Node and Express | Codementor](https://www.codementor.io/mirko0/how-to-use-sequelize-with-node-and-express-i24l67cuz) ，花了一些時間吸收，嘗試了一下之後，大致上是理解了，總而言之，他的方式是把 model 相關的邏輯都放入自定義的 _sequelize.js_ 之中，處理好相依性，把需要用到的檔案導出。



```js
const Sequelize = require('sequelize');
const sequelize = require('../model/conn')

const userModel = require('../models/blog_user')
const User = userModel(sequelize, Sequelize)


// const User = require('../model/user')


// password hash
const bcrypt = require('bcrypt')

module.exports = {
    index: function(req, res) {
        const user = req.session.username
        res.render('index', {
            user: user ? user : null,
            title: 'enter3017sky Blog'
        })
    },
    login: function(req, res) {
        // console.log('User: ', User, '\n\n')
        // console.log('UserModel: ', userModel, '\n\n')
        const user = req.session.username;
        res.render('loginAndRegister', {
            user: user ? user: null,
            title: 'Login & Sign up'
        })
```

### 錯誤處理：_Unknown column 'createdAt'_

> Unhandled rejection SequelizeDatabaseError: Unknown column 'createdAt' in 'field list'

- 在 tableName 下面加上 `timestamps: false, createdAt: 'created_at'`

```js
/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
    return sequelize.define('articles', {
        id: {
        type: DataTypes.INTEGER(11),
        allowNull: false,
        primaryKey: true,
        autoIncrement: true
        },
        ... 略
        }
    }, {
        tableName: 'articles',
        timestamps: false,
        createdAt: 'created_at'
    });
};

```


### 模組使用之解構賦值

```js
// a.js
const a = () => 'Hi';
const b = () => 'Hey';
const c = () => 'yo';
module.exports = { a, b ,c }

// b.js
const a = require('./a.js')
console.log(a)
// => { a: [Function: a], b: [Function: b], c: [Function: c] }

// b.js
const { a } = require('./a.js')
console.log(a)
// => [Function: a]


```





### 獲取文章 id

- 取得 id: `app.get('/posts/:id', userController.posts)`

```js
posts: function(req, res) {
    // 印出來看看 { id: '15' }
    console.log(req.params)
    Post.findAll({
        where: {
            // 取得 id
            id: req.params.id
        }
    })
},
```