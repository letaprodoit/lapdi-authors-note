<div id="style{$style}" class="tsp_authors_note">
    {if $title}<div class="title">{$title}</div>{/if}
    <div class="content">       
       {if $show_pic == 'Y'}
            <div class="photo">            
            {if $show_website == 'Y'}
                <a target="_blank" href="{$website}">{$gravatar}</a>
            {else}
                {$gravatar}
            {/if}
            </div>
        {/if}
        {if $note}
        <div class="note">
            {$note}
            {if $show_name == 'Y'}<div class="name">- {$name}</div>{/if}
        </div>
        {/if}
        <div class="clear">&nbsp;</div>
        <div class="info">
            {if $show_bio == 'Y'}
                <div class="bio">
                    {if $show_name == 'Y'}
                        <h3>{$name}'s Bio</h3>
                    {else}
                        <h3>Author's Bio</h3>
                    {/if}
                    {$bio}
                 </div>
            {/if}
            {if $show_website == 'Y'}
                <div class="website">Website: <a target="_blank" href="{$website}">{$website}</a></div>
            {/if}
            {if $show_links == 'Y'}
                <div class="links">
                    {foreach $links as $key => $url}
                        <a target="_blank" href="{$url}"><div id="{$key}" class="links left">&nbsp;</div></a>
                    {/foreach}
                    <div class="clear">&nbsp;</div>
                </div>
            {/if}
        </div>
    </div>
</div>
