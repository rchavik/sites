<div id="menu-<?php echo $menu['Menu']['id']; ?>" class="menu">
<?php
	echo $this->SitesMenus->nestedLinks($menu['threaded'], $options);
?>
</div>