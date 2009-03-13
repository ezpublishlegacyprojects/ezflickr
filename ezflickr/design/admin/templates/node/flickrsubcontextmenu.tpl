<script language="JavaScript1.2" type="text/javascript">
menuArray['MUpload'] = new Array();
menuArray['MUpload']['depth'] = 1; // this is a first level submenu of ContextMenu
menuArray['MUpload']['elements'] = new Array();
</script>

 <hr/>
    <a id="child-menu-mupload" href="#" onclick="ezpopmenu_submitForm( 'child-menu-form-mupload' ); return false;" >{"Import form Flickr"|i18n("flickr/main")}</a>

<form id="child-menu-form-mupload" method="post" action={"/content/action"|ezurl()}>
  <input type="hidden" name="RedirectURI" value="/flickr/home/%nodeID%" />
  <input type="hidden" name="RedirectButton" value="1" />
</form>