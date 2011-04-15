<?php

Croogo::hookBehavior('Node', 'Sites.SiteFilter');

Croogo::hookComponent('*', 'Sites.Multisite');

Croogo::hookHelper('Nodes', 'Sites.Sites');

Croogo::hookAdminTab('Nodes/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Nodes/admin_edit', 'Sites', 'sites.sites_selection');
