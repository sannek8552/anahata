{config_load file=templates.ini section="common" scope="global"}


<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        
        $('button').button();
        

        $('#addPost').click(function(){
            //Валидация
            var success = true;
            $($(this).parent().find('input')).each(function (i) {
                if ($(this).val() == "" || $(this).attr("placeholder") == $(this).val()){
                    this.style.background = "#fdb5aa";
                    success = false;
                }
            });

            $($(this).parent().find('textarea')).each(function (i) {
                if ($(this).val() == "" || $(this).attr("placeholder") == $(this).val()){
                  this.style.background = "#fdb5aa";
                  success = false;
                }
            });

            if (success) {
                var params = {};
                params['author'] = $('#author').val();
                params['post']   = $('#post').val();
                $.ajax({
                    url: "{/literal}{#script_url#}{literal}index.php?rm=ajax_add_post",
                    dataType: 'json',
                    type: 'post',
                    data: params,
                    success: function(res){
                        if (res.success) {
                            $('#author').val('');
                            $('#post').val('');

                            $('#posts').prepend(res.html);
                        }
                        else {
                            alert(res.errorMsg);
                        }
                    }
                });
            }
        });

        $('input, textarea').focus(function(){
            $(this).css('background-color','#ffffff');
        })
    });

    function answer(post_id,node) {
        $('#answer').html('');
        $('#dialog').dialog({
                title: 'Ответить',
                autoOpen: true,
                width: 400,
                height: 300,
                modal: true,
                draggable: false,
                resizable: false,
                buttons: {
                        "Отправить": function() {
                                var params = {};
                                params['post_id'] = post_id;
                                params['answer']   = $('#answer').val();
                                $.ajax({
                                    url: "{/literal}{#script_url#}{literal}index.php?rm=ajax_add_answer",
                                    dataType: 'json',
                                    type: 'post',
                                    data: params,
                                    success: function(res){
                                        if (res.success) {
                                            $(node).closest('.post').find('.body').append('<div class="answer"><span>Ответ:</span>'+$('#answer').val()+'</div>');
                                            $(node).attr('onclick', 'editAnswer(\''+res.answer_id+'\', this);');
                                            $(node).html('[Редактировать ответ]');
                                            $('#dialog').dialog("close");
                                        }
                                        else {
                                            alert(res.errorMsg);
                                        }
                                    }
                                });
                        },
                        "Отмена": function() {
                                $(this).dialog("close");
                        }
                }
        });
    }

    function editAnswer(answer_id, node) {

        $('#answer').load("{/literal}{#script_url#}{literal}index.php?rm=ajax_load_answer&answer_id="+answer_id, function(){
            $('#dialog').dialog({
                    title: 'Редактировать ответ',
                    autoOpen: true,
                    width: 400,
                    height: 300,
                    modal: true,
                    draggable: false,
                    resizable: false,
                    buttons: {
                            "Отправить": function() {
                                    var params = {};
                                    params['answer_id'] = answer_id;
                                    params['answer']    = $('#answer').val();
                                    $.ajax({
                                        url: "{/literal}{#script_url#}{literal}index.php?rm=ajax_add_answer",
                                        dataType: 'json',
                                        type: 'post',
                                        data: params,
                                        success: function(res){
                                            if (res.success) {
                                                $(node).closest('.post').find('.answer').html('<span>Ответ:</span>'+$('#answer').val());
                                                $('#dialog').dialog("close");
                                            }
                                            else {
                                                alert(res.errorMsg);
                                            }
                                        }
                                    });
                            },
                            "Отмена": function() {
                                    $(this).dialog("close");
                            }
                    }
            });
        });

    }

    function deletePost(post_id, node) {
        if (confirm("Подтверждение удаления записи")) {
            $.ajax({
                url: "{/literal}{#script_url#}{literal}index.php?rm=ajax_delete_post",
                dataType: 'json',
                type: 'post',
                data: {post_id: post_id},
                success: function(res){
                    if (res.success) {
                        $(node).closest('.post').fadeOut(500, function(){$(this).remove()});
                    }
                    else {
                        alert(res.errorMsg);
                    }
                }
            });
        }
    }
    {/literal}
</script>
<div id="guest_book">
    <h1>Гостевая книга</h1>
    <p>Здесь Вы можете оставить свои отзывы и задать интересующие Вас вопросы. <br/>
        Мы с радостью на них ответим. <br/>
        Ведь Ваши отзывы-это наши улучшения!
    </p>
    <h2>Задайте свой вопрос</h2>
    <div id="post_form">
        <form>
            <input type="text" name="author" id="author" placeholder="Имя"/><br/>
            <textarea name="post" id="post" placeholder="Текст сообщения"></textarea>
        </form>
        <button id="addPost">Отправить</button>

    </div>
    <h2>Вопросы и ответы</h2>
    <div id="posts">
        
        {foreach from=$posts item=item}
                {cycle values="rowOdd,rowEven" assign=bcolor}
                <div class="post">
                    <div class="info">
                        <div class="left">
                            <span class="author">{$item.author}</span> - <span class="date">{$item.created|date_format:"%d.%m.%Y"}</span>
                        </div>
                        <div class="right">
                            {if $isAdmin}
                                {if !$item.answer}
                                    <a href="javascript:void(0);" class="answer_btn" onclick="answer('{$item.id}', this);">[Ответить]</a>
                                {else}
                                    <a href="javascript:void(0);" class="answer_btn" onclick="editAnswer('{$item.answer.id}', this);">[Редактировать ответ]</a>
                                {/if}
                                <a href="javascript:void(0);" class="answer_btn red" onclick="deletePost('{$item.id}', this);">[Удалить]</a>
                            {/if}
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="body">
                        {$item.post}
                        {if $item.answer}
                            <div class="answer">
                                <span>Ответ:</span>
                                {$item.answer.answer}
                            </div>
                        {/if}
                    </div>
                </div>
        {foreachelse}
            Нет записей
        {/foreach}
        
    </div>
    <div class="clear"></div>
        <div class="Pagination" style="margin-top:10px;">
            {if !empty($page_array) && count($page_array)> 1}
            Страницы:{foreach from=$page_array item=item key=key}
                            {if $item == $page}
                                <b>{$item}</b>
                            {else}
                                <a href="{#script_url#}{seo_url rm=Guestbook param1=$item}">{$item}</a>
                            {/if}
                    {/foreach}
            {/if}
        </div>
</div>
<div style="display: none;" id="dialog">
    <textarea name="answer" id="answer" placeholder="Текст сообщения"></textarea>
</div>