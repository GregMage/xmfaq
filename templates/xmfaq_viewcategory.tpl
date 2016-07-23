<ol class="breadcrumb">
    <li><a href="index.php"><{$smarty.const._MD_XMFAQ_VIEWCATEGORY_LISTCAT}></a></li>
    <li class="active"><{$category_title}></li>
</ol>
<div class="row">
    <div class="col-sm-12">
        <h2><{$category_title}></h2>
        <p>
            <{$category_description}>
        </p>
    </div>
</div>
<{if $question_count != 0}>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <{foreach item=question from=$question}>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading<{$question.count}>">
            <h4 class="panel-title">
                <{if $question.count == 1}>
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<{$question.count}>" aria-expanded="true" aria-controls="collapse<{$question.count}>">
                    <{else}>
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<{$question.count}>" aria-expanded="false" aria-controls="collapse<{$question.count}>">
                        <{/if}>
                        <{$question.title}>
                    </a>
            </h4>
        </div>
        <{if $question.count == 1}>
        <div id="collapse<{$question.count}>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<{$question.count}>">
            <{else}>
            <div id="collapse<{$question.count}>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<{$question.count}>">
                <{/if}>
                <div class="panel-body">
                    <{$question.answer}>
                </div>
            </div>
        </div>
        <{/foreach}>
    </div>
    <{else}>
    <div class="alert alert-danger" role="alert">
        <{$smarty.const._MD_XMFAQ_VIEWCATEGORY_NOQUESTIONS}>
    </div>
<{/if}>
