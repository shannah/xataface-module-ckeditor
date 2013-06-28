<?php
/**

@see @ref toc

@page schemabrowser Schema Browser Plugin

<img src="http://media.weblite.ca/files/photos/Screen_shot_2012-01-27_at_12.52.01_PM.png?max_width=640"/>

The Schema Browser plugin adds a button to the CKeditor toolbar that opens a palette to select a field from a particular table.  This depends on the Schema Browser javascript component included with Xataface 2.0 (SVN rev 3126 or higher).

@section schemabrowser_features Schema Browser Features

- Can embed a macro for fields into an HTML document.
- Shows a preview of the data contained in each field.

@section schemabrowser_installation Schema Browser Installation

-# On any page that will include the Schema Browser plugin you need to include the plugin's javascripts with the JavascriptTool.  You can do this inside any block or hook that will be run on the page in question:
@code
Dataface_JavascriptTool
    ::getInstance()
        ->import('xataface/modules/ckeditor/plugins/SchemaBrowser.js');
@endcode
-# In the @e fields.ini file field definition for the CKeditor widget, add the following directives:
@code
widget:ckeditor:toolbar="XBasic"
widget:ckeditor:extraPlugins="SchemaBrowser"
@endcode
What this does is sets the toolbar to use the XBasic toolbar that is defined in the SchemaBrowser plugin.  It then directs the CKeditor to include the SchemaBrowser plugin.

@todo I would like to find a way to not have to explicitly add a new toolbar (i.e. the XBasic line).  Ideally we should be able to simply specify that it use the SchemaBrowser plugin as an extra plugin and have everything handle automatically.  That will likely be in a next release.


@section schemabrowser_usage Schema Browser Usage

If the schema browser plugin is successfully enabled for a particular CKeditor instance you will see an "add field" icon on the editor's toolbar.  
<img src="http://media.weblite.ca/files/photos/Screen_shot_2012-01-27_at_12.51.20_PM.png?max_width=640"/>
Clicking on this will pop up a palette with a tree showing the fields that are available in the current table.

<img src="http://media.weblite.ca/files/photos/Screen_shot_2012-01-27_at_12.52.01_PM.png?max_width=640"/>

@attention This palette will only work for users who have been assigned the @e view schema permission.  Due to the sensitivity of this information it is only appropriate to provide this level of permissions to administrators or trusted users of the system.

@subsection schemabrowser_addfield Adding Fields to a Template

To add a field to the HTML editor document, simply click on a field in the schemabrowser.  This will add a text macro to the document in the form:
@code
{$fieldname}
@endcode
or
@code
{$relationshipname.fieldname}
@endcode
for related fields.

<img src="http://media.weblite.ca/files/photos/Screen_shot_2012-01-27_at_12.56.52_PM.png?max_width=640"/>

The intention is that you can parse this information out however you like.  

@section schemabrowser_changing_table Changing the Source Table

By default the schema browser will only show fields in the current table.  If you want to change this so that it uses a different table, simply add the @c data-xf-schemabrowser-tablename HTML attribute to the textarea on which the CKeditor is installed.  You can either do this dynamically or via the @c widget:atts:data-xf-schemabrowser-tablename directive in the fields.ini file.

@subsection schemabrowser_example1 Example 1: Changing the table based on a Javascript Event

The following example comes from templates feature of the Email module.  When designing an email template, the user can select which table the template should act on from a select list.  In this case it listens for changes to this select list and sets the @c data-xf-schemabrowser-tablename attribute accordingly:

@code
$('#table_name').change(function(){
    CKEDITOR
        .instances
            .email_body
                .element
                    .setAttribute(
                        'data-xf-schemabrowser-tablename'
                        , $(this).val()
                    );
});
@endcode

@see @ref toc

*/
?>