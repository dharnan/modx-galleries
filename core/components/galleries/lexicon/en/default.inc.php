<?php
/**
 * Default English Lexicon Entries for Galleries
 *
 * @package galleries
 * @subpackage lexicon
 */
$_lang['gallery'] = 'Galleries';
$_lang['galleries'] = 'Galleries';
$_lang['galleries.desc'] = 'Add, update and remove website galleries.';
$_lang['galleries.management'] = 'Galleries Management';
$_lang['galleries.management_desc'] = 'Manage your galleries here. You can edit them by right-clicking on the respective row.';
$_lang['galleries.help_desc'] = '
    <div id="galleryHelpWindow">
        <table>
            <tr>
                <th>Snippet Parameter</th>
                <th>Possible Values</th>
            </tr>
            <tr>
                <td>filterStr</td>
                <td>(; separated modx xpdo WHERE syntax)</td>
            </tr>
            <tr>
                <td>sortStr</td>
                <td>(; separated modx xpdo ORDER syntax)</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Sample Snippet Syntax</th>
                <th>What it will show</th>
            </tr>
            <tr>
                <td>[[!Galleries? &filterStr=`published:=1;id:=1`]]</td>
                <td>A published gallery with id = 1</td>
            </tr>
            <tr>
                <td>[[!Galleries? &sortStr=`name:ASC`]]</td>
                <td>A list of galleries sorted by name</td>
            </tr>
        </table>
    </div>';

$_lang['galleries.search...'] = 'Search...';

//actions
$_lang['galleries.file_manager'] = 'Manage Files';
$_lang['galleries.gallery_help'] = 'Help';
$_lang['galleries.gallery_create'] = 'Create New gallery';
$_lang['galleries.gallery_remove'] = 'Remove gallery';
$_lang['galleries.gallery_remove_confirm'] = 'Are you sure you want to remove this gallery?';
$_lang['galleries.gallery_update'] = 'Update gallery';

//err msgs
$_lang['galleries.gallery_err_ae'] = 'A gallery with that name already exists.';
$_lang['galleries.gallery_err_nf'] = 'gallery not found.';
$_lang['galleries.gallery_err_ns'] = 'gallery not specified.';
$_lang['galleries.gallery_err_ns_name'] = 'Please specify a name for the gallery.';
$_lang['galleries.gallery_err_ns_image_folder'] = 'Please specify a folder where the gallery images exist.';
$_lang['galleries.gallery_err_ns_file_folder'] = 'Please specify a folder where the gallery files exist.';
$_lang['galleries.gallery_err_remove'] = 'An error occurred while trying to remove the gallery.';
$_lang['galleries.gallery_err_save'] = 'An error occurred while trying to save the gallery.';

//db
$_lang['galleries.id'] = 'Id';
$_lang['galleries.name'] = 'Name';
$_lang['galleries.image_folder'] = 'Gallery Folder';
$_lang['galleries.file_folder'] = 'File Folder';
$_lang['galleries.allow_file_download'] = 'Allow File Download?';
$_lang['galleries.datetime_created'] = 'Datetime Created';
$_lang['galleries.datetime_modified'] = 'Datetime Modified';
$_lang['galleries.published'] = 'Published';
