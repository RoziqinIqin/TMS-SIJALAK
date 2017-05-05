<?php
class Query_model extends CI_Model
{
    function __construct()
	{
	    parent::__construct();
	}

    function query_sql($qname,$param)
    {
	$grs = $this->db->query("select fld_querysql from tbl_query where fld_querynm='$qname'");
	$lgrs = $grs->row();
	$gvrs = $this->db->query($lgrs->fld_querysql,$param);
	if ($gvrs->num_rows() > 0)
	{
		return $gvrs->result();
	}
    }

    function query_selector($qname,$param,$offset,$bind)
    {
	$queryid = $this->db->query("select fld_queryid from tbl_query where fld_querynm='$qname'");
				    $lqueryid = $queryid->row();
	$grs = $this->db->query("select fld_querysql from tbl_query where fld_querynm='$qname'");
	$lgrs = $grs->row();
	$sql = $lgrs->fld_querysql;
	$gvrs = $this->db->query(" $sql having name like '%$param%' limit $offset,20",$bind);
	if ($gvrs->num_rows() > 0)
	{
		return $gvrs->result();
	}
    }

    function query_selector_all($qname,$param,$bind)
    {
	$queryid = $this->db->query("select fld_queryid from tbl_query where fld_querynm='$qname'");
				    $lqueryid = $queryid->row();
	$grs = $this->db->query("select fld_querysql from tbl_query where fld_querynm='$qname'");
	$lgrs = $grs->row();
	$sql = $lgrs->fld_querysql;
	$gvrs = $this->db->query(" $sql having name like '%$param%'",$bind);
	if ($gvrs->num_rows() > 0)
	{
		return $gvrs->result();
	}
    }


}
