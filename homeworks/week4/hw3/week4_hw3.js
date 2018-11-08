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

function getData(cb) {
    const clientId = 'eq990vt85o5dquacakpy5u32ofrmmt';
    const limit = 20;

    var request = new XMLHttpRequest();
    request.open('GET', 'https://api.twitch.tv/kraken/streams/?client_id=' + clientId + '&game=League%20of%20Legends&limit=' + limit , true);

        // // 加一個 callback function
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            // 用 JSON.parse，把 JSON 格式轉乘 javascript 的物件
            var data = JSON.parse(request.responseText);

            // console.log(data);

            cb(null, data);
        } else {
            // We reached our target server, but it returned an error
        }
    };
    request.onerror = function() {
    // There was a connection error of some sort
    };
    request.send();

}


getData((err, data) => {
    //const (streams)=data;
    const streams = data.streams;

    const $row = $('.row');
    for(var i = 0; i < streams.length; i++){
        $row.append(getColumn(streams[i]));
    }
    // //ES6 的寫法
    // for(let stream of streams) {
    //     $row.append(getColumn(stream));
    // }
});



// return 每一個 col 的 html
function getColumn(data) {
    return `
    <a target="_blank" href="https://www.twitch.tv/${data.channel.name}">
        <div class='col'>
            <div class='preview'>
                <img src='${data.preview.medium}' />
            </div>
            <div class='bottom'>
                <div class='bottom_avatar'>
                    <img src='${data.channel.logo}' />
                </div>
                <div class='bottom__intro'>
                    <div class='owner__name'>
                        ${data.channel.status}
                    </div>
                    <div class='channel__name'>
                        ${data.channel.display_name}
                    </div>
                    <span class='viewers'>Viewers: ${data.viewers}</span>
                </div>
            </div>
        </div>
    </a>`;
}

