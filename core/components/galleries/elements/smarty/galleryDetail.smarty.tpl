<div id="galleryDetail">
    <h1>{$name}</h1>
    <div class="loading-indicator">Loading the Gallery</div>
    <div id="images">
        {foreach $items as $item}
        <div class="thumbnail">
            <a class="group" rel="group" href="{$baseWebPath}{$item@key}">
                <img class="galleryImage" src="{$baseWebPath}{$item@key}" height="82" width="110" style="display:none;"/>
            </a>
            <div class="file">
            {if $item && $allowFileDownload}
                <a href="{$baseWebPath}{$item}">Download</a>
            {/if}
            </div>
        </div>
        {foreachelse}
        <div>
            There are no images in this gallery. Please check back later.
        </div>
        {/foreach}
    </div>
</div>
{if $isFromList}
<div id="back">
    <a href="{$backHref}">&laquo; Back to the Gallery List</a>
</div>
{/if}
