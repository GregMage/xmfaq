<ol class="breadcrumb">
    <li class="active"><{$smarty.const._MD_XMFAQ_VIEWCATEGORY_LISTCAT}></li>
</ol>
<{if $index_header}>
    <div class="row">
        <div class="col-sm-12" style="padding-bottom: 10px; padding-top: 5px;">
            <{$index_header}>
        </div>
    </div>
<{/if}>
<{if $category_count != 0}>
    <{foreach item=category from=$category}>
        <{if $index_columncategory == 1}>
            <div class="row" style="padding-bottom: 5px; padding-top: 5px;">
                <div class="col-sm-12">
                    <h4><{$category.title}></h4>
                    <{$category.description}>
                    <p style="padding-top: 15px;">
                        <a href="viewcategory.php?category_id=<{$category.id}>">
                            <button type="button" class="btn btn-primary btn-xs"><{$smarty.const._MD_XMFAQ_INDEX_VIEW}></button>
                        </a>
                    </p>
                </div>
            </div>
        <{/if}>
        <{if $index_columncategory == 2}>
            <{if $category.row == true}>
                <div class="row" style="margin-top: 5px;">
            <{/if}>
            <div class="col-sm-6">
                <h4><{$category.title}></h4>
                <{$category.description}>
                <p style="padding-top: 15px;">
                    <a href="viewcategory.php?category_id=<{$category.id}>">
                        <button type="button" class="btn btn-primary btn-xs"><{$smarty.const._MD_XMFAQ_INDEX_VIEW}></button>
                    </a>
                </p>
            </div>
            <{if $category.count is div by $index_columncategory || $category.end == true}>
                </div>
            <{/if}>
        <{/if}>
        <{if $index_columncategory == 3}>
            <{if $category.row == true}>
                <div class="row" style="margin-top: 5px;">
            <{/if}>
            <div class="col-sm-4">
                <h4><{$category.title}></h4>
                <{$category.description}>
                <p style="padding-top: 15px;">
                    <a href="viewcategory.php?category_id=<{$category.id}>">
                        <button type="button" class="btn btn-primary btn-xs"><{$smarty.const._MD_XMFAQ_INDEX_VIEW}></button>
                    </a>
                </p>
            </div>
            <{if $category.count is div by $index_columncategory || $category.end == true}>
                </div>
            <{/if}>
        <{/if}>
        <{if $index_columncategory == 4}>
            <{if $category.row == true}>
                <div class="row" style="margin-top: 5px;">
            <{/if}>
            <div class="col-sm-3">
                <h4><{$category.title}></h4>
                <{$category.description}>
                <p style="padding-top: 15px;">
                    <a href="viewcategory.php?category_id=<{$category.id}>">
                        <button type="button" class="btn btn-primary btn-xs"><{$smarty.const._MD_XMFAQ_INDEX_VIEW}></button>
                    </a>
                </p>
            </div>
            <{if $category.count is div by $index_columncategory || $category.end == true}>
                </div>
            <{/if}>
        <{/if}>
    <{/foreach}>
    <{if $nav_menu}>
        <div class="row">
            <div class="col-sm-12" style="padding-bottom: 10px; padding-top: 5px; padding-right: 60px; text-align: right;">
                <{$nav_menu}>
            </div>
        </div>
    <{/if}>
<{/if}>

<{if $index_footer}>
    <div class="row" style="padding-bottom: 5px; padding-top: 5px;">
        <div class="col-sm-12">
            <{$index_footer}>
        </div>
    </div>
<{/if}>
