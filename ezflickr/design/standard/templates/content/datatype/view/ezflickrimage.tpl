
{*Image size with fallback system : if size is not avalaibale, take next one in array...*}
{if is_set($image_class)|not()}
    {def $image_class=array('medium','small','thumbnail','square')}
{/if}

{if is_array($image_class)|not()}
    {set $image_class=array($image_class)}
{/if}

{if is_set($css_class)|not()}{def $css_class=false()}{/if}
{if is_set($alignment)|not()}{def $alignment=false()}{/if}
{if is_set($link_to_image)|not()}{def $link_to_image=false()}{/if}
{if is_set($href)|not()}{def $href=false()}{/if}
{if is_set($target)|not()}{def $target=false()}{/if}
{if is_set($hspace)|not()}{def $hspace=false()}{/if}
{if is_set($border_size)|not()}{def $border_size=0}{/if}
{if is_set($title)|not()}{def $tilte=$attribute.content.title}{/if}

{def $image=false()}


{if $attribute.content.is_valid}
    {foreach $image_class as $class}
        {if is_set($attribute.content.sizes[$class])}
            {set $image=$attribute.content.sizes[$class]}
        {/if}
        {break}
    {/foreach}
{/if}

{if $image}
	<img src="{$image.source}" alt="{$tilte}"/>
{else}
{"No valid image"|i18n("flickr/datatype")}
{/if}
