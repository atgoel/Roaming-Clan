<?php
$meso_options = array (
/*header setting*/
array(
"section" => 'header',
"name" => __("Site Logo", 'mesocolumn'),
	"description" => __("Enter your logo full url here.<br /><em>* This is not for header image, please use wp-admin->appeareance->header for header image</em>", 'mesocolumn'),
	"id" => $shortname."_header_logo",
    "filename" => $shortname."_header_logo",
	"type" => "text",
	"default" => ""),

array(
"section" => 'header',
"name" => __("Favourite Icon", 'mesocolumn'),
	"description" => __("Enter your fav icon full url here", 'mesocolumn'),
	"id" => $shortname."_fav_icon",
    "filename" => $shortname."_fav_icon",
	"type" => "text",
	"default" => ""),


/* typography setting */
array(
"section" => 'typography',
"name" => __("Body Font", 'mesocolumn'),
	"description" => __("Choose a font for the body text.", 'mesocolumn'),
	"id" => $shortname."_body_font",
	"type" => "select-fonts",
	"select_options" => $font_family_group,
	"default" => "Choose a font"),

array(
"name" => __("Body Font Weight", 'mesocolumn'),
	"description" => "Choose a font weight for the body text",
    "section" => "typography",
    "id" => $shortname."_body_font_weight",
	"type" => "select-fonts-weight",
	"default" => ""),


array(
"section" => 'typography',
"name" => __("Headline and Title Font", 'mesocolumn'),
	"description" => __("Choose a font for the headline text.", 'mesocolumn'),
	"id" => $shortname."_headline_font",
	"type" => "select-fonts",
	"options" => $font_family_group,
	"default" => "Choose a font"),

array(
"name" => __("Headline Font Weight", 'mesocolumn'),
	"description" => "Choose a font weight for the headline and title text",
    "section" => "typography",
    "id" => $shortname."_headline_font_weight",
	"type" => "select-fonts-weight",
	"default" => ""),


array(
"section" => 'typography',
"name" => __("Navigation Font", 'mesocolumn'),
	"description" => __("Choose a font for the navigation text.", 'mesocolumn'),
	"id" => $shortname."_navigation_font",
	"type" => "select-fonts",
	"options" => $font_family_group,
	"default" => "Choose a font"),


array(
"name" => __("Navigation Font Weight", 'mesocolumn'),
	"description" => "Choose a font weight for the navigation text",
    "section" => "typography",
    "id" => $shortname."_navigation_font_weight",
	"type" => "select-fonts-weight",
	"default" => ""),


/* Design setting */
array(
"section" => 'designs',
"name" => __("Color Scheme", 'mesocolumn'),
	"description" => __("Choose a color scheme that will be apply to default links color and sidebar widget header and footer widget header etc.", 'mesocolumn'),
	"id" => $shortname."_main_color",
	"type" => "colorpicker",
	"default" => ""),

array(
"section" => 'designs',
"name" => __("Top Navigation Background Color", 'mesocolumn'),
	"description" => __("Choose a background color for top navigation.", 'mesocolumn'),
	"id" => $shortname."_topnav_color",
	"type" => "colorpicker",
	"default" => ""),

array(
"section" => 'designs',
"name" => __("Bottom Footer Background Color", 'mesocolumn'),
	"description" => __("Choose a background color for bottom footer.", 'mesocolumn'),
	"id" => $shortname."_footer_bottom_color",
	"type" => "colorpicker",
	"default" => ""),

/* posts setting */
array(
"section" => 'posts',
"name" => __("Featured Image Size", 'mesocolumn'),
"description" => __("Choose if you want to thumbnail, medium or large for featured images.", 'mesocolumn'),
    "id" => $shortname."_feat_img_size",
	"type" => "radio-image-size",
	"default" => "thumbnail"),

array(
"section" => 'posts',
"name" => __("Blog Post Style", 'mesocolumn'),
"description" => __("Choose if you want to use magazine or normal blog post style.", 'mesocolumn'),
    "id" => $shortname."_blogpost_style",
	"type" => "radio-blog-style",
	"default" => "default"),

array(
"section" => 'posts',
"name" => __("Enter Post Excerpt Count", 'mesocolumn'),
	"description" => __("Enter how many word count for all your post excerpt<br />*numeric only: 25,55,100", 'mesocolumn'),
	"id" => $shortname."_post_custom_excerpt",
	"type" => "text",
	"default" => "30"),

array(
"section" => 'posts',
"name" => __("Enter Post Excerpt More Text", 'mesocolumn'),
	"description" => __("Enter your own more text for the excerpt", 'mesocolumn'),
	"id" => $shortname."_post_excerpt_moretext",
	"type" => "text",
	"default" => ""),

array(
"section" => 'posts',
"name" => __("Enable Related Posts", 'mesocolumn'),
	"description" => __("Enable or disable related posts", 'mesocolumn'),
	"id" => $shortname."_related_on",
	"type" => "radio-enable-disable",
	"options" => array('Disable','Enable'),
	"default" => "Disable"),

array(
"section" => 'posts',
"name" => __("How Many Related Posts?", 'mesocolumn'),
"description" => __("Choose how many related post you want to show.", 'mesocolumn'),
	"id" => $shortname."_related_count",
	"type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),

array(
"section" => 'posts',
"name" => __("Enable Author Bio", 'mesocolumn'),
	"description" => __("Enable or disable author bio in single posts", 'mesocolumn'),
	"id" => $shortname."_author_bio_on",
	"type" => "radio-enable-disable",
	"options" => array('Disable','Enable'),
	"default" => "Disable"),

array(
"section" => 'posts',
"name" => __("Enable Breadcrumbs", 'mesocolumn'),
	"description" => __("Enable or disable breadcrumbs", 'mesocolumn'),
	"id" => $shortname."_breadcrumbs_on",
	"type" => "radio-enable-disable",
	"options" => array('Disable','Enable'),
	"default" => "Disable"),

array(
"section" => 'posts',
"name" => __("Enable Archive Header", 'mesocolumn'),
	"description" => __("Enable or disable archive header", 'mesocolumn'),
	"id" => $shortname."_archive_headline",
	"type" => "radio-enable-disable",
	"options" => array('Disable','Enable'),
	"default" => "Disable"),

array(
"section" => 'posts',
"name" => __("Enable Comments Close Notice", 'mesocolumn'),
	"description" => __("Enable or disable comments close notice", 'mesocolumn'),
	"id" => $shortname."_comment_notice",
	"type" => "radio-enable-disable",
	"options" => array('Enable','Disable'),
	"default" => "Enable"),

array(
"section" => 'posts',
"name" => __("Enable Auto Sub Category in Primary Menu", 'mesocolumn'),
	"description" => __("Enable or disable auto sub category show in primary menu", 'mesocolumn'),
	"id" => $shortname."_allow_subcat",
	"type" => "radio-enable-disable",
	"options" => array('Disable','Enable'),
	"default" => "Disable"),


/* Shop setting */
array(
"section" => 'shop',
"name" => __("Enable Custom Shop Style", 'mesocolumn'),
"description" => __("Choose if you want to use the built-in style for shop.<br /><small><em>*optional, only if you have woocommerce or jigoshop plugin installed.</em></small>", 'mesocolumn'),
	"id" => $shortname."_custom_shop",
	"type" => "radio-enable-disable",
	"options" => array("Disable", "Enable"),
	"default" => "Disable"),



/* Featured Slider setting */
array(
"section" => 'slider',
"name" => __("Enable Featured Slider", 'mesocolumn'),
"description" => __("Choose if you want to enable or disable featured slider.", 'mesocolumn'),
	"id" => $shortname."_slider_on",
	"type" => "radio-enable-disable",
	"options" => array("Disable", "Enable"),
	"default" => "Disable"),


array(
"section" => 'slider',
"name" => __("Slider Height", 'mesocolumn'),
"description" => __("Enter your desired slider height here<br /><small>example: 200,300,400</small>", 'mesocolumn'),
	"id" => $shortname."_slider_height",
	"type" => "text",
	"default" => "400"),

array(
"section" => 'slider',
"name" => __("Categories ID", 'mesocolumn'),
"description" => __("Add a list of category ids if you want to use category as featured. <em>*leave blank to use bottom post ids featured</em><br /><small>example: 3,4,68</small>", 'mesocolumn'),
	"id" => $shortname."_feat_cat",
	"type" => "text",
	"default" => ""),

array(
"section" => 'slider',
"name" => __("Limit to how many posts", 'mesocolumn'),
"description" => __("How many posts in categories you listed you want to show?", 'mesocolumn'),
	"id" => $shortname."_feat_cat_count",
	"type" => "select-count",
    "options" => $choose_count,
	"default" => ""),


array(
"section" => 'slider',
"name" => __("Posts ID", 'mesocolumn'),
"description" => __("Add a list of post ids if you want to use posts as featured. <em>*leave blank to use above category ids featured</em><br /><strong style='font-size:13px;'>Post, Page and Custom Post Type Supported</strong><br /><small>example: 136,928,925,80,77,55,49</small>", 'mesocolumn'),
	"id" => $shortname."_feat_post",
	"type" => "text",
	"default" => ""),



/* Home Featured setting */
array(
"section" => 'home',
"name" => __("Choose Your Featured Category Layout", TEMPLATE_DOMAIN),
"description" => __("Choose the layout style for the featured category.", TEMPLATE_DOMAIN),
	"id" => $shortname."_feat_layout",
	"type" => "radio",
	"options" => $choose_layout,
	"default" => ""),

array(
"section" => 'home',
"name" => __("Enable RSS Feed Link", 'mesocolumn'),
"description" => __("Choose if you want to enable or disable rss feed link in each category.", 'mesocolumn'),
	"id" => $shortname."_rss_feed_on",
	"type" => "radio-enable-disable",
	"options" => array("Enable","Disable"),
	"default" => "Enable"),

array(
"section" => 'home',
"name" => __("Homepage Featured Category 1", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat1",
	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),

array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat1_count",
	"type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 2", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat2",
	"type" => "select-cat",
   	"options" => $wp_cats,
    "default" => ""),

array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat2_count",
   "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 3", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat3",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),

array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat3_count",
   "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),

array(
"section" => 'home',
"name" => __("Homepage Featured Category 4", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat4",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),
array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat4_count",
	"type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),

array(
"section" => 'home',
"name" => __("Homepage Featured Category 5", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat5",
  	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),
array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat5_count",
    "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),

array(
"section" => 'home',
"name" => __("Homepage Featured Category 6", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat6",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),
array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat6_count",
  "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 7", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat7",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),

array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat7_count",
   "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 8", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat8",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),
array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat8_count",
	"type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 9", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat9",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),
array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat9_count",
   "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),


array(
"section" => 'home',
"name" => __("Homepage Featured Category 10", 'mesocolumn'),
"description" => __("Choose which category to featured.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat10",
   	"type" => "select-cat",
	"options" => $wp_cats,
    "default" => ""),

array(
"section" => 'home',
"name" => __("How Many Posts?", 'mesocolumn'),
"description" => __("Choose how many post you want to show.", 'mesocolumn'),
	"id" => $shortname."_side_feat_cat10_count",
   "type" => "select-count",
   	"options" => $choose_count,
    "default" => ""),



/*advertisement setting*/

array(
"section" => 'advertisement',
"name" => __("468x60 or 728x90 Header Banner and Advertisment Embed Code", 'mesocolumn'),
  "description" => __("Add Embed Code or Image Banner Here<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_header_embed",
	"type" => "textarea",
	"default" => ""),


array(
"section" => 'advertisement',
"name" => __("Advertisement in First Post Loop", 'mesocolumn'),
	"description" => __("Insert Ads code for the blog post <strong>first</strong> loop. It will appeared after 2 posts.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_ads_code_one",
	"type" => "textarea",
	"default" => ""),


array(
"section" => 'advertisement',
"name" => __("Advertisement in Second Post Loop", 'mesocolumn'),
	"description" => __("Insert Ads code for the blog post <strong>second</strong> loop. It will appeared after 4 posts. <br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_ads_code_two",
	"type" => "textarea",
	"default" => ""),


array(
"section" => 'advertisement',
"name" => __("Advertisement in Single Post Top", 'mesocolumn'),
	"description" => __("Insert Ads code for the single post <strong>top</strong>. It will appeared before post content. <br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_ads_single_top",
	"type" => "textarea",
	"default" => ""),


array(
"section" => 'advertisement',
"name" => __("Advertisement in Single Post Bottom", 'mesocolumn'),
	"description" => __("Insert Ads code for the single post <strong>bottom</strong>. It will appeared after post content.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_ads_single_bottom",
	"type" => "textarea",
	"default" => ""),


array(
"section" => 'advertisement',
"name" => __("Advertisement in Right Sidebar", 'mesocolumn'),
	"description" => __("Insert Ads code for the <strong>right</strong> sidebar.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_ads_right_sidebar",
	"type" => "textarea",
	"default" => ""),

array(
"section" => 'advertisement',
"name" => __("Header Code Insert", 'mesocolumn'),
	"description" => __("Insert any code here. It will appeared after wp_head().<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_header_code",
	"type" => "textarea",
	"default" => ""),

array(
"section" => 'advertisement',
"name" => __("Footer Code Insert", 'mesocolumn'),
	"description" => __("Insert any code here. It will appeared after wp_footer().<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_footer_code",
	"type" => "textarea",
	"default" => ""),


/*banner setting*/
array(
"section" => 'sidebar',
"header-title" => __("Sidebar Banner Settings", 'mesocolumn'),
"name" => __("Banner Ads 1", 'mesocolumn'),
	"description" => __("Insert banner 1 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_one",
	"type" => "textarea",
    "default" => ""),

array(
"section" => 'sidebar',
"name" => __("Banner Ads 2", 'mesocolumn'),
	"description" => __("Insert banner 2 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_two",
	"type" => "textarea",
    "default" => ""),

array(
"section" => 'sidebar',
"name" => __("Banner Ads 3", 'mesocolumn'),
	"description" => __("Insert banner 3 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_three",
	"type" => "textarea",
    "default" => ""),

array(
"section" => 'sidebar',
"name" => __("Banner Ads 4", 'mesocolumn'),
	"description" => __("Insert banner 4 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_four",
	"type" => "textarea",
    "default" => ""),

array(
"section" => 'sidebar',
"name" => __("Banner Ads 5", 'mesocolumn'),
	"description" => __("Insert banner 5 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_five",
	"type" => "textarea",
    "default" => ""),

array(
"section" => 'sidebar',
"name" => __("Banner Ads 6", 'mesocolumn'),
	"description" => __("Insert banner 6 HTML code.<br />*&lsaquo;script&rsaquo; tag not allowed. Read faq.txt on how to use script.", 'mesocolumn'),
	"id" => $shortname."_sponsor_banner_six",
	"type" => "textarea",
    "default" => ""),


/* Misc setting */
array(
"section" => 'misc',
"name" => __("Footer Credit", 'mesocolumn'),
"description" => __("Choose to disable or enable theme author footer credit links.<br /><em>*optional, but I would appreciate if you leave the footer credit link</em>", 'mesocolumn'),
	"id" => $shortname."_footer_credit",
   	"type" => "radio-enable-disable",
	"options" => array("Disable", "Enable"),
	"default" => "Enable"),

array(
"section" => 'misc',
"name" => __("Schema.org Markup", 'mesocolumn'),
"description" => __("Choose to disable or enable schema markup for the theme", 'mesocolumn'),
	"id" => $shortname."_schema_on",
   	"type" => "radio-enable-disable",
	"options" => array("Disable", "Enable"),
	"default" => "Disable"),

array(
"section" => 'misc',
"name" => __("Responsive Layout", 'mesocolumn'),
"description" => __("Choose to disable or enable theme responsive mode for smaller screen or mobile", 'mesocolumn'),
	"id" => $shortname."_responsive_mode",
   	"type" => "radio-enable-disable",
	"options" => array("Disable", "Enable"),
	"default" => "Enable")
);


?>