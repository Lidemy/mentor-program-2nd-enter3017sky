// curl -H 'Accept: application/vnd.twitchtv.v5+json' \
// -H 'Client-ID: uo6dggojyb8d6soh92zknwmi5ej1q2' \
// -X GET 'https://api.twitch.tv/kraken/streams/?game=Overwatch'
// var apiUrl = 'https://api.twitch.tv/kraken/streams/?clientId=' + clientId + '&game=League%20of%20Legends&limit=' + limit ;
// https://api.twitch.tv/kraken/streams?game=League%20of%20Legends&limit=2&client_id=eq990vt85o5dquacakpy5u32ofrmmt

// 把資料寫成變數，可讀性高，更改資料方便
// var clientId = 'eq990vt85o5dquacakpy5u32ofrmmt';
// var limit = 2;
// var apiUrl = 'https://api.twitch.tv/kraken/streams/?client_id=' + clientId + '&game=League%20of%20Legends&limit=' + limit ;

// // 我要一個新的 request , 首先 new 一個 XMLHttpRequest() 出來
// let request = new XMLHttpRequest();
// // 送到哪裡去
// request.open('GET', apiUrl, true);

// // 自訂義的標頭拿掉的話，Request 就會剩一個，就不會 Preflight Request 了
// request.setRequestHeader('client-id', clientId)
// request.send();
// // 加一個 callback function
// request.onload = function() {
//     if (request.status >= 200 && request.status < 400) {
//         var data = JSON.parse(this.responseText);
//         console.log(data);
//     }
// }


var request = new XMLHttpRequest();
var clientId = 'eq990vt85o5dquacakpy5u32ofrmmt';
var limit = 20;
var apiUrl = 'https://api.twitch.tv/kraken/streams/?client_id=' + clientId + '&game=League%20of%20Legends&limit=' + limit ;
request.open('GET', apiUrl, true);
request.onload = function() {
    if (request.status === 200) {
        // 成功的話 處理資料
        var data = JSON.parse(request.responseText);
        console.log(data)
        var cols = data.streams
        // 有 index 才取得到個別的資料
        console.log(cols[0])
        console.log(cols[0].channel.display_name)
        // console.log(cols[0].channel.name)
        console.log(cols[0].preview.medium)
        // console.log(cols[0].channel.status)
        // console.log(cols[0].channel.views)
        console.log(cols[0].channel.logo) 
        // console.log(cols[0].channel._links.videos) 
        // console.log(displayName)


        var row = document.querySelector('.row')
        for (var i = 0; i < cols.length; i++) {
            row.innerHTML +=`

            <div class='row'>
                <a href="${cols[i].channel.url}" target="_blank">
                    <div class='col'>
                        <div class='preview'>
                                <img src="${cols[i].preview.medium}" />
                            </div>
                            <div class='bottom'>
                            <div class='bottom__avatar'>
                                <img src="${cols[i].channel.logo}" />
                            </div>
                            <div class='bottom__intro'>
                                <div class='owner__name'>
                                    ${cols[i].channel.status}
                                </div>
                                <div class='channel__name'>
                                    ${cols[i].channel.display_name}
                                </div>
                                <span class='viewers'>${cols[i].channel.views}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>`
        }

    } else {
        alert('有什麼地方出錯了！！')
        // We reached our target server, but it returned an error
    }
};

request.onerror = function() {
  // There was a connection error of some sort
};

request.send();
