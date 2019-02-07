/** 
 * note:
 * 
 * let id = el.parent().find('input:hidden').attr("id") => 是字串
 * list.length => 取得這個欄位的 index
 *
 */

import $ from "jquery";

$(document).ready(function() {
    // 對 input 加 keydown 的事件監聽
    // 按下 Enter 且內容不為空才送出
    
    var list = localStorage.getItem('todos') ? JSON.parse(localStorage.getItem('todos')) : [];

    // console.log(list.length === 0) 判斷陣列為空

        // 沒資料就 render 範例
    if(list.length === 0) {
        exampleTodo()
    }

        // 有資料就 render 待辦事項
    if(list.length > 0) {
        render(list)
    }


    console.log(list)

    // keydown 事件: 注音輸入法輸入完後按 enter 就會執行，不管按什麼都抓取到(注音、英文、數字、F1~F12、command、shift)
    // keypress 事件: 不會抓取到注音的部分。
    $('.add-todo').keypress(function(e) {
        if(e.key === 'Enter' && e.target.value !=''){
            addToDo({
                value: e.target.value,
                id: list.length,
                state: 0
            });
            // id++
            // list.length => 取得這個欄位的 index
            // console.log(list)
            $('.add-todo').val('')
        }
    })

    // addBtn 加 click 的事件監聽 && 按下時內容不為空才送出
    $('.addBtn').click(function(e) {
        if($('.add-todo').val() !== ''){
            let value = $('.add-todo').val()
            addToDo({
                value: value,
                id: list.length,
                state: 0
            });
            $('.add-todo').val('')
        }
    })

    $('.btn_group').click((e) => {
        const el = $(e.target)

        console.log(el)
        if(el.hasClass('done')) {
            console.log(list)
            render(list)
        }
        if(el.hasClass('undone')) {

            var done_list = list.filter(item => {
                return item.state === 1;
            });
            console.log(done_list)
            return render(done_list)
            // localStorage.setItem('todos', JSON.stringify(list))
        }
        if(el.hasClass('clear')) {
            list = []
            localStorage.clear()
            console.log('clear todo')
            console.log(localStorage)
            return render()
        }

    })

    $('.todo_list').click(function(e) {
        const el = $(e.target);
        if (el.hasClass('delete')) {
            /** 本來的方式：按下刪除後移除 todo-li */
            // el.parent().parent().fadeOut(500, function() {
            //     $(this).remove();
            // })

            let id = Number(el.parent().parent().find('input:hidden').attr("id"))
            removeTodo(id)

        } else if (el.hasClass('done')){
            let id = Number(el.parent().parent().find('input:hidden').attr("id"))

            checkTodo(id)

            // if(el.hasClass('todo__undone')) {
            //     el.addClass('btn-outline-success')
            //         .removeClass('btn-outline-primary')
            //         .removeClass('todo__undone')
            //         .text('完成')
            //         .parent().parent().removeClass('success');
            // } else {
            //     el.removeClass('btn-outline-success')
            //         .addClass('btn-outline-primary')
            //         .addClass('todo__undone')
            //         .text('未完成')
            //         .parent().parent().addClass('success');
            // }

        }
    })

    function addToDo(todo) {

        // 添加到陣列中
        list.push(todo)
        // 轉換成 JSON 格式再添加到 localStorage 
        localStorage.setItem('todos', JSON.stringify(list))
        render(list)
    }

    function checkTodo(id) {
        // 清空 localStorage
        localStorage.clear()
        // 用 forEach 遍歷陣列，找到符合的 id，改變狀態，資料處理完成再存入 localStorage，然後渲染畫面。
        list.forEach(item => {
            if(item.id == id) {
                if(item.state === 1) {
                    item.state = 0
                } else {
                    item.state = 1
                }
            }
        });
        localStorage.setItem('todos', JSON.stringify(list))
        return render(list)
    }

    function removeTodo(id) {
        localStorage.clear()
        console.log('before', list)
        list = list.filter(item => item.id !== id)
        console.log('after:', list)
        localStorage.setItem('todos', JSON.stringify(list))
        return render(list)
    }

    function exampleTodo() {
            $('.todo_list').append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">新增第一筆代辦事項吧！
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-success done">完成</button>
                    <button type="button" class="btn btn-outline-danger delete">刪除</button>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center success">
                完成第一個待辦事項！
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-primary done todo__undone">未完成</button>
                    <button type="button" class="btn btn-outline-danger delete">刪除</button>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">練習 JavaScript
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-success done">完成</button>
                    <button type="button" class="btn btn-outline-danger delete">刪除</button>
                </div>
            </li>`)
    }

    function render(data = []){
        // 先清空，然後再 render
        $('.todo_list').empty()
        // console.log(item)
        
        $('.todo_list').append(data.map(item => {

            // 用 item.state 判斷狀態
            var successTag = item.state ? 'success' : '';
            var state = item.state ?
            '<button type="button" class="btn btn-outline-primary done todo__undone">未完成</button>' :
            '<button type="button" class="btn btn-outline-success done">完成</button>';
            return `
            <li class="list-group-item d-flex justify-content-between align-items-center ${successTag}">${item.value}
                <input type='hidden' id='${item.id}' />
                <input type='hidden' data-state='${item.state}' />
                <div class="btn-group" role="group" aria-label="Basic example">
                    ${state}
                    <button type="button" class="btn btn-outline-danger delete">刪除</button>
                </div>
            </li>`
        }))
    }
})

