<?php
/**

@see @ref toc

@page plugins Plugin Development

One of the powerful features of CKeditor is its extensibility.  You are able to quite easily develop plugins that add functionality to your CKeditor instances.  There are quite a few resources on the net that explain how to develop plugins for CKeditor.  The process when using the editor within Xataface is slightly modified since Xataface uses the @c Dataface_JavascriptTool class to compile its javascripts - and this includes CKeditor.

The basic steps for creating a plugin for your CKeditor instance is as follows:

-# Create a directory in your application folder named @e js.  I.e. <em>/path/to/your/application/js</em>.
-# Create a javascript file for your plugin.  E.g. you could place it in a file at <em>js/stevesplugins/ckeditorplugin.js</em>.  But it could be named anything.
-# Insert some dummy placeholder javascript in your @c ckeditorplugin.js so that you can tell if it is getting picked up properly.  e.g. @code
alert('Here');
@endcode
-# Now we need to tell Xataface to include your script.  We use the @c Dataface_JavascriptTool::import() method for this.  Where you call this method depends on under what circumstances you want your plugin to be loaded.  If you only need it for one field, you may want to place it in the @c before_fieldname_widget block for that field.  If you want it in every table, you might place it in the @c before_form block of the Application delegate class, or even just in the @c beforeHandleRequest method of your Application delegate class.
@see http://xataface.com/wiki/Application_Delegate_Class (Documentation for the Application Delegate Class)
@see http://xataface.com/documentation/tutorial/getting_started/changing-look-and-feel (For a demonstration of blocks and slots). 

For our example, we will only load our plugin for one field, so we will implement the following in the table delegate class that contains our field:

@code
function block__before_myfield_widget(){
	$jt = Dataface_JavascriptTool::getInstance();
	$jt->import('stevesplugin/ckeditorplugin.js');
}
@endcode

Notice that we only include the path to our file from after the @e js directory.  This is because the @c Dataface_JavascriptTool automatically has the @e js directory of your application in its list of search paths for files that are included.

Now if you load the edit or new form for your table, you should see an alert box pop up with our "Here" message.  If you don't see this, then there is likely a javascript error.  See the @ref troubleshooting "Troubleshooting Section" for tips on debugging javascript errors.

@section insidejavascript Inside the Plugin Javascript File

Now that our javascript file is being picked up we can proceed to write out plugin.

@subsection dependencies Importing Dependencies

The first thing we need to do in our javascript file is import dependencies.  This is one of the nice features of the @c Dataface_JavascriptTool.  It allows us to include dependencies in our javascript files just as we can in other server-side languages like C or PHP.  It does this by way of two directives:

-# //require <path/to/javascript.js>
-# //require-css <path/to/css.css>

Both of these directives perform uniqueness checking to ensure that every file is only included once per page request.  This allows you to safely build up large object hierarchies and not worry about whether a script has already been included or not.  In addition these will check all paths in its search path for the file specified.  This allows you to store your javascript files in separate physical locations, but still work together under a single path structure.  

By default the search path for javascript files includes:

-# SITE_URL/js
-# XATAFACE_URL/js
-# XATAJAX_URL/js

and the search path for CSS files includes:

-# SITE_URL/css
-# XATAFACE_URL/css
-# XATAJAX_URL/css

But the search path can be augmented by way of the @c Dataface_JavascriptTool::addPath() and Dataface_CSSTool::addPath() methods.  For example, the CKeditor module registers its own @e js and @e css directories with these tools to include their pertinent files.

Now, back to the task at hand, we need to specify the @e ckeditor.js file as a dependency for our plugin so that we can be sure that we'll have access to the full CKeditor API when our plugin runs.  So we add the following content to our @e myckeditorplugin.js file:
@code
//require <ckeditor.js>
@endcode

Now we can start to write our plugin.
@code
//require <ckeditor.js>
(function(){
	CKEDITOR.plugins.add('myplugin', {
		init: function(editor){
		
			// Initialization code for our plugin
		}
	});
});
@endcode

For details about what you might want to do with your plugin initialization, see some of the references below:

@see http://www.voofie.com/content/2/ckeditor-plugin-development/
@see http://weblite.ca/svn/dataface/modules/htmlreports/trunk/js/ckeditor/plugins/insertmacro/insertmacro.js
@see http://weblite.ca/svn/dataface/modules/htmlreports/trunk/css/ckeditor/plugins/insertmacro/insertmacro.css


@section using_your_plugin Using Your Plugin

Now that you have created your plugin, you can specify that your CKeditor instance uses it with the @e widget:ckeditor:extraPlugins directive in the fields.ini file.

e.g.

@code
[template_html]
    widget:label="Template HTML"
    widget:type=ckeditor
    widget:ckeditor:foo=bar
    widget:ckeditor:toolbar="XBasic"
    widget:ckeditor:extraPlugins="insertmacro"
@endcode


@see @ref toc

*/
?>