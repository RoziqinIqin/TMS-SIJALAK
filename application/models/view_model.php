<?php
class View_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  function getview($vname) {
    $gv = $this->db->query("select t0.*,t1.fld_querysql,t2.fld_formnm,t0.fld_viewauth  from tbl_view t0
    left join tbl_query t1 on t1.fld_queryid=t0.fld_queryid
    left join tbl_form t2 on t2.fld_formid=t0.fld_formsearch
    where t0.fld_viewnm='$vname' limit 1");
    if ($gv->num_rows() > 0) {
      return $gv->result();
    }
  }

  function getviewcol($vquery,$bind) {
     $sql = preg_replace("/<\/sq>/is","",$vquery);
     $sql = preg_replace("/<sq>/is","",$sql);
     $gvcol = $this->db->query("$sql limit 1",$bind);
     return $gvcol->list_fields();
  }

    function getauth($authsql)
  {
	$sql = $this->db->query("select fld_querysql from tbl_query where fld_queryid = $authsql");
	if ($sql->num_rows() > 0)
	    {
		foreach ($sql->result() as $row)
		{
		    $query = $row->fld_querysql;

		}
	    }
	$gauth = $this->db->query("$query");
	if ($gauth->num_rows() > 0)
	{
		return $gauth->result();
	}

  }

      function getviewrs($vquery,$offset,$rpp,$bind,$order,$sorting,$vorder)
  {
        $sql = preg_replace("/<\/sq>/is","",$vquery);
        $sql = preg_replace("/<sq>/is","",$sql);

        if ($order > 0)
        {
            $order = "order by $order $sorting";
        }
        else {
           $order = "$vorder";
        }
        $sql = "$sql $order limit $offset,$rpp";
        $gvrs = $this->db->query($sql,$bind);
        if ($gvrs->num_rows() > 0)
        {
                return $gvrs->result();
        }
  }

    function getviewnrow($vquery,$bind) {
      $sql = $vquery;
      $sql = preg_replace("/<sq>(.*?)<\/sq>/is","",$vquery);
      $sql = preg_replace("/select(.*?)from /is","select 1 from ", $sql,1);
      $gvnr = $this->db->query("$sql",$bind);
      if ($gvnr->num_rows() > 0) {
        return $gvnr->num_rows();
      }
    }

    function getbind($queryid)
  {
	$gbind = $this->db->query("select * from tbl_querybind t0 where t0.fld_queryid=$queryid order by t0.fld_querybindorder");
	if ($gbind->num_rows() > 0)
	{
		return $gbind->result();
	}
  }

}
