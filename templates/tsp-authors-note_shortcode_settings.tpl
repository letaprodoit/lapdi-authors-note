 <div class="tsp_container">
	<div class="icon32" id="tsp_icon"></div>
	<h2>Author's Note Default Settings (The Software People)</h2>
	<div class="mycomment">
		<p><h3>Using Author's Note Shortcode <a href="#" class="toggle">(hide/show details)</a>:</h3></p>
		<div class="note-details">
			<ul style="list-style-type:square;">
				<li>Changing the default post options below allows you to place <strong>[tsp-authors-note][/tsp-authors-note]</strong> shortcode tag into any post or page with these options.</li>
				<li>However, if you wish to add different options to the <strong>[tsp-authors-note]</strong> shortcode please use the following settings:
					<ul style="padding-left: 30px;">
						<li>Title: <strong>title="Title of Posts"</strong></li>
                        <li>Show Name: <strong>show_name="N"</strong>(Options: Y, N)</li>
                        <li>Show Pic: <strong>show_pic="Y"</strong>(Options: Y, N)</li>
						<li>Show Bio: <strong>show_bio="Y"</strong>(Options: Y, N)</li>
                        <li>Show Website: <strong>show_website="N"</strong>(Options: Y, N)</li>
                        <li>Show Social Links: <strong>show_social_links="N"</strong>(Options: Y, N)</li>
						<li>Avatar Size: <strong>thumb_size="80"</strong></li>
                        <li>Style: <strong>style="0"</strong>(Options: 0,1,2)</li>
                        <li>Layout: <strong>layout="0"</strong>(Options: 0)
                            <ul style="padding-left: 30px;">
                                <li>0: Top: Title, Left: Image - Right: Text</li>
                            </ul>
                        </li>
						<li>HTML Tag Before Title: <strong>before_title="&lt;h3 class='widget-title'&gt;"</strong></li>
						<li>HTML Tag After Title: <strong>after_title="&lt;/h3&gt;"</strong></li>
					</ul>
				</li>
				<li>Insert your desired shortcode into any page or post.</li>
			</ul>
			<hr>
			A shortcode with all the options will look like the following:<br><br>
			<strong>[tsp-authors-note title="On After-Thought" show_name="Y" show_pic="Y" show_bio="Y" show_website="N" show_social_links="N" style="1" layout="0" thumb_size="80" before_title="" after_title=""]</strong>I was only 18 years old when I wrote this<strong>[/tsp-authors-note]</strong>
		</div>
	
	</div>
	<script>
		{literal}
		jQuery("div.tsp_container a.toggle").click(function () {
			jQuery(".note-details").toggle();
		});
		{/literal}
	</script>
	<div class="updated fade" {if !$form || $error != ""}style="display:none;"{/if}><p><strong>{$message}</strong></p></div>
	<div class="error" {if !$error}style="display:none;"{/if}><p><strong>{$error}</strong></p></div>
	<form method="post" action="admin.php?page={$plugin_name}.php">
		<fieldset>
		{foreach $form_fields as $field}
			{include file="$EASY_DEV_FORM_FIELDS" field=$field}
		{/foreach}
		</fieldset>
		<input type="hidden" name="{$plugin_name}_form_submit" value="submit" />
		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>
		{$nonce_name}
	</form>
</div><!-- tsp_container -->
