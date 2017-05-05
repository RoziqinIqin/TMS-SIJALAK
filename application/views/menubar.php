<?
$menuData = array(
  'items' => array(),
  'parents' => array()
);
$isgroupid = $this->session->userdata('group');
$isgroup_add = ($this->session->userdata('group_add') == "") ? 99999 : $this->session->userdata('group_add');
// $result = mysql_query("SELECT t0.fld_menuid id, t0.fld_menuidp parentId, t0.fld_menunm name, t0.fld_menuurl url FROM tbl_menu t0
// left join tbl_acl t1 on t1.fld_aclval=t0.fld_menuid
// ORDER BY fld_menuorder");
$result = mysql_query("SELECT DISTINCT t0.fld_menuid id, t0.fld_menuidp parentId, t0.fld_menunm name, t0.fld_menuurl url FROM tbl_menu t0
left join tbl_acl t1 on t1.fld_aclval=t0.fld_menuid
left join tbl_usergrp t2 on t2.fld_usergrpid=t1.fld_usergrpid
where t1.fld_usergrpid in ($isgroupid,$isgroup_add)
ORDER BY fld_menuorder");

while ($menuItem = mysql_fetch_assoc($result)){
  $menuData['items'][$menuItem['id']] = $menuItem;
  $menuData['parents'][$menuItem['parentId']][] = $menuItem['id'];
}

// <strong class="highlight">menu</strong> builder function, parentId 0 is the root
function buildMenu($parentId, $menuData) {
  $html = '';
  $parent='';

  if (isset($menuData['parents'][$parentId])) {
	$menuClass= ($parentId==0) ? ' class="<strong class="highlight">nav22</strong>" id="<strong class="highlight">nav11</strong>"' : '';
	$parent= ($parentId==0) ? 0 : 1;
//     $html = "<ul id=''>\n";
$result2 = mysql_query("SELECT *,
(
select tx.fld_menuidp FROM tbl_menu tx where tx.fld_menuid = t0.fld_menuidp order by fld_menuorder
) 'ppp'
FROM tbl_menu t0 where t0.fld_menuidp = $parentId order by fld_menuorder");
while($row = mysql_fetch_array($result2))
  {
$idp = $row['fld_menuidp'];
$ppp = $row['ppp'];
//  echo $row['fld_menuid']. "#" . $row['fld_menuidp'] . "#" .$row['fld_menunm']. "#" .$row['ppp'];
//  echo "<br>";
  }

if ($idp== 0) {
    $html = "";
		}
    else {

 $html = "<ul>\n";
	}

    foreach ($menuData['parents'][$parentId] as $itemId) {
	  //subment
	  $result=mysql_query("select * from tbl_menu where fld_menuidp='$itemId'");
	  if (mysql_num_rows($result)>(int)0 && $parentId!=0) {
        $subm  =' class=""';
      } else {
		$subm  ='';
	  }
	  //end
	  $menu = $parentId == 0 ? ' class="qmparent"' : '';		//class of main <strong class="highlight">menu</strong>
      $html .= '<li>' . "<a{$subm}{$menu} href=\"" .base_url()."{$menuData['items'][$itemId]['url']}\" title=\"{$menuData['items'][$itemId]['name']}\">{$menuData['items'][$itemId]['name']}</a>";

      // find childitems recursively
      $html .= buildMenu($itemId, $menuData);
      $html .= '</li>';
    }
    $html .= '</ul>';
  }
  return $html;
}

// output the <strong class="highlight">menu</strong>
echo buildMenu(0, $menuData);
?>
