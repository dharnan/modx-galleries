{if $numPages > 1}
<div class="pagination">
    <ul>
        {if $currPageNum eq 1}
        <li>Prev</li>
        {else}
        <li>
            <a href="{$prevPgHref}">Prev</a>
        </li>
        {/if}
        {for $page=0 to $numPages-1}
        <li>
            {if $page+1 eq $currPageNum}
            {$page+1}
            {else}
            <a href="{$docUrl}?start={$page*$limit}&limit={$limit}">{$page+1}</a>
            {/if}            
        </li>
        {/for}
        {if $currPageNum eq $numPages}
        <li>Next</li>
        {else}
        <li>
            <a href="{$nextPgHref}">Next</a>
        </li>
        {/if}        
    </ul>
</div>
{/if}
