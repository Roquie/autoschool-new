<?=HTML::style('adm/css/listeners.css')?>

<div class="container">

    <div class="row">
        <div class="span4">
            <h1><small>Новости для групп</small></h1>
        </div>

    </div>

    <div class="row">
        <div class="span3 l_select_group">
            <div class="well">
                <h5 class="header_block">Номер группы</h5>
                <label for="">Выберите:</label>
                <input type="hidden" value="<?=Security::token()?>"/>
                <select name="select2" id="select2" data-url="<?=Request::$current->url().'/users_by_group'?>">
                    <option value="0" selected="selected">Все ...</option>
                    <?foreach($list_groups as $item):?>
                        <option value="<?=$item->id?>"><?=$item->name?></option>
                    <?endforeach?>
                </select>
            </div>
        </div>
        <div class="span9 l_sort">
            <div class="well" style="height: 100px">
                <h5 class="header_block">Оповестить слушателей группы 01-14</h5>
                <form action="#" method="post" accept-charset="utf-8" novalidate>
                    <div class="row">
                        <div class="span1">
                            <img style="box-shadow: 0 1px 1px rgba(0,0,0,0.2)" src="<?=URL::site('img/admin/admin_avatar.png')?>" alt="admin_logo"/>
                        </div>
                        <input type="hidden" name="user_id" id="user_id"/>
                        <textarea name="msg" id="admin_msg" style="height: 44px; width: 483px; resize: none" placeholder="Введите сообщение"></textarea>
                        <input type="hidden" name="csrf" value="<?=Security::token()?>"/>
                        <input style="margin-top: 12px" type="submit" class="btn" name="submit"/>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span3 l_fio">
            <div class="well">
                <h5 class="header_block">Слушатели</h5>
                <div class="wrap" id="listeners">
                    <?=View::factory('admin/html/listeners', compact('list_users'))?>
                </div>
            </div>
        </div>
        <div class="span9 l_info">
            <div class="well">
                фвфыв

            </div>
        </div>
    </div>

</div>