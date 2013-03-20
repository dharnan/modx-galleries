<div id="galleryList">
    {$pagination}
    {foreach $rows as $row}
    <div class="row">
        <div class="thumbnail">
            <img src="{$row.thumb_src}" height="82" width="110"/>
        </div>
        <div class="details">
            <dl>
                <dt class="name"><a href="{$row.href}">{$row.name}</a></dt>
                <dd class="datetime">{$row.datetime_modified|date_format:"%A, %B %e, %Y"}</dd>
            </dl>
        </div>
    </div>
    {foreachelse}
    <dl>
        <dt>There are no galleries to show.</dt>
    </dl>
    {/foreach}
    {$pagination}
</div> 
