<p>Changing the default post options below allows you to place <code>[tsp-authors-note][/tsp-authors-note]</code> shortcode tag into any post or page with these options.</p>
<p>However, if you wish to add different options to the <code>[tsp-authors-note]</code> shortcode please use the following settings:</p>
<ul style="list-style-type:square; padding-left: 30px;">
	<li>Title: <code>title="Title of Posts"</code></li>
    <li>Note: <code>note="Note from the author goes here."</code></li>
    <li>Show Name: <code>show_name="N"</code>(Options: Y, N)</li>
    <li>Show Pic: <code>show_pic="Y"</code>(Options: Y, N)</li>
	<li>Show Bio: <code>show_bio="Y"</code>(Options: Y, N)</li>
    <li>Show Website: <code>show_website="N"</code>(Options: Y, N)</li>
    <li>Show Social Links: <code>show_social_links="N"</code>(Options: Y, N)</li>
	<li>Avatar Size: <code>thumb_size="80"</code></li>
    <li>Style: <code>style="0"</code>(Options: 0,1,2)</li>
    <li>Layout: <code>layout="0"</code>(Options: 0)
        <ul style="padding-left: 30px;">
            <li>0: Top: Title, Left: Image - Right: Text</li>
        </ul>
    </li>
	<li>HTML Tag Before Title: <code>before_title="&lt;h3 class='widget-title'&gt;"</code></li>
	<li>HTML Tag After Title: <code>after_title="&lt;/h3&gt;"</code></li>
</ul>
<hr>
A shortcode with all the options will look like the following:<br><br>
<code>[tsp-authors-note title="On After-Thought" note="<strong>I was only 18 years old when I wrote this</strong>" show_name="Y" show_pic="Y" show_bio="Y" show_website="N" show_social_links="N" style="1" layout="0" thumb_size="80" before_title="" after_title=""]</code>
<br>
<strong>OR</strong>
<br>
<code>[tsp-authors-note title="On After-Thought" show_name="Y" show_pic="Y" show_bio="Y" show_website="N" show_social_links="N" style="1" layout="0" thumb_size="80" before_title="" after_title=""]<strong>I was only 18 years old when I wrote this</strong>[/tsp-authors-note]</code>
