<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons success.png}>';
    IMG_OFF = '<{xoAdminIcons cancel.png}>';
</script>
<div>
    <{$navigation}>
</div>
<div>
    <{$renderbutton}>
</div>
<{if $message_error != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$message_error}>
    </div>
<{/if}>
<div>
    <{$form}>
</div>
<{if $question_count != 0}>
    <table id="xo-xmcontact-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtleft"><{$smarty.const._AM_XMFAQ_QUESTION_TITLE}></th>
			<th class="txtcenter width20"><{$smarty.const._AM_XMFAQ_CATEGORY}></th>
            <th class="txtcenter width10"><{$smarty.const._AM_XMFAQ_QUESTION_WEIGHT}></th>
            <th class="txtcenter width10"><{$smarty.const._AM_XMFAQ_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._AM_XMFAQ_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=question from=$question}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtleft"><{$question.title}></td>
				<td class="txtleft"><{$question.category}></td>
                <td class="txtcenter"><{$question.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$question.id}>" src="../images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$question.id}>"
                    onclick="system_setStatus( { op: 'content_update_status', content_id: <{$question.id}> }, 'sml<{$question.id}>', 'question.php' )"
                    src="<{if $question.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $question.status}><{$smarty.const._AM_XMFAQ_STATUS_NA}><{else}><{$smarty.const._AM_XMFAQ_STATUS_A}><{/if}>"
                    title="<{if $question.status}><{$smarty.const.__AM_XMFAQ_STATUS_NA}><{else}><{$smarty.const._AM_XMFAQ_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="question.php?op=view&amp;question_id=<{$question.id}>" title="<{$smarty.const._AM_XMFAQ_VIEW}>">
                        <img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._AM_XMFAQ_VIEW}>"/>
                    </a>
                    <a class="tooltip" href="question.php?op=edit&amp;question_id=<{$question.id}>" title="<{$smarty.const._AM_XMFAQ_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._AM_XMCONTENT_EDIT}>"/>
                    </a>
                    <a class="tooltip" href="question.php?op=del&amp;question_id=<{$question.id}>" title="<{$smarty.const._AM_XMFAQ_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._AM_XMFAQ_DEL}>"/>
                    </a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="xo-avatar-pagenav floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $view}>
    <table id="xo-xmfaq-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtleft width20"><{$smarty.const._AM_XMFAQ_QUESTION_TITLE}></th>
            <th class="txtleft"><{$smarty.const._AM_XMFAQ_QUESTION_INFORMATION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach from=$question_arr key=title item=information}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtleft"><{$title}></td>
                <td class="txtleft"><{$information}></td>
            </tr>
        <{/foreach}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td><{$smarty.const._AM_XMFAQ_ACTION}></td>
                <td class="xo-actions txtleft">
                    <a class="tooltip" href="question.php?op=edit&amp;question_id=<{$question_id}>" title="<{$smarty.const._AM_XMFAQ_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._AM_XMFAQ_EDIT}>"/>
                    </a>
                    <a class="tooltip" href="question.php?op=del&amp;question_id=<{$question_id}>" title="<{$smarty.const._AM_XMFAQ_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._AM_XMFAQ_DEL}>"/>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
<{/if}>


