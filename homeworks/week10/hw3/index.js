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

    var list = []
    function addToDo(todo) {
        list.push(todo)
        render()
    }

    function removeTodo(id) {
        list = list.filter(item => item.id !== id)
        return render()
    }

    function render(){
        // 先清空，然後再 render
        $('.todo_list').empty()
        // console.log(item)

        $('.todo_list').append(list.map(item =>`
            <li class="list-group-item d-flex justify-content-between align-items-center">${item.value}
                <div class="btn-group" role="group" aria-label="Basic example">
                    <input type='hidden' id='${item.id}' />
                    <button type="button" class="btn btn-outline-success done">完成</button>
                    <button type="button" class="btn btn-outline-danger delete">刪除</button>
                </div>
            </li>
        `))
    }

    $('.add-todo').keydown(function(e) {
        if(e.key === 'Enter' && e.target.value !=''){
            addToDo({
                value: e.target.value,
                id: list.length
            });
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
                id: list.length
            });
            $('.add-todo').val('')
        }
    })

    $('.todo_list').click(function(e) {
        const el = $(e.target);
        if (el.hasClass('delete')) {
            /** 本來的方式：按下刪除後移除 todo-li */
            // el.parent().parent().fadeOut(500, function() {
            //     $(this).remove();
            // })

            let id = Number(el.parent().find('input:hidden').attr("id"))
            removeTodo(id)

        } else if (el.hasClass('done')){

            if(el.hasClass('todo__undone')) {
                el.addClass('btn-outline-success')
                    .removeClass('btn-outline-primary')
                    .removeClass('todo__undone')
                    .text('完成')
                    .parent().parent().removeClass('success');
            } else {
                el.removeClass('btn-outline-success')
                    .addClass('btn-outline-primary')
                    .addClass('todo__undone')
                    .text('未完成')
                    .parent().parent().addClass('success');
            }

        }
    })
})

